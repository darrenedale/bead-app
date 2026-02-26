<?php

namespace App\Commands;

use App\ConsoleApplication;
use App\Models\Migration as MigrationModel;
use Bead\Contracts\Database\Migration as MigrationContract;
use Bead\Exceptions\InvalidCommandLineArgumentException;
use Bead\Exceptions\InvalidConfigurationException;
use DirectoryIterator;
use InvalidArgumentException;

use function array_keys;
use function array_values;
use function arsort;
use function Bead\Helpers\I18n\tr;
use function class_exists;
use function in_array;
use function is_subclass_of;
use function ksort;
use function preg_match;
use function str_contains;
use function str_ends_with;
use function str_starts_with;
use function usleep;
use function usort;

/** Console command to manage database migrations. */
class Migrate extends ConsoleApplication
{
    private const DefaultMigrationsPath = "/app/Migrations";

    private const DefaultMigrationsNamespace = "\\App\\Migrations";

    /** @var string|null Lazy initialised on first access. */
    private ?string $migrationsPath = null;

    /** @var string|null Lazy initialised on first access. */
    private ?string $migrationsNamespace = null;

    /** Set the supported command-line args and description. */
    protected function configure(): void
    {
        $this->setDescription(tr("Manage the migrations for the app database."));
        $this->addArgument("action", tr("What you want to do with the migrations"), optional: true, default: "up");
        $this->addOption("count", description: tr("How many migrations do you want to execute (if not provided, all available will be executed)"), type: self::TypeInt, optional: true);
    }

    /** @return string The path where migration classes are stored, relative to the app's root directory. */
    private function migrationsPath(): string
    {
        if (null === $this->migrationsPath) {
            $path = $this->config("db.migrations.path", self::DefaultMigrationsPath);

            if (!str_starts_with($path, DIRECTORY_SEPARATOR)) {
                $path = DIRECTORY_SEPARATOR . $path;
            }

            if (!str_ends_with($path, DIRECTORY_SEPARATOR)) {
                $path = $path . DIRECTORY_SEPARATOR;
            }

            if (str_contains($path, DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR)) {
                throw new InvalidConfigurationException("db.migrations.path", tr("Migrations path must not contain any .. segments"));
            }

            $this->migrationsPath = $path;
        }

        return $this->migrationsPath;
    }

    /** The namespace for all migrations. */
    private function migrationsNamespace(): string
    {
        if (null === $this->migrationsNamespace) {
            $namespace = $this->config("db.migrations.namespace", self::DefaultMigrationsNamespace);

            if (!preg_match("/^(?:\\\\[a-zA-Z_][a-zA-Z0-9_]*)+\$/", $namespace)) {
                throw new InvalidConfigurationException("db.migrations.namespace", tr("Expected valid migrations namespace, found \"%1\"", __FILE__, __LINE__, $namespace));
            }

            $this->migrationsNamespace = $namespace;
        }

        return $this->migrationsNamespace;
    }

    /** Check whether the migrations table exists, and if not try to create it. */
    private function checkMigrationsTable(): void
    {
        $db = $this->database();
        $table = MigrationModel::table();

        if (0 === $db->query("SHOW TABLES LIKE '{$table}'")->rowCount()) {
            $db->query(
                <<<SQL
                CREATE TABLE
                    `{$table}`
                    (
                        migration VARCHAR(200) NOT NULL PRIMARY KEY,
                        description TEXT NOT NULL,
                        up_at BIGINT NOT NULL
                    )
                SQL
            );
        }
    }

    /**
     * @return string[] The names of applied migrations, in the reverse of the order they were applied (i.e. most
     * recently applied first).
     */
    private function appliedMigrationNames(): array
    {
        $migrations = [];

        foreach (MigrationModel::queryLike("migration", "%") as $migration) {
            // On 32-bit platforms the up_at timestamp is only measured in seconds so multiple migrations are likely to
            // share the same timestamp. To avoid indeterminate ordering we append the migration class - since this is
            // used to order the migrations when they are applied, appending it ensures that any migrations with the
            // same timestamp will be reverted in the reverse of the order in which they were applied
            $migrations[$migration->migration] = (8 <= PHP_INT_SIZE) ? $migration->up_at : "{$migration->up_at}-{$migration->migration}";
        }

        arsort($migrations);
        return array_keys($migrations);
    }

    /**
     * @return MigrationContract[] The applied migrations, in the reverse of the order they were applied (i.e. most
     * recently applied first.
     */
    private function appliedMigrations(): array
    {
        $migrations = [];

        foreach ($this->appliedMigrationNames() as $migrationName) {
            $migrations[] = new $migrationName();
        }

        return $migrations;
    }

    /** @return MigrationContract[] The pending migrations, in the order they should be applied. */
    private function pendingMigrations(): array
    {
        $appliedMigrations = $this->appliedMigrationNames();
        $pendingMigrations = [];

        foreach (new DirectoryIterator($this->rootDir() . $this->migrationsPath()) as $entry) {
            if ($entry->isDot() || str_starts_with($entry->getFilename(), ".")) {
                continue;
            }

            $className = "{$this->migrationsNamespace()}\\{$entry->getBasename(".php")}";

            if (in_array($className, $appliedMigrations)) {
                continue;
            }

            if (!class_exists($className)) {
                $this->errorLine(tr("File \"%1\" does not define the class \"%2\".", __FILE__, __LINE__, $entry->getFilename(), $className));
                continue;
            }

            if (!is_subclass_of($className, MigrationContract::class)) {
                $this->errorLine(tr("Class \"%1\" is not a migration class.", __FILE__, __LINE__, $className));
                continue;
            }

            $pendingMigrations[$className] = new $className();
        }

        ksort($pendingMigrations);
        return array_values($pendingMigrations);
    }

    /**
     * Fetches the migration count requested on the command line.
     *
     * Returns null if no count was requested (which means do all of them), the count if valid (must be > 0), or throws
     * if the count requested was not valid.
     *
     * @return int|null
     */
    private function requestedCount(): ?int
    {
        $count = $this->optionValue("count");

        if (null === $count) {
            return null;
        }

        if (1 > $count) {
            throw new InvalidCommandLineArgumentException("Expected migration count > 0, found {$count}");
        }

        return $count;
    }

    /** Apply one or more pending migrations. */
    private function migrateUp(): int
    {
        // guaranteed to be null or > 0
        $count = $this->requestedCount();

        foreach ($this->pendingMigrations() as $migration) {
            $this->write($migration::class . " ... ", $this->outStream());
            $migration->up($this->database());

            MigrationModel::create([
                "migration" => $migration::class,
                "description" => $migration->description(),
                // we can't use (int) cast for microtime on 32-bit platforms so we have to use time()
                "up_at" => (8 <= PHP_INT_SIZE ? (int) (microtime(true) * 1000) : time()),
            ]);

            $this->line(tr("UP"));

            // ensure migration timestamps are at least 1ms apart
            usleep(1000);

            if (null === $count) {
                continue;
            }

            --$count;

            if (0 === $count) {
                break;
            }
        }

        return self::ExitOk;
    }

    /** Revert one or more applied migrations. */
    private function migrateDown(): int
    {
        // guaranteed to be null or > 0
        $count = $this->requestedCount();

        foreach ($this->appliedMigrations() as $migration) {
            $this->write($migration::class . " ... ", $this->outStream());
            $migration->down($this->database());
            MigrationModel::removeEquals("migration", $migration::class);
            $this->line(tr("DOWN"));

            if (null === $count) {
                continue;
            }

            --$count;

            if (0 === $count) {
                break;
            }
        }

        return self::ExitOk;
    }

    /** Fetch the class name of the most recently applied migration. */
    private function currentMigration(): string
    {
        $models = MigrationModel::queryLike("migration", "%");
        usort($models, static fn (MigrationModel $migration1, MigrationModel $migration2): int => -($migration1->up_at <=> $migration2->up_at));
        return $models[0]?->migration ?? "unmigrated";
    }

    /** Run the command. */
    public function run(): int
    {
        $this->checkMigrationsTable();

        $exitCode = match ($this->argumentValue("action")) {
            "up" => $this->migrateUp(),
            "down" => $this->migrateDown(),
            default => throw new InvalidArgumentException("Unrecognised action \"{$this->argumentValue("action")}\"."),
        };

        $this->line(tr("Now at %1", __FILE__, __LINE__, $this->currentMigration()));
        return $exitCode;
    }
}

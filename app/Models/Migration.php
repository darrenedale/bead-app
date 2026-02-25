<?php

declare(strict_types=1);

namespace App\Models;

use Bead\Database\Model;

/**
 * A database model representing an applied migration.
 *
 * If you need to customise the migrations table, you can do so in this model (and maybe also the Migrate command).
 *
 * @property string $migration The fully-qualified migration class name
 * @property string $description The migration's description.
 * @property int $up_at The timestamp at which the migration was applied. On 32-bit platforms this is the UNIX
 * timestamp; on 64-bit and larger platforms this is the millisecond UNIX timestamp.
 */
class Migration extends Model
{
    protected static string $table = "bead_migrations";

    protected static array $properties = [
        "migration" => "string",
        "description" => "string",
        "up_at" => "int",
    ];
}

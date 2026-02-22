<?php

declare(strict_types=1);

namespace App\Models;

use Bead\Database\Model;

/**
 * A database model representing an applied migration.
 *
 * If you need to customise the migrations table, you can do so in this model (and maybe also the Migrate command).
 */
class Migration extends Model
{
    protected static string $table = "bead_migrations";

    protected static array $properties = [
        "migration" => "string",
        "description" => "string",
        "up_at" => "datetime",
    ];
}

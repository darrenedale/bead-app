<?php

declare(strict_types=1);

namespace App\Models;

use Bead\Database\Model;

class User extends Model
{
    protected static string $table = "users";

    protected static array $properties = [
        "id" => "int",
        "email" => "string",
        "password" => "string",
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "deleted_at" => "datetime",
    ];
}

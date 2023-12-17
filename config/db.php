<?php

use Bead\Facades\Environment as Env;

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which DBMS does your app use?
     *
     * Currently MySQL, Postgres and MSSQL are supported.
     */
    "driver" => "mysql",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Configure the connection to your MySQL database
     * 
     * This is only used if driver above is set to mysql.
     */
    "mysql" => [
        "host" => Env::get("BEAD_APP_MYSQL_HOST") ?: "localhost",
        "port" => Env::get("BEAD_APP_MYSQL_PORT") ?: 3306,
        "name" => Env::get("BEAD_APP_MYSQL_NAME") ?: "bead_app_database",
        "user" => Env::get("BEAD_APP_MYSQL_USER"),
        "password" => Env::get("BEAD_APP_MYSQL_PASSWORD"),
    ],
];

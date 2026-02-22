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

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Configure how database migrations work
     *
     * Here you can set where in your repository the migration class files
     * live and what their namespace is in your app.
     */
    "migrations" => [
        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Where the migration class source files live.
         *
         * This is relative to the app's root directory. It must not contain any
         * .. segments - the migrations must be within your app's directory tree.
         */
        "path" => "/app/Migrations",

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * The namespace for the migrations in your app.
         *
         * The namespace must start with a backslash, and must not end with one.
         */
        "namespace" => "\\App\\Migrations",
    ],
];

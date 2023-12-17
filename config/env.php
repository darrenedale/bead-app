<?php

declare(strict_types=1);

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Set the sources to use for environment variables
     *
     * Your app always has access to the actual environment variables set on
     * the server, as well as those in the .env file in your project's root.
     * Here you can specify as many other sources of environment variables as
     * you need.
     */
    "environments" => ["version",],

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Define the available sources of environment variables
     *
     * Each available source is keyed with its name. To use the defined
     * source, add its name to the "environments" option above. Each source
     * must have at least the "driver" option specified, which may be "file",
     * "array" or "environment". It may have other elements defined, which
     * specify the configuration for the source
     */
    "sources" => [
        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * As an example, this is how you would include the system variables.
         *
         * The system environment is always imported into your app, but if they
         * weren't, this is how you'd import them as an environment source.
         */
        "env" => [
            "driver" => "environment",
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Import the .version.env file
         *
         * Maybe you populate this variable during your build, CI or CD process to
         * the build's release tag or commit hash. You can import that file into
         * your app's environment and use it, for example, to set the
         * Application's version.
         */
        "version" => [
            "driver" => "file",
            "path" => ".version.env",
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Import environment variables from a PHP array
         *
         * The PHP array in env will be used to add variables to your app's
         * environment. Keys must all be strings - non-string kyes will trigger an
         * InvalidConfigurationException
         */
        "fixed" => [
            "driver" => "array",
            "env" => [
                // "bead" => "framework",
            ],
        ],
    ],
];

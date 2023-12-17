<?php

declare(strict_types=1);

use Bead\Contracts\Logger as LoggerContract;
use Bead\Logging\FileLogger;

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which of the defined logs should be used.
     *
     * This can be a single name, or an array of names to log to multiple
     * destinations at once.
     */
    "loggers" => "file",

    "logs" => [
        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Configure a file logger.
         *
         * This uses the file driver, and stores log messages in a file inside the
         * App's root directory. You can log to multiple files by creating
         * additional logs with different names using the file driver logging to
         * different files.
         */
        "file" => [
            "driver" => "file",

            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
             * The file to log to.
             *
             * If this file does not exist, it will be created. If it's a relative
             * path, it's considered relative to the app's root directory. You can't
             * use .. in the path to traverse the filesystem hierarchy.
             *
             * You need to ensure the directory already exists, the FileLogger won't
             * create it automatically.
             */
            "path" => "data/logs/bead-app.log",

            /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
             * How to open the log file
             *
             * Usually you'll want to append to the log file, but you can use
             * FlagOverwrite if you need to.
             */
            "flags" => FileLogger::FlagAppend,
            "level" => LoggerContract::ErrorLevel,
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Configure a logger to log to standard error output.
         *
         * There's nothing to stop you from having several logs using the stderr
         * driver with different names, but it's probably of little value.
         */
        "stderr" => [
            "driver" => "stderr",
            "level" => LoggerContract::ErrorLevel,
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Configure a logger to log to standard output.
         *
         * There's nothing to stop you from having several logs using the stdout
         * driver with different names, but it's probably of little value.
         */
        "stdout" => [
            "driver" => "stdout",
            "level" => LoggerContract::ErrorLevel,
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Configure a logger to log to nowhere.
         *
         * This may be of use when you have to have a logger, but you don't
         * actually want to log anything.
         */
        "null" => [
            "driver" => "null",
        ],
    ],
];

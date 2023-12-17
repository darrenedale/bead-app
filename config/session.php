<?php

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which session handler to use
     *
     * Current options are "file" and "php"
     */
    "handler" => "file",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * The lifetime of a session ID in seconds.
     *
     * When a session ID's lifetime ends it's regenerated. This does not end
     * the session, it just assigns it a fresh ID. This helps mitigate session
     * stealing by limiting the amount of time for which any stolen session ID
     * is usable without ending the session itself.
     */
    "id-regeneration-period" => 300,

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Grace period for expired IDs.
     *
     * Once it's been determined that a session ID needs to be regenerated,
     * this item determines how long the old session ID will be accepted and
     * upgraded to the regenerated ID.
     */
    "expired.grace-period" => 60,

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Where to store session files
     *
     * When the file session handler is in use, this is where the session
     * files are stored. It's a path relative to the app's root directory.
     */
    "handlers.file.directory" => "data/session",
];

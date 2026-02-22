<?php

declare(strict_types=1);

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which hashing algorithm to use
     *
     * This can be either bcrypt or argon. The argon hasher uses the ARGON2ID
     * algorithm. The selection of driver determines which other options are
     * valid in this file.
     */
    "driver" => "argon",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Options for the argon hasher
     */
    "memory_cost" => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
    "time_cost" => PASSWORD_ARGON2_DEFAULT_TIME_COST,

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Options for the bcrypt hasher
     */
//    "cost" => PASSWORD_BCRYPT_DEFAULT_COST,
];

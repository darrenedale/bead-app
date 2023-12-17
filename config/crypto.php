<?php

use Bead\Facades\Environment as Env;

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which crypto backend to use
     *
     * This can be sodium or openssl. The two backends have different
     * requirements for valid keys, so be sure to check.
     */
    "driver"=> "sodium",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Your app's encryption key.
     *
     * You should not set this directly in this file, you should read it from
     * and environment variable so that the key is never stored in your repo.
     */
    "key" => Env::get("BEAD_APP_ENCRYPTION_KEY"),

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which OpenSSL algorithm to use for the cipher.
     *
     * The is only used if you set the crypto backend to openssl.
     */
//    "algorithm" => "",
];

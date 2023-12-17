<?php

declare(strict_types=1);

use Bead\Facades\Environment as Env;

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * The Bead\Core\Binders\MailTransport binder will read this configuration
 * and bind a mail transport to the Transport contract.
 *
 */
return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Which of the defined transports to use.
     *
     * If your app doesn't need to mail, or you have another means of mailing,
     * just comment this out.
     */
//    "transport" => "mailgun",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * The transport definitions.
     *
     * Currently supported drivers are php, which will transport mail using
     * the PHP mail() function; and mailgun, which requires mailgun to be
     * installed and will use the Mailgun HTTP API to transport messages.
     */
    "transports" => [
        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * No configuration is required for using PHP mail() transport.
         */
        "php" => [
            "driver" => "php",
        ],

        /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
         * Basic configuration for using Mailgun transport.
         *
         * The endpoint is optional, and will default to api.mailgun.net if not
         * given. domain and key are required, and should be set to the domain you
         * have registered on mailgun for sending, and the API key you've set up
         * there to authenticate.
         */
        "mailgun" => [
            "driver" => "mailgun",
            "domain" => Env::get("BEAD_APP_MAILGUN_DOMAIN"),
            "key" => Env::get("BEAD_APP_MAILGUN_KEY"),
            "endpoint" => Env::get("BEAD_APP_MAILGUN_ENDPOINT"),
        ],
    ],
];

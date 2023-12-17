<?php

use Bead\Core\Binders\Crypter;
use Bead\Core\Binders\Database;
use Bead\Core\Binders\Environment;
use Bead\Core\Binders\MailTransport;
use Bead\Core\Binders\Logger;
use Bead\Core\Binders\Translator;
use Bead\Facades\Environment as Env;
use Bead\Web\RequestProcessors\CheckMaintenanceMode;

return [
    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Put the application in debug mode
     *
     * In debug mode more log messages will be written. When set, the
     * Application::isInDebugMode() method will return `true`.
     */
    "debugmode" => (bool) (Env::get("BEAD_APP_DEBUG_MODE") ?: true),

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Put the application in maintenance mode
     *
     * In maintenance mode the CheckMaintenanceMode request preprocessor will
     * intercept all requests and respond with the maintenance page.
     */
    "maintenance" => (bool) Env::get("BEAD_APP_MAINTENANCE_MODE"),

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Set the application's language
     *
     * The translator will look for translation files for this language when
     * translating strings.
     */
    "language" => Env::get("BEAD_APP_LANGUAGE") ?: "en-GB",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Set the application's time zone
     *
     * The time zone can be any time zone string that PHP's DateTime classes
     * support.
     */
    "timezone" => Env::get("BEAD_APP_TIMEZONE") ?: "europe/london",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Set the application's title
     *
     * The Application::title() method returns this string.
     */
	"title" => Env::get("BEAD_APP_TITLE") ?: "Bead Framework App",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * The base URL of the application.
     *
     * In most cases the default worked out from the $_SERVER superglobal is
     * fine, but you can override it in your environment variables or directly
     * here if you wish.
     */
    "base_url" => Env::get("BEAD_APP_BASE_URL") ?: (($_SERVER["SERVER_NAME"] ?? "localhost") . (!in_array(($_SERVER["SERVER_PORT"] ?? 443), [80, 443,]) ? ":" . $_SERVER["SERVER_PORT"] : "")),

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Where to look for HTTP error views.
     *
     * When HttpExceptions are thrown, the error handler will look here for a
     * view that corresponds to the HTTP status code and respond with that if
     * it finds one.
     */
    "http.error.view.path" => "errors",

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * The set of service binders to execute when booting your app
     *
     * The Application::title() method returns this string.
     */
    "binders" => [
        Logger::class,
//        Database::class,
        Crypter::class,
        Environment::class,
//        MailTransport::class,
        Translator::class,
    ],

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Set additional request pre- and post-processors
     *
     * Preprocessors see the request before it's routed and can intercept and
     * respond without routing the request; Postprocessors get to see the
     * request and the response generated after it was routed, and can replace
     * or alter the response.
     *
     * The CheckCsrfToken preprocessor is automatically added by the Bead Web
     * Application when it's constructed.
     */
    "processors" => [
        CheckMaintenanceMode::class,
    ],

    /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Configure whether plugins are enabled and loaded in your app
     *
     * Plugins are supported primarily for legacy reasons.
     */
    "plugins" => [
        "enabled" => false,
    ],
];

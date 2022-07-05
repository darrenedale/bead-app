<?php

/**
 * @var \Equit\WebApplication $app
 * @var \Equit\Contracts\Router $router
 */

use \App\Controllers\HomeController;

$router->registerAny("/", [HomeController::class, "showHomePage"]);

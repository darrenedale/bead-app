<?php

/**
 * @var Application $app
 * @var Router $router
 */

use App\Controllers\HomeController;
use Bead\Contracts\Router;
use Bead\Web\Application;

$router->registerAny("/", [HomeController::class, "showHomePage",]);

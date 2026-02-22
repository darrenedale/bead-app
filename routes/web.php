<?php

/**
 * @var Application $app
 * @var RouterContract $router
 */

use App\Controllers\HomeController;
use Bead\Contracts\Web\Router as RouterContract;
use Bead\Web\Application;

$router->registerAny("/", [HomeController::class, "showHomePage",]);

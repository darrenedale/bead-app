<?php

use App\WebApplication;
use Bead\Facades\Environment as Env;

require_once(__DIR__ . "/../bootstrap.php");

$app = new WebApplication();
$app->setVersion(Env::get("BEAD_APP_VERSION") ?? "?");
$app->exec();

<?php

/**
 * The main HTML layout for the app.
 *
 * Views can use this layout for consistent page structure across the app. Content for each view can be defined in the
 * `main` section. If your views need to place scripts or stylesheets in the <head> section, push to the `scripts` and
 * `styles` stacks.
 *
 * See `views/home.php` for an example.
 *
 * @var \Equit\WebApplication $app The Application instance.
 */

use Equit\View;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= html($app->config("app.title")) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="/styles/app.css" />
    <?php View::stack("styles"); ?>
    <?php View::stack("scripts"); ?>
</head>

<body>

    <header id="app-header">
        <img class="header-logo" src="/images/bead-logo.png" alt="Logo" title="<?= html($app->config("app.title")) ?>" />
        <h1><?= html($app->config("app.title")) ?></h1>
    </header>

    <section id="app-main" class="main">
        <?php View::yieldSection("main"); ?>
    </section>

    <footer id="app-footer">
    </footer>

</body>
</html>

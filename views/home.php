<?php

/**
 * The home page view.
 *
 * The home page view uses the main layout, providing the custom content for the home page in the `main` section.
 *
 * @var \Equit\WebApplication $app The Application instance.
 */

use Equit\View;

?>
<?php View::layout("layouts.main"); ?>

<?php View::section("main"); ?>
<p>
    This app is running on the
    <a href="https://github.com/darrenedale/bead-framework" title="See the bead framework on GitHub.">Bead framework</a>.
</p>

<p>
    Bead is a lightweight PHP MVC web application framework with built-in ORM, validation and error handling.
</p>
<?php View::endSection(); ?>

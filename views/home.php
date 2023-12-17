<?php

/**
 * The home page view.
 *
 * The home page view uses the main layout, providing the custom content for the home page in the `main` section.
 *
 * @var Application $app The Application instance.
 */

use Bead\View;
use Bead\Web\Application;

?>
<?php View::layout("layouts.main"); ?>

<?php View::section("main"); ?>
<p>
    <?= html(tr("home.intro.para1.1")) ?>
    <a href="https://github.com/darrenedale/bead-framework" title="<?= html(tr("See the bead framework on GitHub.")) ?>">Bead framework</a>.
</p>

<p>
    <?= html(tr("home.intro.para2")) ?>
</p>
<?php View::endSection(); ?>

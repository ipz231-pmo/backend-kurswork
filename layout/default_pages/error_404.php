<?php
/**
 * Page parameters
 * @var string $title
 * @var array $styles
 * @var string $pageIcon
 * @var array $scripts
 *
 * @var string|null $message
 */



?>


<div>
    <div class="container">
        <h1 class="h1 pb-2">Error 404, Page Not Found</h1>
        <div class="h4">The following page can't be found</div>
        <?php if (isset($message)): ?>
            <div class="h5"><?= $message ?></div>
        <?php endif; ?>
    </div>
</div>

<?php
?>


<div class="bg-secondary flex-fill">
    <div class="container">
        <h1 class="h1 pb-2">Error 404, Page Not Found</h1>
        <p class="h3">The following page can't be found</p>
        <?php if (isset($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
    </div>
</div>

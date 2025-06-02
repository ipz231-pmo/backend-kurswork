<?php

/**
 * @var array $item
 */


?>

<div class="container my-5">
    <div class="mb-4">
        <a href="/news" class="text-decoration-none text-primary">&larr; Назад до новин</a>
    </div>

    <article class="card shadow-sm border-0">
        <div class="card-body">
            <h1 class="card-title"><?= htmlspecialchars($item['title']) ?></h1>
            <?php if($item['date']): ?>
            <p class="text-muted small"><?= date('d.m.Y', strtotime($item['date'])) ?></p>
            <?php endif; ?>
            <div class="card-text mt-3">
                <?= nl2br(htmlspecialchars($item['text'])) ?>
            </div>
        </div>
    </article>
</div>
<?php

/**
 * @var array $news
 * @var int $currentPage
 * @var int $pagesCount
 */

?>

<div class="container my-5">
    <h1 class="mb-4">Новини</h1>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($news as $item): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                        <?php if ($item['date']): ?>
                        <p class="card-text text-muted small"><?= date('d.m.Y', strtotime($item['date'])) ?></p>
                        <?php endif; ?>
                        <p class="card-text"><?= htmlspecialchars($item['shortText']) ?></p>
                        
                        <a href="/news/item?id=<?= $item['id'] ?>"
                           class="btn btn-outline-primary mt-2">Детальніше</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($pagesCount > 1): ?>
        <nav class="mt-5 d-flex justify-content-center">
            <div class="d-flex flex-wrap gap-2">
                <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
                    <?php $isActive = $i == $currentPage ? "bg-warning text-dark" : "bg-light text-secondary"; ?>
                    <a href="/news?page=<?= $i ?>"
                       class="d-inline-flex justify-content-center align-items-center rounded <?= $isActive ?>"
                       style="width: 40px; height: 40px; text-decoration: none;">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        </nav>
    <?php endif; ?>
</div>



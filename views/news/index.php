<?php

/**
 * @var array $news
 * @var int $currentPage
 * @var int $pagesCount
 */

?>


<div>
    <div class="container">
        <h1>NewsController -> actionIndex</h1>
        <h2>Pages Count: <?= $pagesCount ?></h2>
        <h2>Current Page: <?= $currentPage ?></h2>
        
        <div class="my-4">
            <div>
                <?php foreach ($news as $item): ?>
                <div class="py-5">
                    <h2><?= $item['title'] ?></h2>
                    <p><?= $item['shortText'] ?></p>
                    <a href="/news/item?id=<?= $item['id']?>">Learn More</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div>
            <?php for($i = 1; $i <= $pagesCount; $i++): ?>
            <?php $bg = $i == $currentPage ? "bg-warning" : 'bg-secondary'; ?>
            <a href="/news?page=<?= $i ?>" class="p-3 bg-secondary rounded <?= $bg?> ">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
        
    </div>
</div>

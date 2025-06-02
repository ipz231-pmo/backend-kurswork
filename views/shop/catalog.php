<?php
/**
 * @var array $items
 */

$this->title = "Catalog";
$this->styles = ["/css/views/catalog.css"];

?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Catalog</h2>
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <!-- Display Category Icon -->
                        <div class="mb-3">
                            <?php if ($item['iconPath']): ?>
                                <img src="<?= $item['iconPath'] ?>" alt="<?= $item['name'] ?> Icon" class="img-fluid">
                            <?php else: ?>
                                <img src="/images/icon-no-image.png" alt="No Icon" class="img-fluid">
                            <?php endif; ?>
                        </div>
                        <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                        <a href="/shop?category=<?= urlencode($item['urlName']) ?>" class="btn btn-primary mt-auto">View Category</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

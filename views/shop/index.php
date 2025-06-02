<?php
/**
 * @var array $items
 * @var array $category
 */
?>

<div>
    <div class="container">
        <div>
            <div class="text-secondary">
                <a href="/shop/catalog" class="text-decoration-none text-secondary">Планове ТО</a>
                &#8594;
                <a href="/shop?category=<?= $category['urlName'] ?>" class="text-decoration-none text-black"><?= $category['name'] ?></a>
            </div>
            <div class="h3"><?= $category['name'] ?></div>
        </div>
        <div class="row">
            <div class="col-3 bg-secondary p-3">
                <p class="m-0">Parameters filtering</p>
            </div>
            <div class="col-9">
                <div class="ps-4">
                    <div class="d-flex justify-content-between">Find</div>
                    <?php foreach ($items as $item): ?>
                    <div class="row mb-5" style="height: 250px">
                        <img src="https://cdn-icons-png.flaticon.com/512/2296/2296882.png" alt="product image" class="col-3"  >
                        <div class="col-5">
                            <p class="h5 m-0"><?= $item['name'] ?></p>
                        </div>
                        <div class="col-4">
                            <p class="h5 m-0 mb-3"><?= $item['price'] ?> <span class="text-secondary h6">грн</span></p>
                            <button class="border-0 bg-primary w-100 rounded-1 py-2">Купити</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

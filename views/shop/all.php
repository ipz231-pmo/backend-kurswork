<?php
/**
 * @var array $items
 */
?>

<div>
    <div class="container">
        <div class="row ">
            <div class="col-3 bg-secondary p-3">
                <p class="m-0">Parameters filtering</p>
            </div>
            <div class="col-9">
                <div class="d-flex justify-content-between">
                    <p class="m-0">
                        Find
                    </p>
                    <div>
                    
                    </div>
                </div>
                <?php foreach ($items as $item): ?>
                <div>
                    <h2><?= $item['name'] ?></h2>
                    <img src="https://cdn-icons-png.flaticon.com/512/2296/2296882.png" alt="product image">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

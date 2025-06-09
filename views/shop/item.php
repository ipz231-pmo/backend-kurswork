<?php

/**
 * Page parameters
 * @var string $title
 * @var array $styles
 * @var string $pageIcon
 * @var array $scripts
 *
 * @var array $item // id, name, description, price, imageUrl
 * @var array|null $category // id, name, description, urlName, iconPath
 * @var bool $cartHasItem // array of ids
 * @var array|null $user
 */

$this->scripts = array_merge($this->scripts, ["/js/shop/item.js"]);

if ($user === null) $this->scripts = array_merge($this->scripts, ["/js/shop/item/notAuthorized.js"]);
if ($user !== null && !$cartHasItem) $this->scripts = array_merge($this->scripts, ["/js/shop/item/cartDoesntHaveItem.js"]);
if ($user !== null && $cartHasItem) $this->scripts = array_merge($this->scripts, ["/js/shop/item/cartHasItem.js"]);

?>






<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="border rounded-3 p-3">
                    <img src="<?= htmlspecialchars($item['imageUrl'] ? $item['imageUrl'] : '/images/icon-no-image.png') ?>"
                         class="img-fluid w-100"
                         alt="<?= htmlspecialchars($item['name']) ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Breadcrumbs -->
                <?php if (isset($category)): ?>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/shop/catalog">Catalog</a></li>
                            <li class="breadcrumb-item"><a href="/shop?category=<?= urlencode($category['urlName']) ?>"><?= htmlspecialchars($category['name']) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($item['name']) ?></li>
                        </ol>
                    </nav>
                <?php endif; ?>

                <h1 class="display-5"><?= htmlspecialchars($item['name']) ?></h1>
                <div class="my-4">
                    <span class="h2 fw-bold"><?= number_format($item['price'], 2) ?></span>
                    <span class="text-muted h4">грн</span>
                </div>
                <p class="lead text-muted"><?= nl2br($item['description']) ?></p>
                <hr>
                
                <div id="add-to-cart-layout">
                    <?php if ($user !== null && !$cartHasItem): ?>
                            <div class="d-flex align-items-center gap-3 my-4">
                                <div class="form-group" style="width: 100px;">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" id="quantity" class="form-control text-center" value="1" min="1">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label class="form-label"> </label>
                                    <button class="btn btn-primary btn-lg w-100" id="add-to-cart-btn" data-good-id="<?= $item['id'] ?>">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                    <?php endif; ?>
                    
                    <?php if($user !== null && $cartHasItem): ?>
                        <div class="my-4">
                            <button id="open-cart-btn" class="btn btn-primary btn-lg w-100">Already in cart</button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($user === null): ?>
                        <div class="alert alert-info my-4">
                            <div class="h6 mb-3">Please login to add items to your cart.</div>
                            <button id="show-login-window-btn-from-item" class="btn btn-primary">Login</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>






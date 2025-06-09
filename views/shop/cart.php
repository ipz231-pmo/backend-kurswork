<?php
/**
 * Page parameters
 * @var string $title
 * @var array $styles
 * @var string $pageIcon
 * @var array $scripts
 *
 * Auth
 * @var array $user
 *
 * Cart Info
 * @var array $items
 */

?>

<div style="width: 800px; max-height: 80vh;" class="d-flex flex-column border rounded-2 bg-white shadow-lg" id="cart">
    <div class="p-4 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="m-0">Your Shopping Cart</h2>
            <button id="close-cart-btn" class="btn-close" aria-label="Close"></button>
        </div>
    </div>

    <div class="p-4 flex-grow-1" style="overflow-y: auto;">
        <?php if (empty($items)): ?>
            <div class="text-center py-5">
                <p class="h4 text-muted">Your cart is empty.</p>
                <p>Looks like you haven't added anything to your cart yet.</p>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php
                $grandTotal = 0;
                foreach ($items as $item):
                    $itemTotal = $item['price'] * $item['goodQuantity'];
                    $grandTotal += $itemTotal;
                    ?>
                    <div class="list-group-item px-0 py-3">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img src="<?= htmlspecialchars(empty($item['imageUrl']) ? '/images/icon-no-image.png' : $item['imageUrl']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-4">
                                <h5 class="mb-1"><?= htmlspecialchars($item['name']) ?></h5>
                                <p class="mb-0 text-muted small">
                                    <?= htmlspecialchars(number_format($item['price'], 2)) ?> грн
                                </p>
                            </div>
                            <div class="col-3">
                                <div class="input-group" style="width: 130px;">
                                    <input type="number"
                                           class="form-control text-center cart-item-quantity"
                                           value="<?= htmlspecialchars($item['goodQuantity']) ?>"
                                           min="1"
                                           data-good-id="<?= $item['id'] ?>"
                                           aria-label="Quantity">
                                    <button class="btn btn-outline-danger remove-from-cart-btn"
                                            type="button"
                                            title="Remove item"
                                            data-good-id="<?= $item['id'] ?>">
                                        ×
                                    </button>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <strong class="h5"><?= htmlspecialchars(number_format($itemTotal, 2)) ?> грн</strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($items)): ?>
        <div class="p-4 border-top bg-light">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <h4 class="me-4 mb-0">Grand Total:</h4>
                <h3 class="mb-0"><strong id="grand-total-price"><?= htmlspecialchars(number_format($grandTotal, 2)) ?> грн</strong></h3>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-secondary" id="close-cart-btn-2">Continue Shopping</button>
                <a href="/shop/placeOrder" class="btn btn-primary btn-lg">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
</script>



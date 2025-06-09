<?php
/**
 * @var string $title
 * @var array|null $user
 * @var array $items
 * @var float $totalPrice
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 m-0 py-2">Confirm Your Order</h2>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <div class="h4 mb-2">Items</div>
                        <div>
                            <?php foreach ($items as $item) : ?>
                            <?php
                            $name = $item['name'];
                            $price = $item['price'];
                            $quantity = $item['quantity'];
                            $total = $price * $quantity;
                                ?>
                                <div class="mb-3">
                                    <div class="h5 text-primary"><?= $name ?></div>
                                    <div><?= $quantity ?> * <?= $price ?> грн = <?= $total ?> грн</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="h5">Total: <span class="text-primary"><?= $totalPrice ?> грн</span></div>
                    </div>
                    <div>
                        <p class="h6 text-muted">Please confirm or provide your contact and shipping information below.</p>
                        
                        <form id="order-form">
                            <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Contact Phone</label>
                                <input type="tel" class="form-control" id="phone" placeholder="e.g., +380123456789" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="postalIndex" class="form-label">Postal Index</label>
                                <input type="text" class="form-control" id="postalIndex" placeholder="e.g., 01001" value="<?= htmlspecialchars($user['mailIndex'] ?? '') ?>" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" id="place-order-btn" class="btn btn-primary btn-lg">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
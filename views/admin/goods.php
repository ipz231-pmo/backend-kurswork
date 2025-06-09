<?php
/**
 * @var array $items
 * @var string $title
 */

$this->scripts = array_merge($this->scripts, ['/js/admin/goods.js']);

?>

<div class="container my-5">
    <h1 class="mb-4"><?= $title ?></h1>
    
    <!-- Create Goods Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h4 class="m-0">Create New Item</h4>
        </div>
        <div class="card-body">
            <form id="create-goods-form">
                <div class="mb-3">
                    <label for="create-name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="create-name" required>
                </div>
                <div class="mb-3">
                    <label for="create-description" class="form-label">Description</label>
                    <textarea class="form-control" id="create-description" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label for="create-price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="create-price">
                </div>
                <div class="mb-3">
                    <label for="create-imageUrl" class="form-label">Image Path</label>
                    <input type="text" class="form-control" id="create-imageUrl">
                </div>
                <button type="submit" class="btn btn-primary">Create Item</button>
            </form>
        </div>
    </div>
    
    <!-- Existing News Table -->
    <h2 class="mb-3">Existing News</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 35%;">Description</th>
                <th style="width: 15%;">Price</th>
                <th style="width: 15%;">imageUrl</th>
            </tr>
            </thead>
            <tbody id="goods-table-body">
            <?php foreach ($items as $item): ?>
                <tr data-id="<?= $item['id'] ?>">
                    <form class="update-goods-form">
                        <td>
                            <?= $item['id'] ?>
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        </td>
                        <td><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']) ?>" required></td>
                        <td><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($item['description']) ?></textarea></td>
                        <td><input type="text" name="price" class="form-control" value="<?= htmlspecialchars($item['price']) ?>"></td>
                        <td><input type="text" name="imageUrl" class="form-control" value="<?= htmlspecialchars($item['imageUrl']) ?>"></td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm mb-2 w-100">Save</button>
                            <button type="button" class="btn btn-danger btn-sm w-100 delete-btn">Delete</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</div>

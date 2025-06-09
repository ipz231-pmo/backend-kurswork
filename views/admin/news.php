<?php
/**
 * @var array $items
 * @var string $title
 */

$this->scripts = array_merge($this->scripts, ['/js/admin/news.js']);


?>

<div class="container my-5">
    <h1 class="mb-4"><?= $title ?></h1>

    <!-- Create News Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h4 class="m-0">Create New Item</h4>
        </div>
        <div class="card-body">
            <form id="create-news-form">
                <div class="mb-3">
                    <label for="create-title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="create-title" required>
                </div>
                <div class="mb-3">
                    <label for="create-shortText" class="form-label">Short Text</label>
                    <input type="text" class="form-control" id="create-shortText">
                </div>
                <div class="mb-3">
                    <label for="create-text" class="form-label">Full Text</label>
                    <textarea class="form-control" id="create-text" rows="4"></textarea>
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
                <th style="width: 20%;">Title</th>
                <th style="width: 25%;">Short Text</th>
                <th style="width: 35%;">Full Text</th>
                <th style="width: 15%;">Actions</th>
            </tr>
            </thead>
            <tbody id="news-table-body">
            <?php foreach ($items as $item): ?>
                <tr data-id="<?= $item['id'] ?>">
                    <form class="update-news-form">
                        <td>
                            <?= $item['id'] ?>
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        </td>
                        <td><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($item['title']) ?>" required></td>
                        <td><input type="text" name="shortText" class="form-control" value="<?= htmlspecialchars($item['shortText']) ?>"></td>
                        <td><textarea name="text" class="form-control" rows="3"><?= htmlspecialchars($item['text']) ?></textarea></td>
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
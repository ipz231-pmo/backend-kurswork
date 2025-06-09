<?php
/**
 * @var string $title
 * @var array $styles
 * @var array $scripts
 * @var string $content
 * @var string $pageIcon
 * @var array|null $user
 *
 * @var array $headerCategories
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="icon" type="image/svg" href="<?= $pageIcon ?>">
    
    <?php foreach ($styles as $style): ?>
    <link rel="stylesheet" type="text/css" href="<?= $style ?>">
    <?php endforeach; ?>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    <link rel="stylesheet" href="/css/templates/page.css">
    
    <?php if ($user === null): ?>
        <link rel="stylesheet" href="/css/login.css">
    <?php else: ?>
        <link rel="stylesheet" href="/css/logout.css">
    <?php endif; ?>
</head>
<body>

<!-- Main Layout -->
<div class="d-flex flex-column min-vh-100">
    
    <?php $this->renderComponent("layout/templates/header.php") ?>
    
    <div class="flex-fill">
        <?= $content ?>
    </div>
    
    <?php $this->renderComponent("layout/templates/footer.php") ?>
    
</div>

<!-- Cart Layout -->
<div
        id="cart-layout"
        class="fixed-top vh-100 vw-100 d-none d-flex align-items-center justify-content-center">
    <div id="cart"></div>
</div>

<!-- Register Layout -->
<?php $this->renderComponent("layout/templates/register.php") ?>


<script src="https://unpkg.com/htmx.org@2.0.4"></script>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>


<?php if ($user !== null): ?>
<script src="/js/cart.js"></script>
<?php endif; ?>

<?php if ($user === null): ?>
    <script src="/js/login.js"></script>
    <script src="/js/register.js"></script>
<?php else: ?>
    <script src="/js/logout.js"></script>
<?php endif; ?>

<?php foreach ($scripts as $script): ?>
<script src="<?=$script?>"></script>
<?php endforeach; ?>

</body>
</html>

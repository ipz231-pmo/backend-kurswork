<?php
/**
 * @var string $title
 * @var array $styles
 * @var array $scripts
 * @var string $content
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    
    <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" type="text/css" href="<?= $style ?>">
    <?php endforeach; ?>
</head>
<body>


<div class="bg-secondary">
    <header class="container">
        <h1><?= $title ?></h1>
    </header>
</div>
<?= $content ?>

<?php foreach ($scripts as $script): ?>
    <script src="<?=$script?>"></script>
<?php endforeach; ?>

</body>
</html>
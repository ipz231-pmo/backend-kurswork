<?php
/**
 * @var string $title
 * @var array $styles
 * @var array $scripts
 * @var string $content
 *
 * @var array $headerCategories
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

<header>
    <div style="background: #fafbfc"> About
        <div class="container d-flex justify-content-between ">
            <div>
                <a href="/site/about">About</a>
            </div>
            <div>Not sign in</div>
        </div>
    </div>
    
    <div> Dok
    
    </div>
    <div style="background: #171718"> Navigation
        <div class="container">
            <?php foreach ($headerCategories as $category): ?>
            <a href="#<?= $category['urlName']  ?>"
               class="text-white text-decoration-none d-inline-block p-2 border-start border-end border-white mx-0" >
                <?= $category['name'] ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</header>

<?= $content ?>

<?php foreach ($scripts as $script): ?>
    <script src="<?=$script?>"></script>
<?php endforeach; ?>

</body>
</html>
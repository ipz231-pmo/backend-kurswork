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
    <?php endif; ?>
</head>
<body>


<div class="d-flex flex-column min-vh-100">
    <header>
        <!-- First Header -->
        <div style="background: #fafbfc !important;" class="border-bottom border-secondary-subtle">
            <div class="container d-flex justify-content-between">
                <ul class="nav">
                    <li class="nav-item"><a href="/" class="nav-link text-black">Home</a></li>
                    <li class="nav-item"><a href="/site/about" class="nav-link text-black">About us</a></li>
                    <li class="nav-item"><a href="/shop/all" class="nav-link text-black">All</a></li>
                    <li class="nav-item"><a href="/shop/catalog" class="nav-link text-black">Catalog</a></li>
                </ul>
                <div class="d-flex align-items-center nav">
                    <?php if ($user === null): ?>
                        <button class="btn" id="show-login-window-btn" >Log in</button>
                    <?php else: ?>
                        <a href="/profile/" class="nav-link">Profile</a>
                        <a href="/profile/logout" class="nav-link">Logout</a>
                        <button
                                id="cart-btn"
                                class="d-flex align-items-center px-4 py-2 border-0 bg-primary text-white gap-3"
                                hx-get="/shop/cart" hx-target="#cart" hx-trigger="click" hx-swap="outerHTML">
                            <img src="/images/icon-cart.svg" alt="Cart Icon">
                            Cart
                        </button>
                    
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Login Window -->
        <?php if ($user === null): ?>
        <div>
            <div class="container position-relative">
                <div id="login-layout" class="position-absolute bg-white border border-2 p-5 rounded-2 d-none">
                    <div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="email">Email</label></div>
                            <div class="col-8"><input type="email" name="email" id="email" placeholder="Email address" required></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4"><label for="password">Password</label></div>
                            <div class="col-8"><input type="password" name="password" id="password" placeholder="Password" required></div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <button class="btn border border-2 px-4 py-2" id="exit-login-window-btn">Cancel</button>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <button class="btn bg-primary text-white px-4 py-2" id="confirm-login-action-btn">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Second Header -->
        <div>
            <div>
                <div class="container d-flex align-items-center gap-5 py-3">
                    <img src="https://dok.ua/themes/redesign/img/logos/original/svg/logo-full-original-ua.svg" alt="Company Logo">
                    <div class="d-flex gap-3">
                        <div>
                            <div class="h5 text-primary"><span class="text-secondary">0(000)</span>000-000</div>
                            <div>Free in Ukraine</div>
                        </div>
                        <div>
                            <div class="m-0"><span class="text-secondary">(000)</span>000-00-00</div>
                            <div class="m-0"><span class="text-secondary">(000)</span>000-00-00</div>
                        </div>
                        <div>
                            <div class="m-0"><span class="text-secondary">(000)</span>000-00-00</div>
                            <div class="m-0"><span class="text-secondary">(000)</span>000-00-00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Header -->
        <div style="background: #171718">
            <div class="container">
                <ul class="nav justify-content-center py-2">
                    <?php foreach ($headerCategories as $category): ?>
                    <li class="nav-item">
                        <a href="/shop?category=<?= $category['urlName']  ?>"
                           class="text-white text-decoration-none d-inline-block p-2 border-start border-secondary border-1  border-end mx-0" >
                            <?= $category['name'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="flex-fill">
        <?= $content ?>
    </div>
    
    <footer id="footer" class="d-block">
        <div id="advantages" class="mb-5 mt-4">
            <div class="container">
                <p class="h3 mb-3">Наші переваги</p>
                <div class="row">
                    <div class="col-3">
                        <div class="rounded-2 border p-3 m-0 h-100 d-flex align-items-center gap-3">
                            <img src="/images/icon-truck.svg" alt="Truck Icon">
                            <p>Зручна доставка до будь-якої точки країни без передоплати</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="rounded-2 border p-3 m-0 h-100 d-flex align-items-center gap-3">
                            <img src="/images/icon-lock.svg" alt="Truck Icon">
                            <p>Гарантія повернення/обміну при неправильному підборі</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="rounded-2 border p-3 m-0 h-100 d-flex align-items-center gap-3">
                            <img src="/images/icon-valves.svg" alt="Truck Icon">
                            <p>Величезний асортимент: понад 12 млн. запчастин та автотоварів</p>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="rounded-2 border p-3 m-0 h-100 d-flex align-items-center gap-3">
                            <img src="/images/icon-meditation.svg" alt="Truck Icon">
                            <p>Нервозберігаючий режим</p>
                        </div>
                    </div>
                </div>
                <!--<div class="d-flex justify-content-between gap-3">
                    <div class="rounded-2 border p-3 m-0 flex-fill d-flex align-items-center gap-3">
                        <img src="/images/icon-truck.svg" alt="Truck Icon">
                        <p>Зручна доставка до будь-якої точки країни без передоплати</p>
                    </div>
                    <div class="rounded-2 border p-3 m-0 flex-fill d-flex align-items-center gap-3">
                        <img src="/images/icon-lock.svg" alt="Truck Icon">
                        <p>Гарантія повернення/обміну при неправильному підборі</p>
                    </div>
                    <div class="rounded-2 border p-3 m-0 flex-fill d-flex align-items-center gap-3">
                        <img src="/images/icon-valves.svg" alt="Truck Icon">
                        <p>Величезний асортимент: понад 12 млн. запчастин та автотоварів</p>
                    </div>
                    <div class="rounded-2 border p-3 m-0 flex-fill d-flex align-items-center gap-3">
                        <img src="/images/icon-meditation.svg" alt="Truck Icon">
                        <p>Нервозберігаючий режим</p>
                    </div>
                </div>-->
            </div>
        </div>
        <div id="footer-navbar" class="bg-secondary text-white">
            <div class="container py-3 border-bottom border-1 border-white">
                <ul class="nav justify-content-center">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-white">About</a></li>
                </ul>
            </div>
        </div>
        <div id="copyright" class="bg-secondary text-white">
            <div class="container border-top d-flex justify-content-between align-items-center pt-4 pb-2">
                <div>
                    <p class="m-0">dok.ua All rights reserved</p>
                    <p class="m-0">Auto detail`s Internet market</p>
                </div>
                <div>
                
                </div>
                <div class="d-flex gap-3">
                    <img src="/images/icon-visa.svg" alt="Visa Icon" height="25">
                    <img src="/images/icon-verified-visa.svg" alt="Visa Icon" height="25">
                    <img src="/images/icon-mastercard.svg" alt="Mastercard Icon" height="25">
                    <img src="/images/icon-mastercard-secure.svg" alt="Mastercard Icon" height="25">
                </div>
            </div>
        </div>
    </footer>
</div>
    

<div
        id="cart-layout"
        class="fixed-top vh-100 vw-100 d-none d-flex align-items-center justify-content-center">
    <div id="cart"></div>
</div>

<script>
    let currentLocation = "<?= $_GET['route'] ?? "" ?>";
</script>

<?php foreach ($scripts as $script): ?>
<script src="<?=$script?>"></script>
<?php endforeach; ?>

<script src="https://unpkg.com/htmx.org@2.0.4"></script>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>


<?php if ($user === null): ?>
<script src="/js/login.js"></script>
<?php else: ?>
<script src="/js/cart.js"></script>
<?php endif; ?>
</body>
</html>

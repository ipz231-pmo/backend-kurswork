<?php
/**
 * @var array $user
 * @var array $headerCategories
 */
?>

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
                    <button class="btn" id="show-register-window-btn" >Register</button>
                <?php else: ?>
                    <a href="/profile" class="nav-link">Profile</a>
                    <button class="btn" id="show-logout-window-btn">Logout</button>
                    <button
                        id="cart-btn"
                        class="d-flex align-items-center px-4 py-2 border-0 bg-primary text-white gap-3">
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
    
    <!-- Logout Window -->
    <?php if ($user !== null): ?>
        <div>
            <div class="container position-relative">
                <div id="logout-layout" class="position-absolute bg-white border border-2 p-5 rounded-2 d-none">
                    <div>
                        <div class="row h5 mb-3">
                            Are you sure you want to logout?
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <button class="btn border border-2 px-4 py-2" id="exit-logout-window-btn">Cancel</button>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <button class="btn bg-primary text-white px-4 py-2" id="confirm-logout-action-btn">Logout</button>
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
    
    <!-- Admin Header -->
    <?php if ($user !== null && $user['role'] == "admin"): ?>
    <div class="bg-secondary-subtle">
        <div class="container py-3">
            <ul class="nav justify-content-center gap-3">
                <li class="nav-item"><a href="/admin/news" class="nav-link text-primary h6">Update News</a></li>
                <li class="nav-item"><a href="/admin/goods" class="nav-link text-primary h6">Update Goods</a></li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</header>

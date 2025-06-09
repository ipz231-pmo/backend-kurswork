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
 * Content parameters
 * @var array $items
 * @var array $category
 * @var int $itemsCount
 *
 * Filtering and Sorting
 * @var string $sort
 * @var int|null $minPrice
 * @var int|null $maxPrice
 *
 * Paging Info
 * @var int $pagesCount
 * @var int $currentPage
 */

$this->styles = array_merge($styles, ["/css/shop/index.css"]);
$this->scripts = array_merge($scripts, ["/js/shop/index.js"]);

?>



<div>
    <div class="container">
        <div>
            <div class="text-secondary">
                <a href="/shop/catalog" class="text-decoration-none text-secondary">Планове ТО</a>
                &#8594;
                <a href="/shop?category=<?= $category['urlName'] ?>" class="text-decoration-none text-black"><?= $category['name'] ?></a>
            </div>
            <div class="h3"><?= $category['name'] ?></div>
        </div>
        <div class="row">
            <div class="col-3 bg-secondary-subtle rounded-2 p-3">
                <div class="h5 mb-3 text-center">Filtering</div>
                <div class="d-flex flex-wrap price-range">
                    <div class="w-100 h6 mb-2">Price</div>
                    <input type="number" <?= empty($minPrice) ? "" : "value=\"$minPrice\"" ?> name="minPrice" class="price-box rounded-2 me-2" >
                    <input type="number" <?= empty($maxPrice) ? "" : "value=\"$maxPrice\"" ?> name="maxPrice" class="price-box rounded-2 me-2" >
                    <button class="btn border-primary" id="apply-price-filter-btn">OK</button>
                </div>
            </div>
            <div class="col-9 ps-4">
                <div class="d-flex justify-content-between">
                    <div class="h6">Знайдено <?= $itemsCount ?> шт</div>
                    <select name="sort" id="sort">
                        <option value="cheap" <?= $sort == "cheap" ? "selected" : "" ?> >Від дешевих до дорогих</option>
                        <option value="expensive" <?= $sort == "expensive" ? "selected" : "" ?> >Від дорогих до дешевих</option>
                        <option value="rating" <?= $sort == "rating" ? "selected" : "" ?> >За рейтингом</option>
                    </select>
                </div>
                <div id="items-container">
                    <?php foreach ($items as $item): ?>
                    <a href="/shop/item?id=<?= $item['id'] ?>" class="row mb-5 align-items-start text-decoration-none">
                        <img src="/images/icon-no-image.png" class="col-3 img-fluid" alt="product image" height="200" >
                        <div class="col-7 text-decoration-none text-black h5">
                            <?= $item['name'] ?>
                        </div>
                        <div class="col-2">
                            <p class="h5 m-0 mb-3"><?= $item['price'] ?> <span class="text-secondary h6">грн</span></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div>
                    <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
                    <?php $sel = $i == $currentPage ? "bg-primary" : "" ?>
                    <button data-page="<?= $i ?>" class="paging-btn p-3 rounded-2 <?= $sel ?>"><?= $i ?></button>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let category = 'category=<?= $category['urlName'] ?>';
    let sort = '<?= $sort === "rating" ? '' : "sort=".$sort ?>';
    let minPrice = '<?= empty($minPrice) ? '' : "minPrice=".$minPrice ?>';
    let maxPrice = '<?= empty($maxPrice) ? '' : "maxPrice=".$maxPrice ?>';
    let currentPage = '<?= $currentPage == 1 ? '' : "page=$currentPage" ?>';
</script>


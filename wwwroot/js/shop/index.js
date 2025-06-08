let sortSelect = document.querySelector("select[name=sort]");
sortSelect.addEventListener("change", ev => {
    let sort = `sort=${sortSelect.value}`;
    document.location.replace(`/shop/index?${category}&${minPrice}&${maxPrice}&${sort}`);
});


let minPriceInput = document.querySelector("input[name=minPrice]");
let maxPriceInput = document.querySelector("input[name=maxPrice]");
let btn = document.querySelector("button#apply-price-filter-btn");
btn.addEventListener("click", ev => {
    let minPrice = minPriceInput.value.trim();
    let maxPrice = maxPriceInput.value.trim();

    let incMin = minPrice.length > 0;
    let incMax = maxPrice.length > 0;

    let minPriceStr = incMin ? `minPrice=${minPrice}` : '';
    let maxPriceStr = incMax ? `maxPrice=${maxPrice}` : '';

    document.location.replace(`/shop/index?${category}&${minPriceStr}&${maxPriceStr}&${sort}`);
})



// paging-btn
let pagingBtns = document.querySelectorAll("button.paging-btn");
pagingBtns.forEach(value => {
    value.addEventListener("click", ev => {
        let page = value.dataset.page;
        let currentPage = `page=${page}`;
        document.location.replace(`/shop/index?${category}&${minPrice}&${maxPrice}&${sort}&${currentPage}`);
    })
});


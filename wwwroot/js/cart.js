
let cartBtn = document.querySelector('#cart-btn');
let cartLayout = document.querySelector('#cart-layout');


cartLayout.addEventListener('click', function (ev) {
    if (ev.target === this){
        cartLayout.classList.add('d-none');
    }
});
cartBtn.addEventListener('click', function (ev) {
    cartLayout.classList.remove('d-none');
});
// Page Layout
let cartBtn = document.querySelector('#cart-btn');
let cartLayout = document.querySelector('#cart-layout');
let cartContainer = document.querySelector("#cart");

cartLayout.addEventListener('click', ev => {
    if (ev.target === this) closeCart();
});
cartBtn.addEventListener('click', openCart);


async function openCart(){
    cartContainer.innerHTML = '<div class="p-5 text-center">Loading...</div>';
    cartLayout.classList.remove('d-none');
    try {
        const response = await fetch('/shop/cart');
        if (!response.ok) {
            throw new Error(`Network response was not ok, status: ${response.status}`);
        }
        let data = await response.json();

        if (data.status === 'success' && data.content)
        {
            cartContainer.innerHTML = data.content;
            applyCartEventListeners();
        }
        else
        {
            cartContainer.innerHTML = '<div class="p-5 text-center text-danger">Failed to load cart content.</div>';
        }
    } catch (error) {
        console.error('Failed to fetch cart:', error);
        cartContainer.innerHTML = '<div class="p-5 text-center text-danger">An error occurred while loading the cart.</div>';
    }
}
function closeCart(){
    cartLayout.classList.add('d-none');
    cartContainer.innerHTML = '';
}

function applyCartEventListeners(){
    let closeCartBtn = cartContainer.querySelector("#close-cart-btn");
    let closeCartBtn2 = cartContainer.querySelector("#close-cart-btn-2");


    if (closeCartBtn) closeCartBtn.addEventListener("click", closeCart);
    if (closeCartBtn2) closeCartBtn2.addEventListener("click", closeCart);
}
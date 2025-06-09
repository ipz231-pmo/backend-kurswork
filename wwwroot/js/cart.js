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

    // Remove item buttons
    const removeButtons = cartContainer.querySelectorAll('.remove-from-cart-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', handleRemoveItem);
    });

    // Quantity inputs
    const quantityInputs = cartContainer.querySelectorAll('.cart-item-quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('change', handleUpdateQuantity);
    });

}

async function handleRemoveItem(event) {
    const button = event.currentTarget;
    const goodId = button.dataset.goodId;
    button.disabled = true;

    try {
        const response = await fetch('/shop/removeFromCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ goodId: goodId })
        });
        const result = await response.json();
        if (response.ok && result.status === '200') {
            await openCart();
        } else {
            alert('Error: ' + (result.message || 'Could not remove item.'));
            button.disabled = false;
        }
    } catch (error) {
        console.error('Remove from cart failed:', error);
        alert('An unexpected error occurred.');
        button.disabled = false;
    }
}

async function handleUpdateQuantity(event) {
    const input = event.currentTarget;
    const goodId = input.dataset.goodId;
    const quantity = parseInt(input.value, 10);
    input.disabled = true;

    if (isNaN(quantity)) {
        alert('Invalid quantity.');
        input.disabled = false;
        await openCart(); // Revert to original value by refreshing
        return;
    }

    // The backend handles quantity <= 0 as a removal.
    // The action is the same as add to cart, which handles updates.
    try {
        const response = await fetch('/shop/addToCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ goodId: goodId, quantity: quantity })
        });
        const result = await response.json();
        if (response.ok && result.status === '200') {
            openCart(); // Refresh cart view to show new totals
        } else {
            alert('Error: ' + (result.message || 'Could not update quantity.'));
            openCart(); // Refresh to revert changes on failure
        }
    } catch (error) {
        console.error('Update quantity failed:', error);
        alert('An unexpected error occurred.');
        openCart(); // Refresh to revert changes on failure
    }
}
async function addToCart(){
    const goodId = this.dataset.goodId;
    const quantityInput = document.getElementById('quantity');
    const quantity = parseInt(quantityInput.value, 10);

    if (isNaN(quantity) || quantity < 1) {
        alert('Please enter a valid quantity.');
        return;
    }

    this.disabled = true;
    this.innerHTML = 'Adding...';

    try {
        const response = await fetch('/shop/addToCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ goodId: goodId, quantity: quantity })
        });

        const result = await response.json();

        if (response.ok) {
            document.querySelector('#cart-btn')?.click();
            addToCartLayout.innerHTML = `
                        <div class="my-4">
                            <button id="open-cart-btn" class="btn btn-primary btn-lg w-100">
                                Already in Cart
                            </button>
                        </div>
                    `;
            let openCartBtn = document.getElementById('open-cart-btn');
            openCartBtn.addEventListener('click', openCart);
        } else {
            alert('Error: ' + (result.message || 'Could not add item to cart.'));
        }
    } catch (error) {
        console.error('Add to cart failed:', error);
        alert('An unexpected error occurred. Please try again.');
    } finally {
        this.disabled = false;
        this.innerHTML = 'Add to Cart';
    }
}
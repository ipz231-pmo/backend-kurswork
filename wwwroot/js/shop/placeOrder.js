
const orderForm = document.getElementById('order-form');

const placeOrderBtn = document.getElementById('place-order-btn');
const errorMessageDiv = document.getElementById('error-message');


orderForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    await placeOrder();
});

async function placeOrder() {
    errorMessageDiv.classList.add('d-none');

    const phoneInput = document.getElementById('phone');
    const postalIndexInput = document.getElementById('postalIndex');

    const phone = phoneInput.value.trim();
    const postalIndex = postalIndexInput.value.trim();

    if (!phone || !postalIndex) {
        showError('Both phone and postal index are required.');
        return;
    }

    const requestBody = {
        phone: phone,
        postalIndex: postalIndex
    };

    // Disable button to prevent multiple submissions
    placeOrderBtn.disabled = true;
    placeOrderBtn.textContent = 'Placing Order...';

    try {
        const response = await fetch('/shop/placeOrderAsync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        });

        const result = await response.json();

        if (response.ok) {
            window.location.href = '/profile';
        } else {
            showError(result.message || 'An unknown error occurred.');
        }

    } catch (error) {
        console.error('Order placement failed:', error);
        showError('A network error occurred. Please try again.');
    } finally {
        placeOrderBtn.disabled = false;
        placeOrderBtn.textContent = 'Place Order';
    }
}

function showError(message) {
    errorMessageDiv.textContent = message;
    errorMessageDiv.classList.remove('d-none');
}

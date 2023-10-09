document.getElementById('checkout-button').addEventListener('click', function () {
    stripe.redirectToCheckout({
        items: [
            // Add items to the cart
            { sku: 'sku_123', quantity: 1 },
            // Add more items as needed
        ],
        successUrl: 'https://example.com/success',
        cancelUrl: 'https://example.com/cancel',
    });
});

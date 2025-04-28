// Basic structure for future cart functionality

let cart = [];

function addToCart(product) {
    cart.push(product);
    alert(product + " added to your cart!");
    updateCartDisplay();
}

function updateCartDisplay() {
    let cartSection = document.getElementById('cart');
    if (cart.length > 0) {
        cartSection.innerHTML = `
            <h2>Shopping Cart</h2>
            <ul>${cart.map(item => `<li>${item}</li>`).join('')}</ul>
        `;
    } else {
        cartSection.innerHTML = `
            <h2>Shopping Cart</h2>
            <p>Your cart is empty.</p>
        `;
    }
}

// Example: You can connect "Add to Cart" buttons in the future

// Initialize cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to update the cart count in the navigation
function updateCartCount() {
    document.getElementById('cart-count').textContent = cart.length;
}

// Function to add a product to the cart
function addToCart(product) {
    cart.push(product);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert(`${product.name} added to cart!`);
}

// Function to display the shopping cart
function viewCart() {
    let mainContent = document.getElementById('main-content');
    if (!mainContent) return;

    let cartContent = `<h2>Shopping Cart</h2><div class="cart-container">`;
    let subtotal = 0;

    if (cart.length === 0) {
        cartContent += `<p>Your cart is empty.</p>`;
    } else {
        cart.forEach((item, index) => {
            let price = parseFloat(item.price) || 0;
            subtotal += price;

            cartContent += `<div class="cart-item">
                <img src="image/${item.image}" alt="${item.name}">
                <h3>${item.name}</h3>
                <p><strong>₹${price.toFixed(2)}</strong></p>
                <button class="remove-btn" onclick="removeFromCart(${index})">Remove</button>
            </div>`;
        });

        // ✅ Subtotal appears ABOVE the checkout button
        cartContent += `<div class="cart-summary">
                            <h3>Total: ₹${subtotal.toFixed(2)}</h3>
                            <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
                        </div>`;
    }

    cartContent += `</div>`;
    mainContent.innerHTML = cartContent;
}

// Function to remove a product from the cart
function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    viewCart();
}

// Function to handle checkout process (collect user info)
function checkout() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    let mainContent = document.getElementById('main-content');
    if (!mainContent) return;

    mainContent.innerHTML = `
        <h2>Secure Checkout</h2>
        <form id="checkout-form">
            <label for="name">Full Name:</label>
            <input type="text" id="name" required>

            <label for="phone">Mobile Number:</label>
            <input type="tel" id="phone" required>

            <label for="address">Delivery Address:</label>
            <textarea id="address" required></textarea>

            <button type="button" onclick="processOrder()">Confirm & Proceed to Payment</button>
        </form>

        <h3>Bank Transfer Option</h3>
        <p>If you prefer to pay via bank transfer, use the details below:</p>
        <div class="bank-details">
            <p><strong>Beneficiary Name:</strong> Mohamed Ibrahim Badusha</p>
            <p><strong>Account Number:</strong> 1611153000003271</p>
            <p><strong>Branch Code:</strong> KVBL0001611</p>
        </div>

        <div id="paypal-button-container"></div>
    `;
}

// Function to process order and trigger payment
function processOrder() {
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    if (!name || !phone || !address) {
        alert("Please fill in all required fields.");
        return;
    }

    alert(`Order confirmed!\nName: ${name}\nPhone: ${phone}\nAddress: ${address}`);

    // ✅ Send order email after confirmation
    fetch('send_order_email.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            name: name,
            phone: phone,
            address: address,
            cart: cart
        })
    });

    // ✅ Initiate PayPal payment
    paypal.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: cart.reduce((total, item) => total + parseFloat(item.price), 0).toFixed(2)
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(details => {
                alert(`Transaction completed! Thank you, ${details.payer.name.given_name}.`);
                
                // ✅ Notify backend that payment was successful
                fetch('send_order_email.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: name,
                        phone: phone,
                        address: address,
                        cart: cart,
                        transaction_id: details.id
                    })
                });

                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                viewCart();
                window.location.href = "thank_you.html"; // ✅ Redirect after payment
            });
        }
    }).render('#paypal-button-container');
}

// Call updateCartCount() when the page loads
updateCartCount();
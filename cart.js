// ✅ Initialize cart from localStorage or start as empty
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// ✅ Update the cart item count in the header
function updateCartCount() {
    const cartCountElement = document.getElementById("cart-count");
    if (cartCountElement) {
        cartCountElement.textContent = cart.length;
    }
}

// ✅ Add product to cart with duplicate prevention & image validation
function addToCart(product) {
    const exists = cart.find(item => item.id === product.id);
    if (exists) {
        alert(`${product.name} is already in the cart.`);
        return;
    }

    // ✅ Ensure correct image path
    const imagePath = product.image.includes("image/") ? product.image : `image/${product.image}`;

    // ✅ Add product to cart
    cart.push({
        id: product.id,
        name: product.name,
        price: parseFloat(product.price) || 0, // Ensure price is a valid number
        image: imagePath,
        description: product.description
    });

    // ✅ Save updated cart to localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(`${product.name} added to cart!`);
}

// ✅ View the cart contents
function viewCart() {
    const mainContent = document.getElementById("main-content");
    if (!mainContent) return;

    let cartContent = `<h2>Shopping Cart</h2><div class="cart-container">`;
    let subtotal = 0;

    if (cart.length === 0) {
        cartContent += `<p>Your cart is empty.</p>`;
    } else {
        cart.forEach((item, index) => {
            subtotal += item.price;

            // ✅ Ensure images fall back to `default.jpg` if missing
            cartContent += `<div class="cart-item">
                <img src="${item.image}" alt="${item.name}" onerror="this.src='image/default.jpg'">
                <h3>${item.name}</h3>
                <p><strong>₹${item.price.toFixed(2)}</strong></p>
                <button class="remove-btn" onclick="removeFromCart(${index})">Remove</button>
            </div>`;
        });

        cartContent += `<div class="cart-summary">
            <h3>Total: ₹${subtotal.toFixed(2)}</h3>
            <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
        </div>`;
    }

    cartContent += `</div>`;
    mainContent.innerHTML = cartContent;
}

// ✅ Remove item by index and update cart
function removeFromCart(index) {
    cart.splice(index, 1); // Remove the item from the cart array
    localStorage.setItem("cart", JSON.stringify(cart)); // Update localStorage with the new cart
    updateCartCount(); // Update cart count in the header
    viewCart(); // Re-render the cart
}

// ✅ Checkout: prevent empty cart checkout & clear cart
function checkout() {
    console.log("Checking out with cart:", cart);

    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    // ✅ Save cart for display on confirmation page
    sessionStorage.setItem("orderSummary", JSON.stringify(cart));

    // ✅ Redirect to order confirmation page
    window.location.href = "order_success.php";

    // ✅ Only clear cart AFTER redirect
    cart = [];
    localStorage.removeItem("cart");
    updateCartCount();
    viewCart();
}

// ✅ Update cart count when page loads
document.addEventListener("DOMContentLoaded", updateCartCount);

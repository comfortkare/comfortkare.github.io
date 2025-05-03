function checkout() {
    console.log("Checking out with cart:", cart);

    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    // ✅ Store cart before redirecting
    sessionStorage.setItem("orderSummary", JSON.stringify(cart));

    // ✅ Correct redirection
    window.location.href = "order_success.php";
}
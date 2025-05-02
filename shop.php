<?php
include 'db_connect.php';
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comfort Kare | Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <a href="index.html">Home</a>
        <a href="about.html">About Us</a>
        <a href="products.html">Products</a>
        <a href="shop.html">Shop Now</a>
        <a href="contact.html">Contact</a>
    </nav>
</header>

<section class="shop">
    <h2>Shop Our Products</h2>

    <div class="product-grid">
      <?php while($row = $result->fetch_assoc()) { ?>
        <div class="product-card">
          <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
          <h3><?php echo htmlspecialchars($row['name']); ?></h3>
          <p><strong>₹<?php echo number_format($row['price'], 2); ?></strong></p>
          <p><?php echo htmlspecialchars($row['description']); ?></p>
          <button>Add to Cart</button>
        </div>
      <?php } ?>
    </div>

</section>

</body>
</html>
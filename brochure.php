<?php
// brochure.php

// Define the directory where brochures are stored
$brochure_dir = "brochure/";

if ($handle = opendir($brochure_dir)) {
    $brochures = [];
    
    // Loop through the files in the brochure directory
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) == "pdf") {
            $brochures[] = $file;
        }
    }

    closedir($handle);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Download Brochures – Comfort Kare</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="site-header">
    <div class="header-container">
      <a href="index.html"><img src="logo.png" alt="Comfort Kare Logo" class="logo" /></a>
      <nav class="main-nav">
        <a href="index.html">Home</a>
        <div class="dropdown">
          <button class="dropbtn">Profile</button>
          <div class="dropdown-content">
            <a href="about.html">About Us</a>
            <a href="testimonial.html">Testimonial</a>
            <a href="brochure.php">Download Brochures</a>
          </div>
        </div>
        <a href="product.html">Our Product Range</a>
        <a href="contact.html">Contact Us</a>
        <a href="tel:+917868879893">Call</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="brochure-list">
      <h2>📁 Available Brochures</h2>

      <?php if (count($brochures) > 0): ?>
        <!-- Loop through brochures and display them -->
        <?php foreach ($brochures as $brochure): ?>
          <div class="brochure-item">
            📄 <a href="brochure/<?php echo htmlspecialchars($brochure); ?>" download><?php echo htmlspecialchars($brochure); ?></a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No brochures available at the moment.</p>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p style="text-align:right">© 2025 Comfort Kare. All rights reserved.</p>
  </footer>

</body>
</html>

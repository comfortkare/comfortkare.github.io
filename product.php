<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Product Range – Comfort Kare</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="site-header">
    <div class="header-container">
      <a href="index.html">
        <img src="Image/logo.png" alt="Comfort Kare Logo" class="logo" />
      </a>
      <nav class="main-nav">
        <a href="index.html">Home</a>
        <a href="product.php">Our Product Range</a>
      </nav>
    </div>
  </header>

  <main>
    <section id="product-range">
      <h1 class="main-heading">Our Product Range</h1>

      <?php
      // Define the folder path
      $dir = "Image/";

      // Get all image files in the folder
      $files = scandir($dir);

      // Loop through each file
      foreach($files as $file) {
        // Skip . and .. directories
        if($file != "." && $file != "..") {
          // Only display image files (JPEG, JPG, PNG)
          if (preg_match("/\.(jpg|jpeg|png)$/i", $file)) {
            echo "<div class='product'>
                    <img src='$dir$file' alt='$file' class='product-image' />
                    <p>Comfort Kare " . ucfirst(pathinfo($file, PATHINFO_FILENAME)) . "</p>
                  </div>";
          }
        }
      }
      ?>

    </section>
  </main>

  <footer>
    <p>© 2025 Comfort Kare. All rights reserved.</p>
  </footer>

</body>
</html>

<?php
$directories = ["brochure/premium", "brochure/special", "brochure/festive"];
$output = "";

foreach ($directories as $dir) {
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $filePath = "/comfortkare/$dir/$file"; // Ensure absolute path
                $name = pathinfo($file, PATHINFO_FILENAME);
                $output .= "<div class='catalog-item'>
                    <h4>$name</h4>
                    <a href='$filePath' target='_blank' class='view-btn'>View</a>
                    <a href='$filePath' download='$file' class='download-btn'>Download</a>
                </div>";
            }
        }
        closedir($handle);
    }
}
echo $output;
?>
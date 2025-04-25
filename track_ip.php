<?php
$filename = "visitor_ips.txt";
$ip = $_SERVER['REMOTE_ADDR'];
$ips = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];

if (!in_array($ip, $ips)) {
    file_put_contents($filename, $ip . PHP_EOL, FILE_APPEND);
}

echo count(array_unique($ips));
?>

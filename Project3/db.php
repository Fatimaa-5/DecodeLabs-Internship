<?php
// Auto-detect: Localhost ya InfinityFree
$host = "localhost";

// Agar InfinityFree pe upload kiya hai to ye values use hogi
if($_SERVER['HTTP_HOST'] != 'localhost') {
    $host = "sqlXXX.epizy.com"; // InfinityFree wala host
    $user = "epiz_XXXXXXXX";    // InfinityFree wala username 
    $pass = "tumhara_password"; // InfinityFree wala password
    $db = "epiz_XXXXXXXX_anime_db"; // InfinityFree wala DB name
} else {
    // Localhost ke liye
    $user = "root";
    $pass = "";
    $db = "anime_db";
}

$conn = mysqli_connect($host, $user, $pass, $db);
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
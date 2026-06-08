<?php

$host = "localhost"; $user = "root"; $pass = ""; $db = "decode_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: ". $conn->connect_error);
function isLoggedIn() { return isset($_SESSION['user_id']); }
function isAdmin() { return isset($_SESSION['role']) && $_SESSION['role'] == 'admin'; }
?>
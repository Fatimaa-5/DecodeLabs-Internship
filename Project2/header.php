<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Decode Labs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
  <div class="logo"><span>D</span> DECODE LABS</div>
  
  <div class="menu" id="menu">
    <a href="index.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="programs.php">Internship Programs</a>
    <a href="contact.php">Contact Us</a>
  </div>

  <button class="menu-toggle" onclick="toggleMenu()">☰</button>

  <div class="auth" id="auth">
  <?php if(isLoggedIn()): ?>
    <a href="dashboard.php" class="btn-outline">Dashboard</a>
    <?php if(isAdmin()) echo '<a href="admin.php" class="btn-outline">Admin</a>'; ?>
    <a href="logout.php" class="btn-outline">Logout</a>
  <?php else: ?>
    <a href="login.php" class="btn-outline">Login</a>
    <a href="register.php" class="btn-purple">Register</a>
  <?php endif; ?>
  </div>
</nav>

<script>
function toggleMenu() {
  document.getElementById('menu').classList.toggle('show');
  document.getElementById('auth').classList.toggle('show');
}
</script>
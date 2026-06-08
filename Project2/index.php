<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Decode Labs - Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
  <div class="logo"><span>D</span> DECODE LABS</div>
  
  <div class="menu" id="menu">
    <a href="index.php" class="active">Home</a>
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

<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">LEARN • BUILD • GROW</div>
    <h1>Kickstart Your Career<br>With <span>Decode Labs</span></h1>
    <p>Join our industry-focused internship programs and gain real-world experience. Build projects, get mentored, and land your dream job.</p>
    <div class="hero-btns">
      <a href="apply.php" class="btn-primary">Apply Now →</a>
      <a href="programs.php" class="btn-secondary">Explore Programs</a>
    </div>
  </div>
  <div class="hero-image">
    <img src="images/img1.jpeg" alt="Developer">
  </div>
</section>

<section class="stats">
 <div class="stats-grid">
  <div class="stat-item">
  <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
  </svg>
  <div class="stat-text"><h3>500+</h3><p>Interns</p></div>
</div>

<div class="stat-item">
  <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
    <path d="M6.5 2H20v20H6.5a2.5 2.5 0 0 0 0 5H20"></path>
  </svg>
  <div class="stat-text"><h3>20+</h3><p>Programs</p></div>
</div>

<div class="stat-item">
  <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
    <line x1="8" y1="21" x2="16" y2="21"></line>
    <line x1="12" y1="17" x2="12" y2="21"></line>
  </svg>
  <div class="stat-text"><h3>50+</h3><p>Projects</p></div>
</div>

<div class="stat-item">
  <svg class="stat-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
    <circle cx="9" cy="7" r="4"></circle>
    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
  </svg>
  <div class="stat-text"><h3>10+</h3><p>Partners</p></div>
</div>
</div>
</section>

<script>
function toggleMenu() {
  document.getElementById('menu').classList.toggle('show');
  document.getElementById('auth').classList.toggle('show');
}
</script>

</body>
</html>
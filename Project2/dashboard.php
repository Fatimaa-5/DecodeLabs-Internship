<?php require 'config.php';
if(!isLoggedIn()) header('Location: login.php');
?>
<!DOCTYPE html><html><head><title>Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav>
<div><b>DECODE LABS</b></div>
<div>
<a href="index.php">Home</a>
<a href="about.php">About Us</a>
<a href="programs.php">Internship Programs</a>
<a href="contact.php">Contact Us</a>
<a href="dashboard.php">Dashboard</a>
<?php if(isAdmin()) echo '<a href="admin.php">Admin</a>';?>
<a href="logout.php">Logout</a>
</div>
</nav>
<div class="container">
<h2>Welcome back, <?php echo $_SESSION['name'];?> 👋</h2>
<div class="grid">
<div class="card"><h3>Total Tasks</h3><h1>12</h1></div>
<div class="card"><h3>Completed</h3><h1>7</h1></div>
<div class="card"><h3>Pending</h3><h1>5</h1></div>
<div class="card"><h3>Attendance</h3><h1>85%</h1></div>
</div>
<a href="apply.php" class="btn">Apply for New Program</a>
</div></body></html>
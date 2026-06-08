<?php require 'config.php';
if(!isAdmin()) { echo "<h2 style='text-align:center; margin-top:100px;'>Access Denied - Admin Only</h2>"; exit; }
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
$apps = $conn->query("SELECT * FROM applications ORDER BY id DESC");
$contacts = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
?>
<!DOCTYPE html><html><head><title>Admin Panel</title><link rel="stylesheet" href="style.css"></head>
<body><nav><div><b>DECODE LABS</b></div><div>
<a href="index.php">Home</a><a href="about.php">About Us</a><a href="programs.php">Internship Programs</a><a href="contact.php">Contact Us</a>
<a href="dashboard.php">Dashboard</a><a href="admin.php">Admin</a><a href="logout.php">Logout</a>
</div></nav>
<div class="container">
<h2>Admin Panel</h2>
<h3 style="margin-top:30px;">All Users</h3>
<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Registered On</th></tr>
<?php while($u=$users->fetch_assoc()):?>
<tr><td><?php echo $u['id'];?></td><td><?php echo $u['name'];?></td><td><?php echo $u['email'];?></td><td><?php echo $u['role'];?></td><td><?php echo $u['created_at'];?></td></tr>
<?php endwhile;?></table>

<h3 style="margin-top:50px">All Applications</h3>
<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Program</th><th>Phone</th><th>Applied On</th></tr>
<?php while($a=$apps->fetch_assoc()):?>
<tr><td><?php echo $a['id'];?></td><td><?php echo $a['name'];?></td><td><?php echo $a['email'];?></td><td><?php echo $a['program'];?></td><td><?php echo $a['phone'];?></td><td><?php echo $a['created_at'];?></td></tr>
<?php endwhile;?></table>

<h3 style="margin-top:50px">All Contact Messages</h3>
<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr>
<?php while($c=$contacts->fetch_assoc()):?>
<tr><td><?php echo $c['id'];?></td><td><?php echo $c['name'];?></td><td><?php echo $c['email'];?></td><td><?php echo $c['subject'];?></td><td><?php echo substr($c['message'],0,50);?>...</td><td><?php echo $c['created_at'];?></td></tr>
<?php endwhile;?></table>
</div></body></html>
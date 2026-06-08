<?php require 'config.php';
if(!isLoggedIn()) header('Location: login.php');
if($_POST) {
    $uid = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $program = $conn->real_escape_string($_POST['program']);
    $msg = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT INTO applications (user_id,name,email,phone,program,message) VALUES ('$uid','$name','$email','$phone','$program','$msg')";
    if($conn->query($sql)) echo "<script>alert('Application Submitted Successfully!'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html><html><head><title>Apply Now</title><link rel="stylesheet" href="style.css"></head>
<body><nav><div><b>DECODE LABS</b></div><div>
<a href="index.php">Home</a><a href="about.php">About Us</a><a href="programs.php">Internship Programs</a><a href="contact.php">Contact Us</a>
<a href="dashboard.php">Dashboard</a><?php if(isAdmin()) echo '<a href="admin.php">Admin</a>';?><a href="logout.php">Logout</a>
</div></nav>
<div class="container" style="max-width:600px"><div class="card">
<h2>Apply for Internship</h2><form method="POST">
<input name="name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="phone" placeholder="Phone Number" required>
<select name="program" required>
<option value="">Select Program</option>
<option>Web Development</option>
<option>Data Science</option>
<option>UI/UX Design</option>
<option>Cyber Security</option>
<option>Mobile App Dev</option>
<option>Digital Marketing</option>
</select>
<textarea name="message" placeholder="Why you want to join this program?" rows="4"></textarea>
<button class="btn">Submit Application</button></form>
</div></div></body></html>
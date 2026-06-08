<?php 
session_start();
require_once 'config.php';

if(isset($_POST['login'])) {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    
    $res = $conn->query("SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if($res->num_rows == 1) {
        $_SESSION['admin'] = $user;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Wrong Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login - DecodeLabs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {margin:0; padding:0; box-sizing:border-box;}
body {
  background: #0a0a12;
  color: white;
  font-family: 'Segoe UI', Arial, sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 20px;
}
.login-box {
  background: #14141f;
  border: 1px solid #222;
  padding: 50px 40px;
  border-radius: 20px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 0 50px rgba(139, 92, 246, 0.2);
}
.login-box h2 {
  color: #8b5cf6;
  text-align: center;
  margin-bottom: 35px;
  font-size: 30px;
}
.login-box input {
  width: 100%;
  padding: 15px;
  margin: 12px 0;
  background: #0a0a12;
  border: 1px solid #333;
  border-radius: 10px;
  color: white;
  font-size: 15px;
  outline: none;
  transition: 0.3s;
}
.login-box input:focus {border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);}
.btn-login {
  width: 100%;
  padding: 15px;
  background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
  border: none;
  border-radius: 10px;
  color: white;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  margin-top: 25px;
  transition: 0.3s;
}
.btn-login:hover {transform: translateY(-2px); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);}
.error {
  background: rgba(255, 77, 77, 0.15);
  border: 1px solid #ff4d4d;
  color: #ff4d4d;
  padding: 12px;
  border-radius: 8px;
  text-align: center;
  margin-bottom: 20px;
  font-size: 14px;
}
.back {
  text-align: center;
  margin-top: 25px;
}
.back a {
  color: #8b5cf6;
  text-decoration: none;
  font-size: 14px;
}
.back a:hover {text-decoration: underline;}
.info {
  text-align: center;
  margin-top: 20px;
  color: #666;
  font-size: 12px;
}
</style>
</head>
<body>
<div class="login-box">
  <h2>Admin Login</h2>
  <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required autocomplete="off">
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login" class="btn-login">Login</button>
  </form>
  <div class="back">
    <a href="index.php">← Back to Website</a>
  </div>
  <div class="info">Default: admin / admin123</div>
</div>
</body>
</html>
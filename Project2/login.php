<?php require 'config.php';
if($_POST) {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $res = $conn->query($sql);
    if($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        if(password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            header('Location: dashboard.php');
            exit;
        }
    }
    echo "<script>alert('Invalid Email or Password!');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - Decode Labs</title>
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background: linear-gradient(135deg, #1a0033 0%, #4a148c 50%, #1a0033 100%);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Glass wala dabba */
.login-box {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(20px); /* Glass effect */
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 25px;
  padding: 40px 35px;
  width: 350px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
}

/* Logo S wala */
.logo {
  text-align: center;
  margin-bottom: 25px;
}
.logo svg {
  width: 50px;
  height: 50px;
}
.logo h2 {
  color: white;
  font-size: 20px;
  margin-top: 10px;
  font-weight: 400;
  letter-spacing: 2px;
}

/* Yahan "Welcome Back" hata diya hai */
form label {
  color: #ddd;
  font-size: 14px;
  display: block;
  margin-top: 15px;
  margin-bottom: 6px;
}

form input {
  width: 100%;
  padding: 12px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 10px;
  color: white;
  font-size: 14px;
  outline: none;
}
form input:focus {
  border-color: #9c27b0;
  box-shadow: 0 0 10px rgba(156, 39, 176, 0.5);
}

/* Forget password link */
.forget {
  text-align: left;
  margin-top: 8px;
}
.forget a {
  color: #ddd;
  font-size: 13px;
  text-decoration: none;
}

/* Login button */
.btn-login {
  width: 100%;
  padding: 13px;
  margin-top: 25px;
  background: linear-gradient(90deg, #9c27b0, #e91e63);
  border: none;
  border-radius: 12px;
  color: white;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}
.btn-login:hover {
  transform: scale(1.02);
  box-shadow: 0 5px 20px rgba(233, 30, 99, 0.6);
}

/* Signup text */
.signup {
  text-align: center;
  margin-top: 20px;
  color: #ccc;
  font-size: 14px;
}
.signup a {
  color: white;
  font-weight: 600;
  text-decoration: none;
}
</style>
</head>
<body>

<div class="login-box">
  <div class="logo">
    <!-- S wala logo SVG -->
    <svg viewBox="0 0 24 24" fill="none" stroke="#b39ddb" stroke-width="2">
      <path d="M5 12h7l-7 6h7l7-6h-7l7-6h-7"/>
    </svg>
    <h2>DECODELAB</h2>
  </div>

  <!-- Welcome Back wali line DELETE kar di -->
  
  <form method="POST">
    <label>Email address</label>
    <input type="email" name="email" required>
    
    <label>Password</label>
    <input type="password" name="password" required>
    
    <div class="forget">
      <a href="forgot.php">Forget Password ?</a>
    </div>
    
    <button type="submit" class="btn-login">Login</button>
  </form>
  
  <div class="signup">
    Are You New Member ? <a href="register.php">Sign UP</a>
  </div>
</div>

</body>
</html>
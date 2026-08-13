<?php
session_start(); // Start session
include 'db/db.php'; // Database connection

// Login form submit check
if (isset($_POST['login'])) {

    // Get and clean username
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));

    // Encrypt password using md5
    $password = md5($_POST['password']);

    // Check admin login details
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // If login success
    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username; // Set session
        header("Location: dashboard.php"); // Redirect
        exit();
    } else {
        $error = "Invalid username or password!"; // Error message
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | Staff System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* =========================
   RESET
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
}


/* =========================
   BODY
========================= */

body {
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 30px;

    background: #0F2A2E;
}


/* =========================
   MODERN DOUBLE COLOR CARD
========================= */

.login-wrapper {
    position: relative;

    width: 100%;
    max-width: 430px;

    padding: 42px;

    border-radius: 24px;

    overflow: hidden;

    /* Double color */
    background: linear-gradient(
        to bottom,
        #0F2A2E 0%,
        #0F2A2E 42%,
        #9FE0C3 42%,
        #9FE0C3 100%
    );

    box-shadow:
        0 30px 70px rgba(0, 0, 0, 0.35);

    border: 1px solid rgba(255,255,255,0.15);
}


/* =========================
   HEADER
========================= */

.login-header {
    text-align: center;

    margin-bottom: 90px;
}


.login-header i {
    font-size: 42px;

    color: #9FE0C3;

    margin-bottom: 14px;
}


.login-header h2 {
    font-size: 25px;

    font-weight: 700;

    color: #ffffff;

    letter-spacing: -0.5px;
}


.login-header p {
    margin-top: 7px;

    font-size: 13px;

    color: #BFEADB;
}


/* =========================
   INPUT GROUP
========================= */

.form-group {
    position: relative;

    margin-bottom: 18px;
}


/* LEFT ICON */

.form-group i:first-child {
    position: absolute;

    top: 50%;
    left: 15px;

    transform: translateY(-50%);

    color: #4C6D6D;

    z-index: 2;
}


/* =========================
   INPUT
========================= */

.form-group input {
    width: 100%;

    padding: 14px 42px;

    background: rgba(255,255,255,0.75);

    color: #0F2A2E;

    border: 1px solid rgba(15,42,46,0.18);

    border-radius: 10px;

    font-size: 14px;

    outline: none;

    transition: 0.3s;
}


.form-group input::placeholder {
    color: #607B7B;
}


.form-group input:focus {
    background: #ffffff;

    border-color: #0F2A2E;

    box-shadow:
        0 0 0 3px rgba(15,42,46,0.10);
}


/* =========================
   PASSWORD EYE
========================= */

.toggle-password {
    position: absolute;

    top: 50%;
    right: 15px;

    transform: translateY(-50%);

    color: #4C6D6D;

    cursor: pointer;

    transition: 0.3s;
}


.toggle-password:hover {
    color: #0F2A2E;
}


/* =========================
   FORGOT PASSWORD
========================= */

.login-options {
    text-align: right;

    margin-bottom: 20px;

    font-size: 13px;
}


.login-options a {
    color: #0F2A2E;

    font-weight: 600;

    text-decoration: none;
}


.login-options a:hover {
    text-decoration: underline;
}


/* =========================
   LOGIN BUTTON
========================= */

.btn-login {
    width: 100%;

    padding: 14px;

    border: none;

    border-radius: 10px;

    background: #0F2A2E;

    color: #ffffff;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.3s ease;

    box-shadow:
        0 8px 20px rgba(15,42,46,0.25);
}


.btn-login:hover {
    background: #163D42;

    transform: translateY(-2px);

    box-shadow:
        0 12px 25px rgba(15,42,46,0.35);
}


/* =========================
   ERROR MESSAGE
========================= */

.error-msg {
    margin-top: 16px;

    padding: 10px;

    background: rgba(180, 40, 40, 0.12);

    color: #8B2929;

    border: 1px solid rgba(139,41,41,0.20);

    border-radius: 8px;

    font-size: 13px;

    text-align: center;
}


/* =========================
   FOOTER
========================= */

.footer-text {
    text-align: center;

    margin-top: 22px;

    font-size: 12px;

    color: #416060;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 480px) {

    .login-wrapper {
        padding: 32px 24px;

        border-radius: 20px;
    }

    .login-header {
        margin-bottom: 75px;
    }

    .login-header h2 {
        font-size: 22px;
    }
}

</style>
</head>

<body>

<div class="login-wrapper">

    <!-- Login header -->
    <div class="login-header">
        <i class="fas fa-user-shield"></i>
        <h2>Staff Profile System</h2>
        <p>Administrator Login</p>
    </div>

    <!-- Login form -->
    <form method="post">

        <!-- Username field -->
        <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <!-- Password field with eye icon -->
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <!-- Forgot password -->
        <div class="login-options">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>

        <!-- Submit button -->
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>

    <!-- Error display -->
    <?php if (isset($error)) { ?>
        <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Footer -->
    <div class="footer-text">
        © <?php echo date("Y"); ?> Staff Management System
    </div>

</div>

<!-- Show/Hide password script -->
<script>
const togglePassword = document.getElementById("togglePassword"); // Eye icon
const passwordField = document.getElementById("password"); // Password input

// Toggle password visibility
togglePassword.addEventListener("click", function () {
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
});
</script>

</body>
</html>

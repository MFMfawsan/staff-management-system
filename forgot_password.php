<?php
session_start();
include 'db/db.php';

$msg = "";
$error = "";

if (isset($_POST['reset'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = md5($_POST['new_password']);

    $check = $conn->query("SELECT * FROM admin WHERE username='$username'");

    if ($check->num_rows > 0) {
        $conn->query("UPDATE admin SET password='$new_password' WHERE username='$username'");
        $msg = "Password reset successfully. Please login.";
    } else {
        $error = "Username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* =========================
   RESET
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}


/* =========================
   PAGE
========================= */

body {
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 25px;

    background: #E8F7F0;
}


/* =========================
   MAIN CARD
========================= */

.card {
    width: 100%;
    max-width: 430px;

    padding: 0;

    overflow: hidden;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 25px 55px rgba(15, 42, 46, 0.18);

    border: 1px solid rgba(15, 42, 46, 0.08);
}


/* =========================
   HEADER
========================= */

.header {
    text-align: center;

    padding: 35px 30px 32px;

    background: #0F2A2E;

    position: relative;

    overflow: hidden;
}


/* Decorative circle */

.header::before {
    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    border-radius: 50%;

    background: rgba(159, 224, 195, 0.10);

    top: -80px;
    right: -50px;
}


.header::after {
    content: "";

    position: absolute;

    width: 100px;
    height: 100px;

    border-radius: 50%;

    background: rgba(159, 224, 195, 0.08);

    bottom: -60px;
    left: -40px;
}


/* =========================
   HEADER ICON
========================= */

.header i {
    position: relative;

    z-index: 1;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    width: 68px;
    height: 68px;

    border-radius: 50%;

    background: #9FE0C3;

    color: #0F2A2E;

    font-size: 30px;

    margin-bottom: 15px;

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.15);
}


/* =========================
   HEADER TITLE
========================= */

.header h2 {
    position: relative;

    z-index: 1;

    font-size: 23px;

    color: #ffffff;

    font-weight: 600;

    margin-bottom: 7px;
}


.header p {
    position: relative;

    z-index: 1;

    font-size: 13px;

    color: #CDEEDF;
}


/* =========================
   FORM AREA
========================= */

.card > .input-group,
.card > .btn,
.card > .msg,
.card > .back {
    margin-left: 32px;

    margin-right: 32px;
}


/* =========================
   INPUT GROUP
========================= */

.input-group {
    position: relative;

    margin-top: 20px;

    margin-bottom: 18px;
}


/* =========================
   INPUT ICON
========================= */

.input-group i {
    position: absolute;

    top: 50%;
    left: 14px;

    transform: translateY(-50%);

    color: #5C7777;

    font-size: 15px;

    z-index: 1;
}


/* =========================
   INPUT
========================= */

.input-group input {
    width: 100%;

    padding: 13px 14px 13px 42px;

    background: #F5FBF8;

    color: #0F2A2E;

    border: 1px solid #C8DDD4;

    border-radius: 10px;

    font-size: 14px;

    outline: none;

    transition: all 0.3s ease;
}


.input-group input::placeholder {
    color: #78908D;
}


/* =========================
   INPUT FOCUS
========================= */

.input-group input:focus {
    background: #ffffff;

    border-color: #0F2A2E;

    box-shadow:
        0 0 0 3px rgba(159, 224, 195, 0.35);
}


.input-group:focus-within i {
    color: #0F2A2E;
}


/* =========================
   BUTTON
========================= */

.btn {
    width: calc(100% - 64px);

    padding: 13px;

    margin-top: 5px;

    border: none;

    border-radius: 10px;

    background: #0F2A2E;

    color: #ffffff;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.3s ease;

    box-shadow:
        0 8px 18px rgba(15, 42, 46, 0.18);
}


.btn:hover {
    background: #174348;

    color: #9FE0C3;

    transform: translateY(-2px);

    box-shadow:
        0 12px 25px rgba(15, 42, 46, 0.25);
}


.btn:active {
    transform: translateY(0);
}


/* =========================
   MESSAGE
========================= */

.msg {
    margin-top: 18px;

    padding: 11px;

    border-radius: 8px;

    font-size: 13px;

    text-align: center;
}


/* =========================
   SUCCESS
========================= */

.success {
    background: #E2F5EB;

    color: #17633D;

    border: 1px solid #B9E4CC;
}


/* =========================
   ERROR
========================= */

.error {
    background: #FBE8E8;

    color: #8B3030;

    border: 1px solid #F0C4C4;
}


/* =========================
   BACK LINK
========================= */

.back {
    text-align: center;

    margin-top: 20px;

    margin-bottom: 28px;
}


.back a {
    color: #527073;

    font-size: 13px;

    text-decoration: none;

    transition: 0.3s;
}


.back a:hover {
    color: #0F2A2E;

    text-decoration: underline;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 480px) {

    body {
        padding: 15px;
    }

    .card {
        border-radius: 18px;
    }

    .header {
        padding: 30px 20px;
    }

    .header h2 {
        font-size: 21px;
    }

    .card > .input-group,
    .card > .btn,
    .card > .msg,
    .card > .back {
        margin-left: 22px;
        margin-right: 22px;
    }

    .btn {
        width: calc(100% - 44px);
    }
}
</style>
</head>

<body>

<div class="card">
    <div class="header">
        <i class="fas fa-key"></i>
        <h2>Forgot Password</h2>
        <p>Reset your administrator password</p>
    </div>

    <form method="post">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Admin Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="new_password" placeholder="New Password" required>
        </div>

        <button type="submit" name="reset" class="btn">Reset Password</button>
    </form>

    <?php if($msg): ?>
        <div class="msg success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <?php if($error): ?>
        <div class="msg error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="back">
        <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
    </div>
</div>

</body>
</html>

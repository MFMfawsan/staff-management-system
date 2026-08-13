<?php
if(session_status() == PHP_SESSION_NONE) session_start();
// Optional: check if admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Profile Management System</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-users-cog"></i>
        <span>Staff Manager</span>
    </div>
    
    <div class="admin-profile">
        <img src="../assets/uploads/profile_pics/default.JPG" alt="Admin" class="avatar-small">
        <div class="admin-info">
            <p class="admin-name"><?php echo $_SESSION['admin'] ?? 'Admin User'; ?></p>
            
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="../dashboard.php" class="nav-item">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="staff_list.php" class="nav-item">
            <i class="fas fa-address-book"></i> Staff List
        </a>
    </nav>
    <div class="sidebar-footer">
    </div>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <header class="top-header">
        <div class="breadcrumb">
            <span>Admin</span> / <span><?php echo ucfirst(str_replace('_', ' ', basename($_SERVER['PHP_SELF'], ".php"))); ?></span>
        </div>
        <div class="header-actions">
            <i class="fas fa-bell notification-icon"></i>
        </div>
    </header>
    
    <div class="content-wrapper">
        <!-- Page content goes here -->

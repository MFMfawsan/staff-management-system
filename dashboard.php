<?php
session_start();
include 'db/db.php';

// Check if admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Staff Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* =========================
   BASE
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;

    /* Soft Mint background */
    background: #E8F7F0;

    color: #0F2A2E;
}


/* =========================
   NAVBAR
========================= */

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;

    background: #0F2A2E;

    padding: 17px 30px;

    color: #fff;

    box-shadow:
        0 5px 18px rgba(15, 42, 46, 0.20);

    border-radius: 0 0 14px 14px;
}


.navbar h2 {
    margin: 0;

    font-size: 22px;

    font-weight: 600;

    color: #9FE0C3;
}


.navbar-links a {
    color: #ffffff;

    text-decoration: none;

    margin-left: 22px;

    font-weight: 500;

    transition: all 0.3s ease;
}


.navbar-links a:hover {
    color: #9FE0C3;

    border-bottom: 2px solid #9FE0C3;

    padding-bottom: 4px;
}


/* =========================
   CONTAINER
========================= */

.container {
    max-width: 1200px;

    margin: 35px auto;

    padding: 25px;
}


/* =========================
   WELCOME SECTION
========================= */

.welcome {
    text-align: center;

    margin-bottom: 35px;

    padding: 30px 20px;

    background: #0F2A2E;

    border-radius: 18px;

    box-shadow:
        0 12px 30px rgba(15, 42, 46, 0.18);
}


.welcome h2 {
    font-size: 28px;

    color: #9FE0C3;

    margin-bottom: 10px;

    font-weight: 700;
}


.welcome p {
    font-size: 15px;

    color: #D6F3E5;

    line-height: 1.6;
}


/* =========================
   CARD CONTAINER
========================= */

.card-container {
    display: flex;

    flex-wrap: wrap;

    gap: 22px;

    justify-content: center;
}


/* =========================
   CARDS
========================= */

.card {
    flex: 1 1 250px;

    background: #ffffff;

    border-radius: 16px;

    padding: 25px;

    text-align: center;

    border: 1px solid rgba(15, 42, 46, 0.08);

    box-shadow:
        0 8px 25px rgba(15, 42, 46, 0.10);

    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease,
        border-color 0.3s ease;
}


.card:hover {
    transform: translateY(-7px);

    border-color: #9FE0C3;

    box-shadow:
        0 15px 35px rgba(15, 42, 46, 0.16);
}


/* =========================
   CARD ICON
========================= */

.card i {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    width: 70px;
    height: 70px;

    border-radius: 50%;

    font-size: 32px;

    color: #0F2A2E;

    background: #9FE0C3;

    margin-bottom: 15px;

    transition: 0.3s;
}


.card:hover i {
    background: #0F2A2E;

    color: #9FE0C3;

    transform: scale(1.05);
}


/* =========================
   CARD TITLE
========================= */

.card h3 {
    font-size: 20px;

    margin-bottom: 9px;

    color: #0F2A2E;

    font-weight: 600;
}


/* =========================
   CARD DESCRIPTION
========================= */

.card p {
    font-size: 14px;

    color: #527073;

    line-height: 1.6;
}


/* =========================
   ADD BUTTON
========================= */

.add-btn {
    display: inline-block;

    padding: 11px 18px;

    border-radius: 8px;

    background: #0F2A2E;

    color: #ffffff;

    text-decoration: none;

    margin-top: 14px;

    font-size: 14px;

    font-weight: 500;

    transition: all 0.3s ease;
}


.add-btn:hover {
    background: #174348;

    color: #9FE0C3;

    transform: translateY(-2px);

    box-shadow:
        0 7px 15px rgba(15, 42, 46, 0.20);
}


/* =========================
   SECONDARY / MINT BUTTON
========================= */

.add-btn.mint {
    background: #9FE0C3;

    color: #0F2A2E;
}


.add-btn.mint:hover {
    background: #83D3B0;

    color: #0F2A2E;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {

    .navbar {
        padding: 15px 20px;

        flex-direction: column;

        gap: 12px;
    }

    .navbar h2 {
        font-size: 19px;
    }

    .navbar-links a {
        font-size: 14px;

        margin-left: 10px;
    }

    .container {
        margin: 20px auto;

        padding: 15px;
    }

    .welcome {
        padding: 25px 15px;
    }

    .welcome h2 {
        font-size: 23px;
    }

    .card-container {
        flex-direction: column;

        align-items: center;
    }

    .card {
        width: 80%;
    }
}
</style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2><i class="fas fa-users-cog"></i> Staff Manager</h2>
    <div class="navbar-links">
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="staff/staff_list.php"><i class="fas fa-address-book"></i> Staff List</a>
        <a href="staff/staff_add.php"><i class="fas fa-user-plus"></i> Add Staff</a>
        
        <a href="departments.php"><i class="fas fa-building"></i> Departments</a>
        <a href="staff/attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

    </div>
</div>

<div class="container">
    <!-- Welcome Message -->
    <div class="welcome">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <p>This is your Staff Management Dashboard.</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="card-container">
    <div class="card">
        <i class="fas fa-users"></i>
        <h3>All Staff</h3>
        <?php
        $staff_count = $conn->query("SELECT COUNT(*) as total FROM staff")->fetch_assoc()['total'];
        echo "<p>Total Staff: $staff_count</p>";
        ?>
    </div>

    <div class="card">
        <i class="fas fa-user-plus"></i>
        <h3>Add Staff</h3>
        <p>Click below to add a new staff member.</p>
        <a href="staff/staff_add.php" class="add-btn">Add Staff</a>
    </div>

    <div class="card">
        <i class="fas fa-address-book"></i>
        <h3>Staff Directory</h3>
        <p>View all staff records.</p>
        <a href="staff/staff_list.php" class="add-btn">View Staff</a>
    </div>

    <!-- NEW CARD: Departments -->
    <div class="card">
        <i class="fas fa-building"></i>
        <h3>Departments</h3>
        <?php
        $dept_count = $conn->query("SELECT COUNT(*) as total FROM staff GROUP BY department")->num_rows;
        echo "<p>Total Departments: $dept_count</p>";
        ?>
        <a href="departments.php"class="add-btn">View Departments</a>
    </div>

    <!-- NEW CARD: Attendance -->
    <div class="card">
        <i class="fas fa-calendar-check"></i>
        <h3>Attendance</h3>
        <?php
        // Count attendance records
        $attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance")->fetch_assoc()['total'];
        echo "<p>Total Records: $attendance_count</p>";
        ?>
        <a href="staff/attendance.php" class="add-btn"><i class="fas fa-eye"></i> View Attendance</a>
    </div>

<?php $conn->close(); ?>
</body>
</html>

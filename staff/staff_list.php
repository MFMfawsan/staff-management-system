<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: ../login.php");

include '../db/db.php';

$search = $_GET['search'] ?? '';
$where='';
if(!empty($search)){
    $safe = $conn->real_escape_string($search);
    $where = "WHERE staff_id LIKE '%$safe%' OR name LIKE '%$safe%' OR email LIKE '%$safe%' OR contact LIKE '%$safe%' OR designation LIKE '%$safe%' OR department LIKE '%$safe%'";
}

$result = $conn->query("SELECT * FROM staff $where ORDER BY staff_id DESC");

$uploadDir = "../assets/uploads/profile_pics/"; // folder path
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Staff Directory</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
   BODY
========================= */

body {
    min-height: 100vh;

    background:
        radial-gradient(
            circle at top left,
            rgba(159, 224, 195, 0.20),
            transparent 30%
        ),
        #E8F7F0;

    color: #0F2A2E;
}


/* =========================
   NAVBAR
========================= */

.navbar {
    background: #0F2A2E;

    color: #ffffff;

    padding: 17px 30px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    box-shadow:
        0 5px 18px rgba(15, 42, 46, 0.20);
}


.navbar h2 {
    color: #9FE0C3;

    font-size: 21px;
}


.navbar a {
    color: #ffffff;

    margin-left: 20px;

    text-decoration: none;

    font-weight: 500;

    transition: 0.3s;
}


.navbar a:hover {
    color: #9FE0C3;
}


/* =========================
   MAIN CONTAINER
========================= */

.container {
    max-width: 1300px;

    margin: 35px auto;

    padding: 0 20px;
}


/* =========================
   TOP BAR
========================= */

.top-bar {
    display: flex;

    justify-content: space-between;

    align-items: center;

    flex-wrap: wrap;

    gap: 15px;

    margin-bottom: 28px;
}


/* =========================
   SEARCH INPUT
========================= */

.top-bar input {
    padding: 12px 15px;

    width: 280px;

    background: #ffffff;

    color: #0F2A2E;

    border-radius: 9px;

    border: 1px solid #C8DDD4;

    outline: none;

    font-size: 14px;

    transition: 0.3s;
}


.top-bar input::placeholder {
    color: #78908D;
}


.top-bar input:focus {
    border-color: #0F2A2E;

    box-shadow:
        0 0 0 3px rgba(159, 224, 195, 0.35);
}


/* =========================
   ADD BUTTON
========================= */

.top-bar button,
.add-btn {
    padding: 11px 18px;

    background: #0F2A2E;

    color: #ffffff;

    border: none;

    border-radius: 9px;

    cursor: pointer;

    text-decoration: none;

    font-size: 14px;

    font-weight: 600;

    transition: all 0.3s ease;
}


.add-btn:hover,
.top-bar button:hover {
    background: #174348;

    color: #9FE0C3;

    transform: translateY(-2px);

    box-shadow:
        0 8px 18px rgba(15, 42, 46, 0.20);
}


/* =========================
   STAFF GRID
========================= */

.staff-grid {
    display: grid;

    grid-template-columns:
        repeat(auto-fill, minmax(320px, 1fr));

    gap: 24px;
}


/* =========================
   STAFF CARD
========================= */

.card {
    background: #ffffff;

    border-radius: 18px;

    padding: 24px;

    border: 1px solid rgba(15, 42, 46, 0.07);

    box-shadow:
        0 10px 28px rgba(15, 42, 46, 0.09);

    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease,
        border-color 0.3s ease;

    position: relative;

    overflow: hidden;
}


/* Decorative mint corner */

.card::before {
    content: "";

    position: absolute;

    width: 100px;
    height: 100px;

    border-radius: 50%;

    background: rgba(159, 224, 195, 0.20);

    right: -45px;
    top: -45px;

    transition: 0.3s;
}


/* =========================
   CARD HOVER
========================= */

.card:hover {
    transform: translateY(-7px);

    border-color: #9FE0C3;

    box-shadow:
        0 18px 40px rgba(15, 42, 46, 0.15);
}


.card:hover::before {
    transform: scale(1.35);
}


/* =========================
   STAFF PHOTO
========================= */

.photo {
    width: 90px;

    height: 90px;

    border-radius: 50%;

    object-fit: cover;

    border: 4px solid #9FE0C3;

    padding: 3px;

    background: #ffffff;

    position: relative;

    z-index: 1;

    transition: 0.3s;
}


.card:hover .photo {
    border-color: #0F2A2E;

    transform: scale(1.04);
}


/* =========================
   STAFF ID BADGE
========================= */

.staff-id-badge {
    display: inline-block;

    margin-top: 12px;

    padding: 4px 10px;

    background: rgba(159, 224, 195, 0.25);

    color: #0F2A2E;

    font-size: 12px;

    font-weight: 700;

    border-radius: 6px;

    letter-spacing: 0.3px;

    position: relative;

    z-index: 1;
}


/* =========================
   SECTION TITLE
========================= */

.section-title {
    font-size: 13px;

    font-weight: 700;

    color: #0F2A2E;

    margin-top: 18px;

    margin-bottom: 7px;

    text-transform: uppercase;

    letter-spacing: 0.5px;

    position: relative;
}


/* Small line */

.section-title::after {
    content: "";

    display: block;

    width: 30px;

    height: 2px;

    background: #9FE0C3;

    margin-top: 5px;

    border-radius: 5px;
}


/* =========================
   LABEL
========================= */

.label {
    font-size: 12px;

    color: #78908D;

    margin-top: 9px;

    margin-bottom: 2px;
}


/* =========================
   VALUE
========================= */

.value {
    font-size: 14px;

    font-weight: 500;

    color: #263F42;

    margin-bottom: 6px;

    line-height: 1.5;
}


/* =========================
   ACTIONS
========================= */

.actions {
    margin-top: 20px;

    padding-top: 15px;

    border-top: 1px solid #E2EEE8;
}


/* =========================
   ACTION BUTTONS
========================= */

.actions a {
    display: inline-block;

    padding: 8px 13px;

    border-radius: 7px;

    color: #ffffff;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    margin-right: 6px;

    transition: all 0.3s ease;
}


/* =========================
   EDIT
========================= */

.edit {
    background: #4E9F78;
}


.edit:hover {
    background: #397F5E;

    transform: translateY(-2px);
}


/* =========================
   DELETE
========================= */

.delete {
    background: #C95C5C;
}


.delete:hover {
    background: #A94444;

    transform: translateY(-2px);
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


    .navbar a {
        margin-left: 10px;

        font-size: 14px;
    }


    .container {
        margin: 25px auto;

        padding: 0 15px;
    }


    .top-bar {
        flex-direction: column;

        align-items: stretch;
    }


    .top-bar input {
        width: 100%;
    }


    .add-btn,
    .top-bar button {
        width: 100%;

        text-align: center;
    }


    .staff-grid {
        grid-template-columns: 1fr;

        gap: 18px;
    }


    .card {
        padding: 22px;
    }
}
</style>
</head>
<body>

<div class="navbar">
<h3>Staff Management</h3>
<div><a href="../dashboard.php">Dashboard</a></div>
</div>

<div class="container">
<div class="top-bar">
<form method="GET">
<input type="text" name="search" placeholder="Search staff..." value="<?= htmlspecialchars($search) ?>">
<button type="submit"><i class="fa fa-search"></i></button>
</form>
<a href="staff_add.php" class="add-btn"><i class="fa fa-user-plus"></i> Add Staff</a>
</div>

<div class="staff-grid">
<?php
if($result->num_rows==0){ echo "<p>No staff found.</p>"; }
else {
    while($row=$result->fetch_assoc()):
        $filename = trim($row['profile_pic'] ?? '');
        $imgPath = (!empty($filename) && file_exists($uploadDir.$filename)) ? $uploadDir.$filename : $uploadDir."default.png";

        // Format date of join nicely if present
        $doj = !empty($row['date_of_join']) ? date('d M Y', strtotime($row['date_of_join'])) : '-';
?>
<div class="card">
<img src="<?= htmlspecialchars($imgPath) ?>" class="photo" alt="Profile">
<span class="staff-id-badge">ID: <?= htmlspecialchars($row['staff_id']) ?></span>

<div class="section-title">Personal Information</div>
<div class="label">Full Name</div>
<div class="value"><?= htmlspecialchars($row['name']) ?></div>
<div class="label">Email</div>
<div class="value"><?= htmlspecialchars($row['email']) ?></div>
<div class="label">Contact</div>
<div class="value"><?= htmlspecialchars($row['contact'] ?: '-') ?></div>

<div class="section-title">Professional Details</div>
<div class="label">Designation</div>
<div class="value"><?= htmlspecialchars($row['designation'] ?: '-') ?></div>
<div class="label">Department</div>
<div class="value"><?= htmlspecialchars($row['department'] ?: '-') ?></div>
<div class="label">Date of Join</div>
<div class="value"><?= htmlspecialchars($doj) ?></div>

<div class="actions">
<a href="staff_edit.php?id=<?= $row['staff_id'] ?>" class="edit"><i class="fa fa-edit"></i></a>
<a href="staff_delete.php?id=<?= $row['staff_id'] ?>" class="delete" onclick="return confirm('Delete staff?')"><i class="fa fa-trash"></i></a>
</div>
</div>
<?php endwhile; } ?>
</div>
</div>
</body>
</html>

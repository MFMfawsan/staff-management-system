<?php
session_start(); // Start session
include 'db/db.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Redirect if not logged
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Departments | Staff System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
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
   PAGE BACKGROUND
========================= */

body {
    background:
        radial-gradient(
            circle at top left,
            rgba(159, 224, 195, 0.25),
            transparent 30%
        ),
        #E8F7F0;

    color: #0F2A2E;
}


/* =========================
   MAIN CONTAINER
========================= */

.container {
    max-width: 1200px;

    margin: 35px auto;

    padding: 20px;
}


/* =========================
   TOP HEADER
========================= */

.header {
    background:
        linear-gradient(
            135deg,
            #0F2A2E,
            #174348
        );

    padding: 25px 30px;

    border-radius: 18px;

    color: #ffffff;

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 30px;

    box-shadow:
        0 12px 30px rgba(15, 42, 46, 0.20);

    position: relative;

    overflow: hidden;
}


/* Decorative glow */

.header::after {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    background: rgba(159, 224, 195, 0.12);

    border-radius: 50%;

    right: -60px;
    top: -90px;
}


/* =========================
   HEADER TITLE
========================= */

.header h2 {
    font-size: 24px;

    font-weight: 600;

    color: #9FE0C3;

    position: relative;

    z-index: 1;
}


/* =========================
   DASHBOARD BUTTON
========================= */

.header a {
    background: #9FE0C3;

    color: #0F2A2E;

    padding: 11px 20px;

    border-radius: 9px;

    text-decoration: none;

    font-size: 14px;

    font-weight: 600;

    position: relative;

    z-index: 2;

    transition: all 0.3s ease;
}


.header a:hover {
    background: #C4F0DB;

    transform: translateY(-2px);

    box-shadow:
        0 7px 18px rgba(159, 224, 195, 0.25);
}


/* =========================
   CARD GRID
========================= */

.cards {
    display: grid;

    grid-template-columns:
        repeat(auto-fill, minmax(260px, 1fr));

    gap: 24px;
}


/* =========================
   SINGLE CARD
========================= */

.card {
    background: #ffffff;

    border-radius: 17px;

    padding: 26px;

    border: 1px solid rgba(15, 42, 46, 0.07);

    box-shadow:
        0 8px 25px rgba(15, 42, 46, 0.09);

    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease,
        border-color 0.3s ease;

    position: relative;

    overflow: hidden;
}


/* Small mint decoration */

.card::before {
    content: "";

    position: absolute;

    width: 90px;
    height: 90px;

    background: rgba(159, 224, 195, 0.18);

    border-radius: 50%;

    right: -40px;
    top: -40px;

    transition: 0.3s;
}


/* =========================
   CARD HOVER
========================= */

.card:hover {
    transform: translateY(-7px);

    border-color: rgba(159, 224, 195, 0.8);

    box-shadow:
        0 17px 38px rgba(15, 42, 46, 0.15);
}


.card:hover::before {
    transform: scale(1.4);
}


/* =========================
   ICON CIRCLE
========================= */

.card-icon {
    width: 58px;

    height: 58px;

    border-radius: 15px;

    background: #9FE0C3;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 18px;

    position: relative;

    z-index: 1;

    transition: all 0.3s ease;
}


.card-icon i {
    font-size: 24px;

    color: #0F2A2E;

    transition: 0.3s;
}


/* Icon hover */

.card:hover .card-icon {
    background: #0F2A2E;

    transform: scale(1.05);
}


.card:hover .card-icon i {
    color: #9FE0C3;
}


/* =========================
   DEPARTMENT NAME
========================= */

.card h3 {
    font-size: 19px;

    color: #0F2A2E;

    margin-bottom: 7px;

    font-weight: 600;

    position: relative;

    z-index: 1;
}


/* =========================
   STAFF COUNT
========================= */

.card p {
    font-size: 14px;

    color: #607B7D;

    line-height: 1.5;

    position: relative;

    z-index: 1;
}


/* =========================
   EMPTY TEXT
========================= */

.empty {
    text-align: center;

    font-size: 16px;

    color: #607B7D;

    grid-column: 1 / -1;

    padding: 50px 20px;

    background: #ffffff;

    border-radius: 15px;

    border: 1px dashed #9FE0C3;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {

    .container {
        margin: 20px auto;

        padding: 15px;
    }


    .header {
        padding: 22px;

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;
    }


    .header h2 {
        font-size: 21px;
    }


    .header a {
        width: 100%;

        text-align: center;
    }


    .cards {
        grid-template-columns: 1fr;

        gap: 18px;
    }


    .card {
        padding: 23px;
    }
}
</style>
</head>

<body>

<div class="container">

    <!-- Page Header -->
    <div class="header">
        <h2><i class="fas fa-building"></i> Departments Overview</h2>
        <a href="dashboard.php">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Department Cards -->
    <div class="cards">

        <?php
        // Fetch department wise staff count
        $sql = "SELECT department, COUNT(*) AS total FROM staff GROUP BY department";
        $result = $conn->query($sql);

        // Display cards
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='card'>
                    <div class='card-icon'>
                        <i class='fas fa-users'></i>
                    </div>
                    <h3>{$row['department']}</h3>
                    <p>{$row['total']} Staff Members</p>
                </div>
                ";
            }
        } else {
            echo "<div class='empty'>No departments found</div>";
        }
        ?>

    </div>

</div>

</body>
</html>

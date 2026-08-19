<?php
session_start();
include '../db/db.php';

// Check if admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

// Handle attendance form submission
if(isset($_POST['submit'])){
    $date = $_POST['date'];
    $statuses = $_POST['status']; // array of staff_id => status

    foreach($statuses as $staff_id => $status){
        // Check if attendance already exists
        $check = $conn->query("SELECT * FROM attendance WHERE staff_id=$staff_id AND date='$date'");
        if($check->num_rows > 0){
            // Update
            $conn->query("UPDATE attendance SET status='$status' WHERE staff_id=$staff_id AND date='$date'");
        } else {
            // Insert
            $conn->query("INSERT INTO attendance (staff_id, date, status) VALUES ($staff_id, '$date', '$status')");
        }
    }
    $msg = "Attendance saved successfully!";
}

// Get staff list
$staff_result = $conn->query("SELECT * FROM staff ORDER BY name ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance | Staff Manager</title>
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
   BODY
========================= */

body {
    min-height: 100vh;

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
   NAVBAR
========================= */

.navbar {
    display: flex;

    justify-content: space-between;

    align-items: center;

    background: #0F2A2E;

    padding: 17px 30px;

    color: #ffffff;

    border-radius: 0 0 16px 16px;

    box-shadow:
        0 6px 20px rgba(15, 42, 46, 0.20);

    position: relative;

    overflow: hidden;
}


/* Navbar decorative glow */

.navbar::after {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    border-radius: 50%;

    background: rgba(159, 224, 195, 0.08);

    right: -60px;
    top: -100px;
}


.navbar h2 {
    margin: 0;

    font-size: 22px;

    font-weight: 600;

    color: #9FE0C3;

    position: relative;

    z-index: 1;
}


/* =========================
   NAVIGATION LINKS
========================= */

.navbar-links {
    position: relative;

    z-index: 2;
}


.navbar-links a {
    color: #ffffff;

    text-decoration: none;

    margin-left: 20px;

    font-size: 14px;

    font-weight: 500;

    transition: all 0.3s ease;
}


.navbar-links a:hover {
    color: #9FE0C3;

    border-bottom: 2px solid #9FE0C3;

    padding-bottom: 4px;
}


/* =========================
   MAIN CONTAINER
========================= */

.container {
    max-width: 1100px;

    margin: 35px auto;

    padding: 30px;

    background: rgba(255, 255, 255, 0.96);

    border-radius: 18px;

    border: 1px solid rgba(15, 42, 46, 0.07);

    box-shadow:
        0 15px 35px rgba(15, 42, 46, 0.10);
}


/* =========================
   PAGE TITLE
========================= */

h2 {
    color: #0F2A2E;

    font-size: 24px;

    margin-bottom: 5px;

    font-weight: 700;
}


/* Optional subtitle */

.container > p {
    color: #607B7D;

    font-size: 14px;

    margin-bottom: 20px;
}


/* =========================
   TABLE WRAPPER
========================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;

    border-radius: 12px;
}


/* =========================
   TABLE
========================= */

table {
    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    margin-top: 20px;

    overflow: hidden;

    border-radius: 12px;

    border: 1px solid #D8E9E1;
}


/* =========================
   TABLE HEADER
========================= */

th {
    padding: 14px 12px;

    background: #0F2A2E;

    color: #9FE0C3;

    text-align: center;

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 0.3px;

    border: none;
}


/* =========================
   TABLE CELLS
========================= */

td {
    padding: 14px 12px;

    text-align: center;

    font-size: 14px;

    color: #304C4F;

    border-bottom: 1px solid #E1EEE8;

    border-right: 1px solid #E1EEE8;

    background: #ffffff;
}


/* Remove last borders */

td:last-child {
    border-right: none;
}


/* =========================
   TABLE ROW HOVER
========================= */

tbody tr {
    transition: all 0.2s ease;
}


tbody tr:hover td {
    background: #F2FAF6;

    color: #0F2A2E;
}


/* =========================
   STATUS SELECT
========================= */

.status-select {
    padding: 8px 30px 8px 10px;

    border-radius: 8px;

    border: 1px solid #C8DDD4;

    background: #F5FBF8;

    color: #0F2A2E;

    font-size: 13px;

    font-weight: 500;

    cursor: pointer;

    outline: none;

    transition: all 0.3s ease;
}


.status-select:hover {
    border-color: #9FE0C3;
}


.status-select:focus {
    border-color: #0F2A2E;

    box-shadow:
        0 0 0 3px rgba(159, 224, 195, 0.30);
}


/* =========================
   SUBMIT BUTTON
========================= */

.submit-btn {
    padding: 10px 18px;

    background: #0F2A2E;

    color: #ffffff;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    margin-top: 20px;

    font-size: 14px;

    font-weight: 600;

    transition: all 0.3s ease;

    box-shadow:
        0 7px 16px rgba(15, 42, 46, 0.18);
}


.submit-btn:hover {
    background: #174348;

    color: #9FE0C3;

    transform: translateY(-2px);

    box-shadow:
        0 10px 22px rgba(15, 42, 46, 0.25);
}


.submit-btn:active {
    transform: translateY(0);
}


/* =========================
   SUCCESS MESSAGE
========================= */

.msg {
    display: inline-block;

    color: #17633D;

    background: #E2F5EB;

    border: 1px solid #B9E4CC;

    padding: 9px 14px;

    border-radius: 8px;

    margin-bottom: 10px;

    font-size: 13px;

    font-weight: 500;
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
        margin-left: 10px;

        font-size: 13px;
    }


    .container {
        width: 92%;

        margin: 25px auto;

        padding: 20px;

        border-radius: 15px;
    }


    h2 {
        font-size: 21px;
    }


    table {
        min-width: 650px;
    }
}
</style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2><i class="fas fa-calendar-check"></i> Attendance</h2>
    <div class="navbar-links">
        <a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="staff_list.php"><i class="fas fa-address-book"></i> Staff List</a>
        <a href="staff_add.php"><i class="fas fa-user-plus"></i> Add Staff</a>
        <a href="../departments.php"><i class="fas fa-building"></i> Departments</a>
        <a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>Mark Attendance</h2>

    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <form method="POST" action="">
        <label for="date">Select Date:</label>
        <input type="date" name="date" id="date" required value="<?php echo date('Y-m-d'); ?>">

        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Status</th>
            </tr>

            <?php
            $i=1;
            while($staff = $staff_result->fetch_assoc()){
                // Check existing attendance for today
                $att_res = $conn->query("SELECT status FROM attendance WHERE staff_id=".$staff['staff_id']." AND date='".date('Y-m-d')."'");
                $status = $att_res->num_rows > 0 ? $att_res->fetch_assoc()['status'] : 'Present';

                echo "<tr>
                        <td>{$i}</td>
                        <td>{$staff['name']}</td>
                        <td>{$staff['designation']}</td>
                        <td>
                            <select name='status[{$staff['staff_id']}]' class='status-select'>
                                <option value='Present' ".($status=='Present'?'selected':'').">Present</option>
                                <option value='Absent' ".($status=='Absent'?'selected':'').">Absent</option>
                                <option value='Leave' ".($status=='Leave'?'selected':'').">Leave</option>
                            </select>
                        </td>
                      </tr>";
                $i++;
            }
            ?>
        </table>

        <button type="submit" name="submit" class="submit-btn">Save Attendance</button>
    </form>

    <h2>Attendance Records</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Total Staff</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Leave</th>
        </tr>

        <?php
        $dates_result = $conn->query("SELECT DISTINCT date FROM attendance ORDER BY date DESC");
        while($row = $dates_result->fetch_assoc()){
            $date = $row['date'];
            $total = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE date='$date'")->fetch_assoc()['total'];
            $present = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE date='$date' AND status='Present'")->fetch_assoc()['total'];
            $absent = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE date='$date' AND status='Absent'")->fetch_assoc()['total'];
            $leave = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE date='$date' AND status='Leave'")->fetch_assoc()['total'];

            echo "<tr>
                    <td>$date</td>
                    <td>$total</td>
                    <td>$present</td>
                    <td>$absent</td>
                    <td>$leave</td>
                  </tr>";
        }
        ?>
    </table>
</div>

<?php $conn->close(); ?>
</body>
</html>

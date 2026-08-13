<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: ../login.php");

include '../db/db.php';

if(!isset($_GET['id'])) die("No staff selected.");
$staff_id = trim($_GET['id']); // keep the ID exactly as-is, don't force it to int

// Handle form submission
if(isset($_POST['update'])){
    $updates = [];
    $params = [];
    $types = '';

    // Handle profile picture separately
    $uploadDir = "../assets/uploads/profile_pics/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error']==0){
        $fileTmp = $_FILES['profile_pic']['tmp_name'];
        $fileName = time().'_'.basename($_FILES['profile_pic']['name']);
        $filePath = $uploadDir.$fileName;
        if(move_uploaded_file($fileTmp, $filePath)){
            $updates[] = "profile_pic=?";
            $params[] = $fileName;
            $types .= 's';
        }
    }

    foreach($_POST as $col=>$value){
        if($col==='update' || $col==='staff_id' || $col==='id') continue;
        $updates[] = "$col=?";
        $params[] = $value;
        $types .= 's';
    }

    if(!empty($updates)){
        $stmt = $conn->prepare("UPDATE staff SET ".implode(', ',$updates)." WHERE staff_id=?");
        $params[] = $staff_id;
        $types .= 's'; // staff_id bound as string so alphanumeric IDs work too
        $stmt->bind_param($types, ...$params);
        if($stmt->execute()){
            header("Location: staff_list.php?msg=updated"); exit;
        } else $error = "Update failed: ".$stmt->error;
    } else $error="No data to update.";
}

// Fetch staff details
$stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id=?");
$stmt->bind_param("s",$staff_id); // string bind - matches the ID used in the link/query
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows===0) die("Staff not found.");
$staff = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Staff</title>
<style>
/* =========================
   RESET
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Arial, sans-serif;
}


/* =========================
   PAGE
========================= */

body {
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 30px;

    background:
        radial-gradient(
            circle at top left,
            rgba(159, 224, 195, 0.30),
            transparent 32%
        ),
        radial-gradient(
            circle at bottom right,
            rgba(15, 42, 46, 0.12),
            transparent 30%
        ),
        #E8F7F0;

    color: #0F2A2E;
}


/* =========================
   FORM CONTAINER
========================= */

.container {
    width: 100%;

    max-width: 500px;

    background: rgba(255, 255, 255, 0.96);

    padding: 32px;

    border-radius: 20px;

    border: 1px solid rgba(15, 42, 46, 0.08);

    box-shadow:
        0 25px 55px rgba(15, 42, 46, 0.15);

    position: relative;

    overflow: hidden;
}


/* Decorative top line */

.container::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;

    height: 5px;

    background: linear-gradient(
        90deg,
        #0F2A2E,
        #9FE0C3,
        #0F2A2E
    );
}


/* =========================
   LABEL
========================= */

label {
    display: block;

    font-weight: 600;

    font-size: 13px;

    color: #0F2A2E;

    margin-top: 15px;

    margin-bottom: 6px;
}


/* =========================
   INPUT
========================= */

input {
    width: 100%;

    padding: 13px 14px;

    margin-top: 2px;

    background: #F5FBF8;

    color: #0F2A2E;

    border: 1px solid #C8DDD4;

    border-radius: 9px;

    font-size: 14px;

    outline: none;

    transition: all 0.3s ease;
}


/* Placeholder */

input::placeholder {
    color: #78908D;
}


/* Focus */

input:focus {
    background: #ffffff;

    border-color: #0F2A2E;

    box-shadow:
        0 0 0 3px rgba(159, 224, 195, 0.35);

    transform: translateY(-1px);
}


/* =========================
   FILE INPUT
========================= */

input[type="file"] {
    padding: 9px;

    cursor: pointer;
}


input[type="file"]::file-selector-button {
    background: #9FE0C3;

    color: #0F2A2E;

    border: none;

    padding: 8px 12px;

    border-radius: 7px;

    margin-right: 10px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.3s;
}


input[type="file"]::file-selector-button:hover {
    background: #83D3B0;
}


/* =========================
   PHOTO
========================= */

img.photo {
    display: block;

    width: 105px;

    height: 105px;

    object-fit: cover;

    border-radius: 50%;

    margin: 5px auto 18px;

    padding: 4px;

    background: #ffffff;

    border: 4px solid #9FE0C3;

    box-shadow:
        0 8px 20px rgba(15, 42, 46, 0.15);

    transition: all 0.3s ease;
}


img.photo:hover {
    transform: scale(1.06);

    border-color: #0F2A2E;

    box-shadow:
        0 10px 25px rgba(15, 42, 46, 0.20);
}


/* =========================
   BUTTON
========================= */

button {
    width: 100%;

    margin-top: 24px;

    padding: 13px;

    background: #0F2A2E;

    color: #ffffff;

    border: none;

    border-radius: 9px;

    cursor: pointer;

    font-size: 15px;

    font-weight: 600;

    transition: all 0.3s ease;

    box-shadow:
        0 8px 18px rgba(15, 42, 46, 0.18);
}


/* Button hover */

button:hover {
    background: #174348;

    color: #9FE0C3;

    transform: translateY(-2px);

    box-shadow:
        0 12px 25px rgba(15, 42, 46, 0.25);
}


/* Button click */

button:active {
    transform: translateY(0);
}


/* =========================
   ERROR
========================= */

.error {
    color: #9B3535;

    background: #FBEAEA;

    border: 1px solid #F1C8C8;

    text-align: center;

    margin-bottom: 15px;

    padding: 10px;

    border-radius: 8px;

    font-size: 13px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 600px) {

    body {
        padding: 15px;
    }

    .container {
        padding: 26px 22px;

        border-radius: 16px;
    }

    img.photo {
        width: 90px;
        height: 90px;
    }
}
</style>
</head>
<body>
<div class="container">
<h2>Edit Staff</h2>
<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
<form method="post" enctype="multipart/form-data">
    <label>Staff ID</label>
    <input type="text" value="<?= htmlspecialchars($staff['staff_id'], ENT_QUOTES) ?>" readonly style="background:#E2EEE8; cursor:not-allowed;">
    <?php
    foreach($staff as $col=>$val){
        if($col=='staff_id' || $col=='id') continue;
        if($col=='profile_pic'){
            $imgPath = (!empty($val) && file_exists("../assets/uploads/profile_pics/".$val)) ? "../assets/uploads/profile_pics/".$val : "../assets/uploads/profile_pics/default.png";
            echo "<label>Profile Picture</label>";
            echo "<img src='$imgPath' class='photo'>";
            echo "<input type='file' name='profile_pic' accept='image/*'>";
        } else {
            $type="text";
            if(strpos($col,'email')!==false) $type="email";
            if(strpos($col,'contact')!==false) $type="tel";
            $label = ucwords(str_replace('_',' ',$col));
            echo "<label>$label</label>";
            echo "<input type='$type' name='$col' value='".htmlspecialchars($val,ENT_QUOTES)."' required>";
        }
    }
    ?>
    <button type="submit" name="update">Update Staff</button>
</form>
</div>
</body>
</html>

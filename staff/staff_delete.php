<?php
session_start();
include '../db/db.php';

// Security check
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Check ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: staff_list.php");
    exit();
}

$id = (int)$_GET['id'];

// Delete query
$stmt = $conn->prepare("DELETE FROM staff WHERE staff_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Success → go back to staff list
    header("Location: staff_list.php?msg=deleted");
} else {
    echo "Error deleting record";
}

$stmt->close();
$conn->close();
?>

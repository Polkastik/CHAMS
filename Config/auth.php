<!-- got tired of pasting ts in eveyrthing -->
<?php
date_default_timezone_set('Asia/Manila');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Flow/Login.php"); 
    exit;
}

$roleMap = [1 => "Admin", 2 => "MISD Staff", 3 => "Gen_User", 4 => "Intern"];

// user
$uid = $_SESSION['user_id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$fullname = $fname . " " . $lname;
// roles
$role = $_SESSION['role']; // ID yan
$rna = $_SESSION['rna'];
$roleName = $roleMap[$role] ?? "User"; 

// department
$dept = $_SESSION['dept']; // eto rin ID
$dna = $_SESSION['dna'];
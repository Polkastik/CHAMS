<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CHAMS - ACTIVITY LOG</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/actLogs.css">
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">

    <!-- so it reads it first -->
    <script src="../Assets/JS/actLog.js" defer></script>
</head>

<body>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content">
            <div class="page-header" onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-chevron-left"></i> ACTIVITY LOG
            </div>

            <?php $mode = "actLog";
            $filterId = "actLog";
            include '../Modules/filter.php' ?>

            <!-- "TILE" VIEW -->
            <?php include '../Modules/tileBox.php'; ?>
        </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/filter.js"></script>

</body>

</html>
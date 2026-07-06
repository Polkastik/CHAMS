<?php
session_start();
require_once dirname(__DIR__) . '/Config/auth.php';
require_once dirname(__DIR__) . '/Config/queryHandler.php';
$q = new QueryHandler();

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    if (ob_get_length())
        ob_clean();

    $filters = $_GET;
    $filterId = 'actLog';
    $mode = "actLog";
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;


    ob_start();
    include  dirname(__DIR__) . '/Modules/tileBox.php';
    $tilesHtml = ob_get_clean();

    ob_start();
    include  dirname(__DIR__) . '/Modules/filter.php';
    $toolbarHtml = ob_get_clean();

    header('Content-Type: application/json');

    echo json_encode([
        'tiles' => $tilesHtml,
        'toolbar' => $toolbarHtml
    ]);
    exit;
}

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - ACTIVITY LOG</title>
    <?php include  dirname(__DIR__) . '/Config/univHead.php'; ?>
    <link rel="stylesheet" href="/Assets/CSS/actLogs.css">
    <link rel="stylesheet" href="/Assets/CSS/tile.css">
    <link rel="stylesheet" href="/Assets/CSS/filter.css">
</head>

<body id="altBody">

    <?php include  dirname(__DIR__) . '/Modules/header.php' ?>

    <div class="container">
        <?php include  dirname(__DIR__) . '/Modules/sidebar.php' ?>

        <div class="content" style="overflow-y: hidden;">
            <div id="pageHeadText" style="padding-bottom: 1.5%; margin-top: -1.5%;">
                <div class="page-header" onclick="window.location.href='dashboard.php'">
                    <i class="fa-solid fa-chevron-left"></i> ACTIVITY LOG
                </div>

                <?php $mode = "actLog";
                $filterId = "actLog";
                include  dirname(__DIR__) . '/Modules/filter.php' ?>

                <div id="ticket-list-container">
                    <?php include  dirname(__DIR__) . '/Modules/tileBox.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="/Assets/JS/sidebar.js"></script>
    <script src="/Assets/JS/filter.js"></script>
    <script src="/Assets/JS/actLog.js"></script>
</body>

</html>
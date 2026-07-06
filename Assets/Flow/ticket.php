<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once  dirname(__DIR__) . '/Config/auth.php';
require_once  dirname(__DIR__) . '/Config/queryHandler.php';

$q = new QueryHandler();

$role = $_SESSION['role'];
$uid = $_SESSION['user_id'];

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    while (ob_get_level())
        ob_end_clean();

    $filters = $_GET;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $tickets = $q->getTickets($role, $uid, $filters, $page);
    $filterId = "ticketing";
    $selectedFilters = [
        'department' => $_GET['department'] ?? 'All',
        'name' => $_GET['name'] ?? 'All',
        'type' => $_GET['type'] ?? 'All',
        'item' => $_GET['item'] ?? 'All',
        'status' => $_GET['status'] ?? 'All',
        'date' => $_GET['date'] ?? '',
        'priority' => $_GET['priority'] ?? '',
        'unassigned' => $_GET['unassigned'] ?? '',
        'overdue' => $_GET['overdue'] ?? ''
    ];

    ob_start();
    include  dirname(__DIR__) . '/Modules/filter.php';
    $filterHtml = ob_get_clean();

    ob_start();
    include  dirname(__DIR__) . '/Modules/tileBox.php';
    $tilesHtml = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode([
        'toolbar' => $filterHtml,
        'tiles' => $tilesHtml
    ]);
    exit;
}

$currentPage = 'ticketing';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CHAMS - TICKETING</title>
    <?php include  dirname(__DIR__) . '/Config/univHead.php'; ?>
    <link rel="stylesheet" href="/Assets/CSS/tile.css">
    <link rel="stylesheet" href="/Assets/CSS/filter.css">
</head>

<body id="altBody">

    <?php include  dirname(__DIR__) . '/Modules/header.php' ?>

    <div class="container">
        <?php include  dirname(__DIR__) . '/Modules/sidebar.php' ?>
        <div class="content" id="content" style="overflow-x: hidden;">
            <div id="pageHeadText" style="padding: 2%; width: 105%; margin: -1.3% 0 0 -2.3%">
                <div class="page-header" onclick="window.location.href='/Flow/dashboard.php'">
                    <i class="fas fa-chevron-left"></i> TICKETS
                </div>

                <?php $mode = "tickets";
                $filterId = "ticketing";
                include  dirname(__DIR__) . '/Modules/filter.php'; ?>

                <div id="ticket-list-container">
                    <?php include  dirname(__DIR__) . '/Modules/tileBox.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="/Assets/JS/sidebar.js"></script>
    <script src="/Assets/JS/ticket.js"></script>
    <script src="/Assets/JS/filter.js"></script>
</body>

</html>
<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';

$q = new QueryHandler();

$role = $_SESSION['role'];
$uid = $_SESSION['user_id'];

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    while (ob_get_level()) ob_end_clean();

    $filters = $_GET;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $tickets = $q->getTickets($role, $uid, $filters, $page);
    $filterId = "ticketing";
    
    ob_start();
    include '../Modules/filter.php';
    $filterHtml = ob_get_clean();

    ob_start();
    include '../Modules/tileBox.php';
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
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
</head>

<body>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content" id="content">
            <div class="page-header" onclick="window.location.href='dashboard.php'">
                <i class="fas fa-chevron-left"></i> TICKETS
            </div>

<<<<<<< HEAD
            <!-- INVENTORY FILTER OVERLAY -->
=======
>>>>>>> 7f37e85 (CHAMS VERSION 1)
            <?php $mode = "tickets";
            $filterId = "ticketing";
            include '../Modules/filter.php'; ?>

            <div id="ticket-list-container">
                <?php include '../Modules/tileBox.php'; ?>
            </div>
        </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/ticket.js"></script>
    <script src="../Assets/JS/filter.js"></script>


</body>

</html>
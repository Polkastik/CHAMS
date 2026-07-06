<?php
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$role = $_SESSION['role'];
$uid = $_SESSION['user_id'];

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    while (ob_get_level()) ob_end_clean();

    $filters = $_GET;
    $tickets = $q->getTickets($role, $uid, $filters);
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

<div class="content" id="content">
    <div class="page-header" onclick="window.location.href='dashboard.php'">
        <i class="fas fa-home"></i> HOMEPAGE
    </div>

    <!-- INVENTORY FILTER OVERLAY -->
    <?php $filterId = "ticketing";
    include '../Modules/filter.php'; ?>

    <div id="ticket-list-container">
        <?php include '../Modules/tileBox.php'; ?>
    </div>
</div>
</div>

<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
require_once '../Modules/pieGraph.php';

$q = new QueryHandler();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

if (isset($_GET['ajax'])) {

    require_once '../Config/queryHandler.php';
    $q = new QueryHandler();

    // activity
    if ($_GET['ajax'] === 'activity') {
        $logs = $q->getActivityLogs([]);
        $recentLogs = array_slice($logs, 0, 5);

        foreach ($recentLogs as $log) {
            $initials = strtoupper(substr($log['FN'], 0, 1) . substr($log['LN'], 0, 1));

            echo '
            <div class="activity-item">
                <div class="initial-circle">'.$initials.'</div>
                <div class="activity-content">
                    <b>'.htmlspecialchars($log['FN'].' '.$log['LN']).'</b><br>
                    '.htmlspecialchars($log['act']).'<br>
                    <small>'.date('M d, h:i A', strtotime($log['created_at'])).'</small>
                </div>
            </div>';
        }
        exit;
    }

    // graphs / anything that show stats
    if ($_GET['ajax'] === 'graph') {
        $uid = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        $lineData = $q->getMonthlyResolved($uid, $role);
        $pieRaw = $q->getInventorySummary();
        $stats = $q->getDashboardStats();

        $total = 0;
        foreach ($pieRaw as $row) { $total += $row['total']; }
        $total = ($total == 0) ? 1 : $total;

        $processedPie = [];
        foreach ($pieRaw as $row) {
            $processedPie[$row['category_name']] = [
                'value' => ($row['total'] / $total) * 100,
                'color' => $row['category_color'] ?? '#cccccc'
            ];
        }

        ob_clean(); 
        header('Content-Type: application/json');

        echo json_encode([
            'line' => $lineData, 
            'pie' => $processedPie, 
            'stats' => $stats 
        ]);
        exit;
    }

    if ($_GET['ajax'] === 'available_tickets') {
        $uid = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        $tickets = $q->getTickets($role, $uid);

        $openTickets = array_filter($tickets ?? [], function($row) {
            return empty($row['staff_FN']) && ($row['Status'] !== 'Resolved');
        });

        $displayTickets = array_slice($openTickets, 0, 4);

        if (empty($displayTickets)) {
            echo '<div class="no-data" style="text-align:center; padding: 5vh;">No tickets found.</div>';
        } else {
            foreach ($displayTickets as $row) {
                $ticketId = htmlspecialchars($row['T_ID']);
                $isOverdue = (!empty($row['due_date']) && strtotime($row['due_date']) < time());
                
                echo '
                <div class="activity-item" style="max-height:75px;">
                    ' . ($isOverdue ? '<div class="overdue">OVERDUE</div>' : '') . '
                    <a href="tileView.php?id=' . $ticketId . '" style="text-decoration: none; display: flex; align-items: center; gap: 2%; flex: 1; color: inherit;">
                        <div class="initial-circle"><i class="fas fa-user"></i></div>
                        <div class="activity-list">
                            <div class="ticket-title">' . htmlspecialchars($row['FN'] . ' ' . $row['LN']) . ' - ' . htmlspecialchars($row['Title']) . '</div>
                            <div class="ticket-meta">' . htmlspecialchars($row['categ_name']) . '</div>
                        </div>
                        <div class="time" style="margin-left: auto;">' . timeAgo($row['created_at']) . '</div>
                    </a>
                </div>';
            }
        }
        exit;
    }
}

$uid = $_SESSION['user_id'];

$logs = $q->getActivityLogs([]);
$tickets = $q->getTickets($role, $uid);

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - HOMEPAGE</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/dashboard.css">
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Header -->
    <?php include '../Modules/header.php' ?>

    <!-- sidebar -->
    <div class="container" id="dashboard-container">
        <?php include '../Modules/sidebar.php' ?>

        <!-- main content idk why nasa loob ng container -nathan -->

        <?php
        if ($role == 1) {
            include '../Modules/adminDash.php';
        } elseif ($role == 2) {
            include '../Modules/staffDash.php';
        } else {
            include '../Modules/genDash.php';
        }
        ?>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/filter.js"></script>
    <?php if ($role !=3): ?>
        <script src="../Assets/JS/graphs.js"></script>
    <?php endif; ?>
<<<<<<< HEAD
    <script src="../Assets/JS/ticket.js"></script>
=======
    <?php if ($role === 2): ?> <script src="../Assets/JS/ticket.js"></script> <?php endif; ?>
>>>>>>> 7f37e85 (CHAMS VERSION 1)
    <script src="../Assets/JS/dashboard.js"></script>

</body>

</html>
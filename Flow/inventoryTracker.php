<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();


$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$trackerFilters = $q->getTrackerFilters();

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    while (ob_get_level()) { ob_end_clean(); }

    $filters = [
    'department' => $_GET['department'] ?? 'All',
    'item'       => $_GET['item'] ?? 'All',
    'date'       => $_GET['date'] ?? ''
    ];

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $items = $q->getFilteredTracker($filters, $page);
    $currentPage = 'inventory';

    ob_start();

    if (empty($items)) {
        echo '<tr><td colspan="10" style="text-align:center; padding: 20px;">No tracking data found.</td></tr>';
    } else {
        foreach ($items as $row) {

            if (!empty($row['reference_ticket'])) {
                $viewUrl = "../Flow/tileView.php?id=" . $row['reference_ticket'] . "&mode=ticketing";
            } else {
                $viewUrl = "../Flow/tileView.php?id=" . $row['I_ID'] . "&mode=inventory";
            }

            echo '<tr>
                <td>' . date('m/d/y', strtotime($row['date_delivered'])) . '</td>
                <td>' . htmlspecialchars($row['Dept_Name'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['item_name']) . '</td>
                <td>' . htmlspecialchars($row['item_brand']) . '</td>
                <td>' . htmlspecialchars($row['tracker_qty']) . '</td>
                <td>' . htmlspecialchars($row['Defects']) . '</td>
                <td>' . htmlspecialchars($row['item_supplier']) . '</td>
                <td>' . htmlspecialchars($row['Serial_number'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['input_by_name']) . '</td>
                <td>
                    <button class="edit-btn" onclick="window.location.href=\'' . $viewUrl . '\'">
                        <i class="fas ' . (!empty($row['reference_ticket']) ? 'fa-ticket-alt' : 'fa-box') . '"></i>
                        ' . (!empty($row['reference_ticket']) ? 'VIEW TICKET' : 'VIEW ITEM') . '
                    </button>
                </td>
            </tr>';
        }
    }

    
    $tableHTML = ob_get_clean();

    ob_start();
    $filterId = "tracker";
    $filters = $trackerFilters; 
    include '../Modules/filter.php';
    $toolbarHTML = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode([
        'table' => $tableHTML,
        'toolbar' => $toolbarHTML
    ]);
    exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - INVENTORY TRACKER</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/invTracker.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
</head>

<body>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content">
            <div class="page-header" onclick="history.back()">
                <i class="fas fa-chevron-left"></i> INVENTORY TRACKER
            </div>
            <?php $filterId = "tracker";
            $filters = $trackerFilters;
            include '../Modules/filter.php' ?>

            <div class="table-card">

                <table>
                    <thead>
                        <tr>
                            <th>Date Delivered</th>
                            <th>Department</th>
                            <th>Item</th>
                            <th>Brand</th>
                            <th>Qty</th>
                            <th>Defects</th>
                            <th>Supplier</th>
                            <th>Serial Number</th>
                            <th>Input By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="trackerTableBody">
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="10" style="text-align:center; padding: 20px;">No tracking data found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $row): ?>
                                <tr>
                                    <td><?= date('m/d/y', strtotime($row['date_delivered'])) ?></td>
                                    <td><?= htmlspecialchars($row['Dept_Name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                                    <td><?= htmlspecialchars($row['item_brand']) ?></td>
                                    <td><?= htmlspecialchars($row['tracker_qty']) ?></td>
                                    <td><?= htmlspecialchars($row['Defects']) ?></td>
                                    <td><?= htmlspecialchars($row['item_supplier']) ?></td>
                                    <td><?= htmlspecialchars($row['Serial_number'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['input_by_name']) ?></td>
                                    <td>
                                        <?php
                                        if (!empty($row['reference_ticket'])) {
                                            $viewUrl = "../Flow/tileView.php?id=" . $row['reference_ticket'] . "&mode=ticketing";
                                        } else {
                                            $viewUrl = "../Flow/tileView.php?id=" . $row['I_ID'] . "&mode=inventory";
                                        }
                                        ?>
                                        <button class="edit-btn" onclick="window.location.href='<?= $viewUrl ?>'">
                                            <i
                                                class="fas <?= !empty($row['reference_ticket']) ? 'fa-ticket-alt' : 'fa-box' ?>"></i>
                                            <?= !empty($row['reference_ticket']) ? 'VIEW TICKET' : 'VIEW ITEM' ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/filter.js"></script>

    <script>
        let trackerInterval;

        function startTrackerRefresh() {
            trackerInterval = setInterval(() => {
                const params = new URLSearchParams(window.location.search);
                params.set('ajax', 'list');

                fetch('inventoryTracker.php?' + params.toString())
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {

                        const tbody = document.getElementById('trackerTableBody');
                        if (tbody && data.table !== undefined) {
                            tbody.innerHTML = data.table;
                        }

                        const oldToolbar = document.querySelector('.toolbar');
                        if (oldToolbar && data.toolbar) {
                            const temp = document.createElement('div');
                            temp.innerHTML = data.toolbar;
                            const newToolbar = temp.querySelector('.toolbar');
                            if (newToolbar) oldToolbar.replaceWith(newToolbar);
                        }

                    })
                    .catch(err => console.error("Tracker refresh error:", err));
            }, 5000);
        }

        function stopTrackerRefresh() {
            clearInterval(trackerInterval);
        }

        startTrackerRefresh();
    </script>
</body>

</html>
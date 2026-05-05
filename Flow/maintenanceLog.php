<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$filters = $_GET ?? [];
<<<<<<< HEAD
$items = $q->getMaintenanceLogs($filters);
=======
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items = $q->getMaintenanceLogs($filters, $page);

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    ob_end_clean();

    ob_start();

    if (empty($items)) {
        echo '<tr><td colspan="8" style="text-align:center; padding: 20px;">No maintenance logs found.</td></tr>';
    } else {
        foreach ($items as $row) {

            $viewUrl = "../Flow/tileView.php?id=" . $row['M_ID'] . "&mode=maintenance";
            $prioText = !empty($row['Priority']) ? $row['Priority'] : 'Not Set';
            $prioClass = strtolower(str_replace(' ', '-', $prioText));
            $statusText = !empty($row['Status']) ? $row['Status'] : 'Not Scheduled';
            $statusClass = strtolower(str_replace(' ', '-', $statusText));

            echo '<tr>
                <td>' . htmlspecialchars($row['Asset_name']) . '</td>
                <td>' . htmlspecialchars($row['Dept_Name'] ?? 'N/A') . '</td>
                <td>' . date('M d, Y | h:i A', strtotime($row['created_at'])) . '</td>
                <td>' . htmlspecialchars($row['M_type']) . '</td>
                <td>' . htmlspecialchars($row['next_m'] ?? 'Not Scheduled') . '</td>
                <td><span class="badge ' . $prioClass . '">' . htmlspecialchars($prioText) . '</span></td>
                <td><span class="badge ' . $statusClass . '">' . htmlspecialchars($statusText) . '</span></td>
                <td>
                    <button class="edit-btn" onclick="window.location.href=\'' . $viewUrl . '\'">
                        <i class="fas fa-eye"></i> VIEW
                    </button>
                </td>
            </tr>';
        }
    }

    $tableHTML = ob_get_clean();

    ob_start();
    $mode = "maintenance";
    $filterId = "maintenance";
    include '../Modules/filter.php';
    $toolbarHTML = ob_get_clean();

    header('Content-Type: application/json');
    echo json_encode([
        'table' => $tableHTML,
        'toolbar' => $toolbarHTML
    ]);
    exit;
}
>>>>>>> 7f37e85 (CHAMS VERSION 1)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CHAMS - MAINTENANCE LOG</title>
    <?php include '../Config/univHead.php'; ?>
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/inventory.css">
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/filter.css">
    <link rel="stylesheet" href="../Assets/CSS/invTracker.css">
    <link rel="stylesheet" href="../Assets/CSS/inventory.css">
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
=======
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/filter.css">
    <link rel="stylesheet" href="../Assets/CSS/invTracker.css">
    <link rel="stylesheet" href="../Assets/CSS/mainLog.css">
>>>>>>> 7f37e85 (CHAMS VERSION 1)
</head>

<body>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php $filterId = 'maintLog';
        $mode = "maintenance";
        include '../Modules/sidebar.php';
        ?>

        <div class="content">
            <div class="page-header">
                <div onclick="window.location.href='dashboard.php'">
                    <i class="fas fa-chevron-left"></i> MAINTENANCE LOG
                </div>
                <?php if ($role === 1): ?>
                    <div class="plus-icon">
                        <div class="plus-icon-item" onclick="document.getElementById('maintModal').style.display='flex'"
                            title="Add Maintenance">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php $filterId = "maintenance";
            include '../Modules/filter.php' ?>

            <div class="table-card">

                <table>
                    <thead>
                        <tr>
                            <th>Asset Name</th>
                            <th>Department</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Next Maint.</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
<<<<<<< HEAD
                    <tbody>
=======
                    <tbody id="maintenanceTableBody">
>>>>>>> 7f37e85 (CHAMS VERSION 1)
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center; padding: 20px;">No maintenance logs found.</td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($items as $row):
                                $viewUrl = "../Flow/tileView.php?id=" . $row['M_ID'] . "&mode=maintenance";

                                $isOverdue = (!empty($row['next_m']) && strtotime($row['next_m']) < time());

                                $daysLeft = (strtotime($row['next_m']) - time()) / (60 * 60 * 24);

                                if ($isOverdue) {
                                    $priority = 'High';
                                } elseif ($daysLeft <= 3) {
                                    $priority = 'Medium';
                                } else {
                                    $priority = 'Low';
                                }

                                $status = $isOverdue ? 'Overdue' : 'Scheduled';
                                ?>
                                <tr class="<?= $isOverdue ? 'overdue-row' : '' ?>">


                                    <td><?= htmlspecialchars($row['Asset_name']) ?></td>
                                    <td><?= htmlspecialchars($row['Dept_Name'] ?? 'N/A') ?></td>
                                    <td><?= date('M d, Y | h:i A', strtotime($row['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($row['M_type']) ?></td>

                                    <td>
                                        <?php
                                        if (empty($row['next_m'])) {
                                            echo "<span>Not Scheduled</span>";
                                        } else {
                                            $seconds = strtotime($row['next_m']) - time();
                                            $days = floor($seconds / (60 * 60 * 24));

                                            if ($seconds < 0) {
                                                echo "<span>Overdue</span>";
                                            } elseif ($days <= 3) {
                                                echo "<span>$days days left</span>";
                                            } else {
                                                echo "<span>$days days left</span>";
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
<<<<<<< HEAD

                                        if (empty($row['Priority'])) {
                                            echo "<span>N/A</span>";
                                        } else {
                                            $prio = $row['Priority'];
                                            echo "<span>$prio</span>";
                                        }
=======
                                        $prioText = !empty($row['Priority']) ? $row['Priority'] : 'Not Set';

                                        $prioClass = strtolower(str_replace(' ', '-', $prioText));

                                        echo "<span class='badge $prioClass'>$prioText</span>";
>>>>>>> 7f37e85 (CHAMS VERSION 1)
                                        ?>
                                    </td>

                                    <td>
                                        <?php
<<<<<<< HEAD
                                        if (empty($row['Status'])) {
                                            echo "<span>Not Scheduled</span>";
                                        } else {
                                            $status = $row['Status'];
                                            echo "<span>$status</span>";
                                        }
=======
                                        $statusText = !empty($row['Status']) ? $row['Status'] : 'Not Scheduled';

                                        $statusClass = strtolower(str_replace(' ', '-', $statusText));

                                        echo "<span class='badge $statusClass'>$statusText</span>";
>>>>>>> 7f37e85 (CHAMS VERSION 1)
                                        ?>
                                    </td>
                                    <td>
                                        <button class="edit-btn" onclick="window.location.href='<?= $viewUrl ?>'">
                                            <i class="fas fa-eye">VIEW</i>
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

    <!-- create maintenance popup -->
    <div id="maintModal" class="modal-overlay">
        <?php $departments = $q->getDepartments();  ?>
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-tools"></i>
                <h3>Create Maintenance</h3>
            </div>

            <form action="../Config/updateAction.php" method="POST">
                <input type="hidden" name="mode" value="maintenance_create">

                <div class="form-group">
                    <label>Asset Name *</label>
                    <input type="text" name="asset_name" class="form-control" required>

                </div>

                <div class="form-group">
                    <label>Department *</label>
                    <select name="Dept_ID" class="form-control" required>
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['D_ID'] ?>">
                                <?= htmlspecialchars($dept['Dept_Name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Maintenance Type *</label>
                    <select name="m_type" class="form-control" required>
                        <option value="">Unassigned</option>
                        <option value="Preventive">Preventive</option>
                        <option value="Predictive">Predictive</option>
                        <option value="Corrective">Corrective</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority" class="form-control">
                        <option value="">N/A</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Unscheduled</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Next Maintenance</label>
                    <select name="interval" class="form-control">
                        <option value="">Unassigned</option>
                        <option value="+1 month">Monthly</option>
                        <option value="+3 months">Quarterly</option>
                        <option value="+6 months">Semi-Annual</option>
                        <option value="+1 year">Annual</option>
                    </select>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn cancel"
                        onclick="document.getElementById('maintModal').style.display='none'">
                        Cancel
                    </button>

                    <button type="submit" class="btn download">
                        <i class="fas fa-plus"></i>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/maintLog.js"></script>
    <script src="../Assets/JS/filter.js"></script>
</body>

</html>
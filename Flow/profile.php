<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/Config/auth.php';
require_once dirname(__DIR__) . '/Config/queryHandler.php';
$q = new QueryHandler();

// Normalize variables safely to protect structural layout loops
$role = isset($_SESSION['role']) ? (int)$_SESSION['role'] : 0; 
$uid  = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// BACKEND ROUTE: AJAX Call handling the update changes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['ajax']) && $_GET['ajax'] === 'update_status') {
    ob_clean();
    header('Content-Type: application/json');
    
    if ($role !== 1) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
        exit;
    }
    
    $targetId = isset($_POST['userId']) ? (int)$_POST['userId'] : 0;
    $newStatus = isset($_POST['status']) ? (int)$_POST['status'] : 1;
    
    $updated = $q->updateStaffStatus($targetId, $newStatus);
    echo json_encode(['success' => $updated]);
    exit;
}

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$tableData = ($role == 1) ? $q->getStaffPerformanceTable() : [];
$chartData = $q->getMonthlyResolved($uid, $role); 
$staffActivity = ($role == 2) ? $q->getStaffRecentActivity($uid) : [];

if ($role == 1 || $role == 2) {
    $perf = $q->getPerformanceStats($role, $uid);
    $avgLabel = ($role == 1) ? "MISD's Average Response Time:" : "Your Average Response Time:";
    $dailyLabel = "Daily Average Completed Tickets:";
}

function getPerformanceStatus($avg)
{
    if ($avg <= 2) return "EXCELLENT";
    if ($avg <= 5) return "GOOD";
    return "POOR";
}

$isAjax = isset($_GET['ajax']) && $_GET['ajax'] === 'graph';
if ($isAjax) {
    ob_clean();
    $chartData = $q->getMonthlyResolved($uid, $role);
    header('Content-Type: application/json');
    echo json_encode(['line' => $chartData]);
    exit;
}

if (isset($_GET['ajax']) && $_GET['ajax'] === 'activity') {
    ob_clean();
    $rows = '';

    if ($role == 1) {
        $tableData = $q->getStaffPerformanceTable();
        foreach ($tableData as $row) {
            $status = ($row['avg_time'] <= 2) ? 'excellent' : (($row['avg_time'] <= 5) ? 'good' : 'poor');
            $rows .= "
                <tr>
                    <td>{$row['full_name']}</td>
                    <td>{$row['ticket_count']}</td>
                    <td>{$row['avg_time']} hrs</td>
                    <td>
                        <span class='performance-tag {$status}'>
                            " . getPerformanceStatus($row['avg_time']) . "
                        </span>
                    </td>
                </tr>
            ";
        }
    } else {
        $staffActivity = $q->getStaffRecentActivity($uid);
        foreach ($staffActivity as $row) {
            $status = ($row['response_time'] <= 2) ? 'excellent' : (($row['response_time'] <= 5) ? 'good' : 'poor');
            $rows .= "
                <tr>
                    <td>
                        " . htmlspecialchars(strtoupper($row['ticket_num'])) . "<br>
                        <small>" . date("M d, Y h:i A", strtotime($row['resolved_at'])) . "</small>
                    </td>
                    <td>{$row['response_time']} hrs</td>
                    <td>
                        <span class='performance-tag {$status}'>
                            " . getPerformanceStatus($row['response_time']) . "
                        </span>
                    </td>
                </tr>
            ";
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['table' => $rows]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CHAMS - PROFILE</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
    <link rel="stylesheet" href="../Assets/CSS/profile.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body id="altBody">
    <?php include dirname(__DIR__) . '/Modules/header.php' ?>

    <div class="container">
        <?php include dirname(__DIR__) . '/Modules/sidebar.php' ?>

        <div class="content">
            <div id="pageHeadText" style="margin: -1.5% -2.5% 0 -2%;">
                <?php if ($role === 1): ?>
                    <div class="page-header" style="font-size: 20px; display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span onclick="history.back()" style="cursor: pointer;">
                            <i class="fa-solid fa-chevron-left"></i> SYSTEM ADMINISTRATOR PROFILE
                        </span>
                        <button type="button" onclick="openStaffModal()" style="margin-right: 25px; padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                            <i class="fas fa-users-gear"></i> Manage Staff
                        </button>
                    </div>
                <?php else: ?>
                    <div class="page-header" onclick="history.back()" style="font-size: 20px; cursor: pointer;">
                        <i class="fa-solid fa-chevron-left"></i> PROFILE
                    </div>
                <?php endif; ?>

                <div class="summary-container">
                    <div class="summary-left">
                        <div class="summary-avatar">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="summary-info">
                            <h2><?php echo htmlspecialchars($fullname) ?></h2>
                            <span><?php echo htmlspecialchars($rna) ?></span>

                            <div class="summary-report">
                                <h3>SUMMARY PERFORMANCE REPORT</h3>
                                <div class="stat-item">
                                    <span><?= $avgLabel ?></span>
                                    <strong><?= isset($perf['avg_time']) ? $perf['avg_time'] : '0' ?> Hours</strong>
                                </div>
                                <?php if ($role == 1): ?>
                                    <div class="stat-item">
                                        <span><?= $dailyLabel ?></span>
                                        <strong><?= isset($perf['daily_avg']) ? $perf['daily_avg'] : '0' ?> / day</strong>
                                    </div>
                                <?php endif; ?>
                                <div class="stat-item">
                                    <span>
                                        <?= ($role == 1) ? "MISD's Ticket Resolved this Month:" : "Your Tickets Resolved this Month:" ?>
                                    </span>
                                    <strong><?= isset($perf['resolved_month']) ? $perf['resolved_month'] : '0' ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-box">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>

                <div class="table-box">
                    <table>
                        <thead>
                            <tr><th>(weekly)</th></tr>
                            <tr>
                                <?php if ($role == 1): ?>
                                    <th>Staff Name</th>
                                    <th>Ticket Counts</th>
                                    <th>Avg Response Time</th>
                                    <th>Performance Status</th>
                                <?php else: ?>
                                    <th>Recent Activity</th>
                                    <th>Response Time</th>
                                    <th>Performance</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($role == 1): ?>
                                <?php foreach ($tableData as $row):
                                    $status = ($row['avg_time'] <= 2) ? 'excellent' : (($row['avg_time'] <= 5) ? 'good' : 'poor');
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                                        <td><?= $row['ticket_count'] ?></td>
                                        <td><?= $row['avg_time'] ?> hrs</td>
                                        <td>
                                            <span class="performance-tag <?= $status ?>">
                                                <?= getPerformanceStatus($row['avg_time']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php if (!empty($staffActivity)): ?>
                                    <?php foreach ($staffActivity as $row):
                                        $status = ($row['response_time'] <= 2) ? 'excellent' : (($row['response_time'] <= 5) ? 'good' : 'poor');
                                    ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars(strtoupper($row['ticket_num'])) ?><br>
                                                <small><?= date("M d, Y h:i A", strtotime($row['resolved_at'])) ?></small>
                                            </td>
                                            <td><?= $row['response_time'] ?> hrs</td>
                                            <td>
                                                <span class="performance-tag <?= $status ?>">
                                                    <?= getPerformanceStatus($row['response_time']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" style="text-align:center;">No recent activity</td></tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if ($role === 1): 
        $staffAccounts = $q->getAllStaff(); 
    ?>
    <div id="staffStatusModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div style="background: white; padding: 25px; border-radius: 6px; width: 80%; max-width: 750px; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <div onclick="closeStaffModal()" style="position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #aaa;">&times;</div>
            <h2 style="margin-top: 0;"><i class="fas fa-users-gear"></i> Manage Staff Listing</h2>
            
            <div style="max-height: 400px; overflow-y: auto; margin-top: 15px; border: 1px solid #ddd; border-radius: 4px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 12px;">Staff Name</th>
                            <th style="padding: 12px;">Status</th>
                            <th style="padding: 12px; text-align: center; width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($staffAccounts)): ?>
                            <tr><td colspan="3" style="text-align: center; padding: 20px;">No staff logs discovered in system.</td></tr>
                        <?php else: foreach ($staffAccounts as $staff): 
                            $statusVal = isset($staff['account_status']) ? (int)$staff['account_status'] : 1;
                            
                            $statusLabel = 'Active';
                            $badgeColor = '#28a745';
                            if ($statusVal === 0) { $statusLabel = 'Disabled'; $badgeColor = '#dc3545'; }
                            if ($statusVal === 2) { $statusLabel = 'Retired'; $badgeColor = '#6c757d'; }
                        ?>
                            <tr id="row-<?= $staff['U_ID'] ?>" style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 12px; font-weight: 500;"><?= htmlspecialchars($staff['FN'] . ' ' . $staff['LN']) ?></td>
                                
                                <td style="padding: 12px;">
                                    <div id="view-container-<?= $staff['U_ID'] ?>">
                                        <span id="badge-<?= $staff['U_ID'] ?>" style="padding: 4px 8px; color: white; border-radius: 4px; font-size: 12px; background-color: <?= $badgeColor ?>;">
                                            <?= $statusLabel ?>
                                        </span>
                                    </div>
                                    
                                    <div id="edit-container-<?= $staff['U_ID'] ?>" style="display: none;">
                                        <select id="select-<?= $staff['U_ID'] ?>" style="padding: 4px; border-radius: 4px;">
                                            <option value="1" <?= $statusVal === 1 ? 'selected' : '' ?>>Active</option>
                                            <option value="0" <?= $statusVal === 0 ? 'selected' : '' ?>>Disabled</option>
                                            <option value="2" <?= $statusVal === 2 ? 'selected' : '' ?>>Retired</option>
                                        </select>
                                    </div>
                                </td>
                                
                                <td style="padding: 12px; text-align: center;">
                                    <button type="button" id="btn-edit-<?= $staff['U_ID'] ?>" onclick="enableEditMode(<?= $staff['U_ID'] ?>)" style="padding: 5px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>
                                    
                                    <button type="button" id="btn-save-<?= $staff['U_ID'] ?>" onclick="saveStaffStatus(<?= $staff['U_ID'] ?>)" style="display: none; padding: 5px 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function openStaffModal() {
        document.getElementById('staffStatusModal').style.display = 'flex';
    }
    
    function closeStaffModal() {
        document.getElementById('staffStatusModal').style.display = 'none';
    }

    function enableEditMode(userId) {
        // Show the dropdown select, hide the text badge
        document.getElementById('view-container-' + userId).style.display = 'none';
        document.getElementById('edit-container-' + userId).style.display = 'block';
        
        // Swap out the Action control buttons
        document.getElementById('btn-edit-' + userId).style.display = 'none';
        document.getElementById('btn-save-' + userId).style.display = 'inline-block';
    }

    function disableEditMode(userId) {
        // Show the text badge, hide the dropdown select
        document.getElementById('view-container-' + userId).style.display = 'block';
        document.getElementById('edit-container-' + userId).style.display = 'none';
        
        // Swap back the Action control buttons
        document.getElementById('btn-edit-' + userId).style.display = 'inline-block';
        document.getElementById('btn-save-' + userId).style.display = 'none';
    }
    
    function saveStaffStatus(userId) {
        const selectEl = document.getElementById('select-' + userId);
        const newStatus = selectEl.value;
        
        const params = new URLSearchParams();
        params.append('userId', userId);
        params.append('status', newStatus);
        
        fetch('profile.php?ajax=update_status', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/x-www-form-urlencoded' 
            },
            body: params
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const badge = document.getElementById('badge-' + userId);
                
                // Update UI text and theme elements dynamically
                if (newStatus == 1) {
                    badge.innerText = 'Active';
                    badge.style.backgroundColor = '#28a745';
                } else if (newStatus == 0) {
                    badge.innerText = 'Disabled';
                    badge.style.backgroundColor = '#dc3545';
                } else if (newStatus == 2) {
                    badge.innerText = 'Retired';
                    badge.style.backgroundColor = '#6c757d';
                }
                
                // Exit edit mode smoothly back to display row state
                disableEditMode(userId);
            } else {
                alert('Error updating user state configuration: ' + (data.message || 'Unknown issue'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Connection failure error changing database settings.');
        });
    }
    </script>
    <?php endif; ?>

    <script src="../Assets/JS/profile.js"></script>
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/graphs.js"></script>
</body>
</html>
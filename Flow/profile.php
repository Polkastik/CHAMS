<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$tableData = ($role == 1) ? $q->getStaffPerformanceTable() : [];
$chartData = $q->getMonthlyResolved($uid, $role); // change this to getWeeklyResolved if you want Weekly
$staffActivity = ($role == 2) ? $q->getStaffRecentActivity($uid) : [];

if ($role == 1 || $role == 2) {
    $perf = $q->getPerformanceStats($role, $uid);

    // Define labels based on role
    $avgLabel = ($role == 1) ? "MISD's Average Response Time:" : "Your Average Response Time:";
    $dailyLabel = ($role == 1) ? "Daily Average Completed Tickets:" : "Daily Average Completed Tickets:";
}

function getPerformanceStatus($avg)
{
    if ($avg <= 2)
        return "EXCELLENT";
    if ($avg <= 5)
        return "GOOD";
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
            $status = ($row['avg_time'] <= 2) ? 'excellent' :
                (($row['avg_time'] <= 5) ? 'good' : 'poor');

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
            $status = ($row['response_time'] <= 2) ? 'excellent' :
                (($row['response_time'] <= 5) ? 'good' : 'poor');

            $rows .= "
                <tr>
                    <td>
                        {$row['Title']}<br>
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
    <?php include '../Modules/header.php' ?>


    <div class="container">
        <?php include '../Modules/sidebar.php' ?>


        <div class="content">
            <div id="pageHeadText" style="margin: -1.5% -2.5% 0 -2%;">
                <?php if ($role === 1): ?>
                    <div class="page-header" onclick="history.back()" style="font-size: 20px;">
                        <i class="fa-solid fa-chevron-left"></i> SYSTEM ADMINISTRATOR PROFILE
                    </div>
                <?php else: ?>
                    <div class="page-header" onclick="history.back()" style="font-size: 20px;">
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
                                    <strong><?= $perf['avg_time'] ?> Hours</strong>
                                </div>
                                <?php if ($role == 1): ?>
                                    <div class="stat-item">
                                        <span><?= $dailyLabel ?></span>
                                        <strong><?= $perf['daily_avg'] ?> / day</strong>
                                    </div>
                                <?php endif; ?>
                                <div class="stat-item">
                                    <span>
                                        <?= ($role == 1) ? "MISD's Ticket Resolved this Month:" : "Your Tickets Resolved this Month:" ?>
                                    </span>
                                    <strong>
                                        <?= $perf['resolved_month'] ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="chart-box">
                        <canvas id="performanceChart"></canvas>
                        <!-- graph goes here -->
                    </div>
                </div>


                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>(weekly)</th>
                            </tr>
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
                                    $status = ($row['avg_time'] <= 2) ? 'excellent' :
                                        (($row['avg_time'] <= 5) ? 'good' : 'poor');
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
                                        $status = ($row['response_time'] <= 2) ? 'excellent' :
                                            (($row['response_time'] <= 5) ? 'good' : 'poor');
                                        ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($row['Title']) ?><br>
                                                <small>
                                                    <?= date("M d, Y h:i A", strtotime($row['resolved_at'])) ?>
                                                </small>
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
                                    <tr>
                                        <td colspan="3" style="text-align:center;">No recent activity</td>
                                    </tr>
                                <?php endif; ?>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../Assets/JS/profile.js"></script>
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/graphs.js"></script>
</body>

</html>
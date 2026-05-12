<?php
session_start();
ob_clean();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$firstName = $user['FN'] ?? ''; 
$lastName = $user['LN'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CHAMS - SETTING</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/setting.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
</head>

<body>
<div class="ball"></div>
    <?php include '../Modules/header.php' ?>


    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

    <!-- Overlays -->
        <div id="bugOverlay">
            <div class="bug-container">
                <div class="bug-close" onclick="closeBugReport()">×</div>
                <div class="bug-icon"><i class="fas fa-bug"></i></div>
                <h2>REPORT A BUG</h2>
                <textarea class="bug-textarea" id="bugInput" placeholder="Describe the issue here..."></textarea>
                <br>
                <button class="bug-submit" onclick="submitBug()" id="submitBugBtn">
                    <span id="btnText">Submit Report</span>
                    <span id="btnLoader" style="display: none;">
                        <i class="fa fa-spinner fa-spin"></i> Sending...
                    </span>
                </button>
            </div>
        </div>

        <!-- setting start -->
        <div class="content">
            <div class="page-header" id="pageHeadText" style="width: 19%; padding: 2%;"
             onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-chevron-left"></i> SETTINGS
            </div>

            <div class="settings-card">
                <div class="profile-section">
                    <div class="big-avatar"><i class="fas fa-user"></i></div>
                    <div class="big-name"><?php echo htmlspecialchars($fullname); ?></div>
                    <div class="big-role">
                        <?php echo htmlspecialchars($rna . " | " . $dna) ?>
                    </div>

                    <div class="action-container">
                        <?php if ($role === 2): ?>
                            <div class="profile-btn" onclick="window.location.href='profile.php'">

                                <i class="fas fa-user-circle"></i>
                                <span>Account Profile</span>
                                <i class="fas fa-chevron-right"
                                    style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="profile-btn" onclick="openEditName()">
                            <i class="fas fa-edit"></i>
                            <span>Change Display Name</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <div class="profile-btn" onclick="openChangePassword()">
                            <i class="fas fa-lock"></i>
                            <span>Security & Password</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>
                        <div class="profile-btn" onclick="window.location.href='faqs.php'">
                            <i class="fas fa-question-circle"></i>
                            <span>Frequently Asked Questions</span>
                            <i class="fas fa-chevron-right"
                                style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <div class="report-bug" onclick="openBugReport()">
                            <i class="fas fa-bug"></i>
                            <span>Report a Bug</span>
                            <i class="fas fa-chevron-right"
                                style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <!-- <div class="profile-btn" onclick="toggleDarkMode()">
                            <i class="fas fa-moon"></i>
                            <span>Dark Mode</span>
                            <div class="custom-switch" style="margin-left: auto;"> </div>
                        </div> -->

                        <div class="signout-btn" onclick="window.location.href='../Config/logout.php'">
                            <i class="fas fa-power-off"></i>
                            <span>Sign Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/setting.js"></script>
    <script src="../Assets/JS/background.js"></script>
</body>

</html>
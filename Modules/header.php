<?php
require_once '../Config/queryHandler.php';
if (!isset($q)) {
    $q = new QueryHandler();
}

if (!isset($_SESSION)) {
    session_start();
}

$role = $_SESSION['role'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$fullname = $fname . " " . $lname;


$notifs = $q->getActiveNotifications($_SESSION['user_id']);
$unreadCount = count($notifs);

if (isset($_GET['ajax']) && $_GET['ajax'] === 'notif_count') {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['count' => $unreadCount]);
    exit; 
}
?>

<div class="topbar">
    <div class="top-left">
        <i class="fas fa-bars menu-icon" onclick="toggleMenu()"></i>
        <div class="logo">
            <img src="../Assets/Images/ICONS/CHAMS.png" alt="CHAMS Logo"
                onclick="window.location.href='../Flow/dashboard.php'">
        </div>
    </div>

    <!-- search -->
    <!-- <div class="search-box">
        <div class="search-wrapper">
            <input type="text" id="globalSearch" placeholder="Search tickets, assets..." onkeyup="doGlobalSearch(this.value)">
            <i class="fas fa-search"></i>
            <div id="searchDropdown" class="search-results-dropdown" style="display: none;"></div>
        </div>
    </div> -->

    <!-- notification -->
    <div class="notif-wrapper">
        <i class="fas fa-bell" id="notif" onclick="toggleNotif()"></i>

        <span class="notif-count" style="<?= ($unreadCount == 0) ? 'display: none;' : '' ?>">
            <?= $unreadCount ?>
        </span>

        <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                <h4 style="margin: 0;">Notifications</h4>
                <?php if (!empty($notifs)): ?>
                    <span class="clear-all-btn" onclick="clearAllNotifs()" style="font-size: 0.7rem; color: #7981be; cursor: pointer; font-weight: bold;">
                        Mark all as read
                    </span>
                <?php endif; ?>
            </div>

            <?php if (!empty($notifs)): ?>
                <?php foreach ($notifs as $n): ?>
                    <div class="notif-item unread" style="cursor: pointer;" 
                    onclick='goToNotif(<?= (int)$n["N_ID"] ?>, <?= json_encode($n["type"]) ?>, <?= (int)$n["ref_id"] ?>)'>
                        <?= htmlspecialchars($n['message']) ?>
                        <p style="font-size:x-small; padding-left: 5%;"><?= timeAgo($n['created_at']) ?></p>
                        <button class="dismiss-btn" onclick="event.stopPropagation(); deleteNotifOnly(<?= $n['N_ID']; ?>, this);">
                            &times;
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="notif-item">No notifications</div>
            <?php endif; ?>
        </div>
    </div>
</div>
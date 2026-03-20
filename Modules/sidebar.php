<?php
if (!isset($_SESSION)) {
    session_start();
}

$role = $_SESSION['role'];
$rna = $_SESSION['rna'];
$dept = $_SESSION['dept'];
$dna = $_SESSION['dna'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$fullname = $fname . " " . $lname;
?>

<script>
    (function() {
        const savedState = localStorage.getItem("sidebarState");
        if (savedState === "collapsed") {
            document.documentElement.classList.add('sidebar-is-collapsed');
        }
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="sidebar" id="sidebar">
    <?php if ($role !=3): ?>
        <div class="profile-card" onclick="window.location.href='../Flow/profile.php'" style="cursor: pointer;">
    <?php else: ?>
        <div class="profile-card">
    <?php endif; ?>
        <div class="profile-area-sync">
            <div class="profile-icon-big">
                <i class="fas fa-user-circle"></i>
            </div>

            <div class="profile-name-sync real-name"><?php echo htmlspecialchars($fullname); ?></div>

            <div class="staff-badge">
                <?php echo htmlspecialchars($rna . " | " . $dna) ?>
            </div>

            <div class="profile-label">PROFILE</div>
        </div>
    </div>

    <!-- Menu/Contents -->
    <div class="menu">

        <?php if($role == 3): ?>

        <button class="sidebar-action-btn btn-new" onclick="window.location.href='createTicket.php'">
            <i class="fas fa-plus"></i> <span>NEW</span>
        </button>

        <a href="dashboard.php" style="text-decoration: none;">
                <div class="menu-item"><i class="fas fa-home"></i> <span>HOMEPAGE</span></div>
            </a>

        <?php endif; ?>
        
        
        
        <?php if ($role != 3): ?>
            <a href="dashboard.php" style="text-decoration: none;">
                <div class="menu-item"><i class="fas fa-gauge"></i> <span>DASHBOARD</span></div>
            </a>

            <a href="ticket.php" style="text-decoration: none;">
                <div class="menu-item"><i class="fas fa-ticket-alt"></i> <span>TICKETS</span></div>
            </a>

            <a href="inventory.php" style="text-decoration: none;">
                <div class="menu-item"><i class="fas fa-box"></i> <span>INVENTORY</span></div>
            </a>

            <a href="inventoryTracker.php" style="text-decoration: none;">
                <div class="menu-item"><i class="fas fa-search"></i> <span>INVENTORY TRACKER</span></div>
            </a>

            <?php if ($role == 1): ?>
                <a href="maintenanceLog.php" style="text-decoration: none;">
                    <div class="menu-item"><i class="fas fa-clipboard-list"></i> <span>MAINTENANCE LOG</span></div>
                </a>

                <a href="activityLog.php" style="text-decoration: none;">
                    <div class="menu-item"><i class="fas fa-history"></i> <span>ACTIVITY LOG</span></div>
                </a>

                <a href="profile.php" style="text-decoration: none;">
                    <div class="menu-item"><i class="fas fa-chart-line"></i> <span>PERFORMANCE</span></div>
                </a>
            <?php endif; ?>

        <?php endif; ?>

        
    </div>
    <a href="setting.php" style="text-decoration: none;">
        <div class="menu-item" id="side-foot"><i class="fas fa-cog"></i> <span>SETTINGS</span></div>
    </a>
    <a href="../Config/logout.php" style="text-decoration: none;" class="signout">
        <i class="fas fa-sign-out-alt"></i> <span>SIGN OUT</span>
    </a>

</div>

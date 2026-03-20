<?php
require_once  dirname(__DIR__) . '/Config/auth.php';
require_once  dirname(__DIR__) . '/Config/db.php';
require_once  dirname(__DIR__) . '/Config/queryHandler.php';

$db = new database();

if (!isset($q)) {
    $q = new QueryHandler();
}

if (isset($db) && method_exists($db, 'connect')) {
    $db->connect();
}

if ($filterId === 'maintenance') {
    $filterData = $q->getMaintenanceFilterData();
} else {
    $filterData = $q->getTicketFilterData();
}

$sort = $q->getSortSettings();
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$selectedFilters = [
    'department' => $_GET['department'] ?? 'All',
    'name' => $_GET['name'] ?? 'All',
    'type' => $_GET['type'] ?? 'All',
    'item' => $_GET['item'] ?? 'All',
    'status' => $_GET['status'] ?? 'All',
    'date' => $_GET['date'] ?? '',
    'priority' => $_GET['priority'] ?? 'All',
    'overdue' => $_GET['overdue'] ?? '0',
    'unassigned' => $_GET['unassigned'] ?? '0'
];

if ($filterId === 'actLog') {
    $logs = $q->getActivityLogs($selectedFilters, $page);
} elseif ($filterId === 'tracker') {
    $items = $q->getFilteredTracker($selectedFilters, $page);
} elseif ($filterId === 'ticketing') {
    $tickets = $q->getTickets($role, $uid, $selectedFilters, $page);
} elseif ($filterId === 'maintenance') {
    $items = $q->getMaintenanceLogs($selectedFilters, $page);
}

$departments = $filterData['departments'];
$status = $filterData['status'];
$allNames = $filterData['name'] ?? [];
$deptGroups = $filterData['groups'] ?? [];
$trackerData = $q->getTrackerFilters();
$allItems = $trackerData['item'];

if ($filterId === 'maintenance') {
    $filterOptions = [
        'department' => $departments,
        'status' => $status
    ];
} elseif ($filterId === 'ticketing') {
    $filterOptions = [
        'department' => $departments,
        'name' => $allNames,
        'type' => $q->getFilterTypes($filterId),
        'status' => $status,
        'priority' => ['All', 'Low', 'Medium', 'High']
    ];
} else {
    $filterOptions = [
        'department' => $departments,
        'item' => $allItems
    ];
}

$pagination = $q->getPaginationData($filterId, $page, 5, $role, $uid, $selectedFilters);

echo "<script> const DEPT_DATA = " . json_encode($deptGroups) . "; </script>";
?>

<!-- the filter inside the white bar like a header -->
<div class="toolbar">
    <div class="toolbar-left">
        <?php if ($filterId === 'ticketing' && $role !=3): ?>
        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this, '<?= $filterId ?>')">
        <label for="selectAll" style="font-size: 0.8vw; cursor: pointer; margin-right: 15px;">Select All</label>

            <div id="actionMenu" class="custom-select" onclick="toggleInventorySelect(this)">
                <span class="select-label"><i class="fas fa-cog"></i></span>
                <div class="dropdown-menu">
                    <?php if ($role != 2):?>
                        <div class="dropdown-item" onclick="bulkAction('delete')" id="delete">Delete</div>
                    <?php else: ?>
                        <div class="dropdown-item" id="delete">Can't Delete</div>
                    <?php endif; ?>
                    <?php if ($role != 3): ?>
                        <div class="dropdown-item" onclick="bulkAction('resolve')" id="resolve">Resolve</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $params = $_GET;
        unset($params['ajax']);
        ?>

        <a href="?<?= http_build_query(array_merge($params, ['sort' => $sort['next']])) ?>"
            style="text-decoration:none; color:inherit;">
            <span id="sortBtn">Sort by: <?= $sort['label'] ?></span>
        </a>
    </div>

    <div style="font-size: 0.8vw; color: #888; font-weight: 600; display: flex; align-items: center; gap: 10px;">
        <?= $pagination['display'] ?>

        <?php if ($page > 1): ?>
            <i class="fas fa-angle-double-left" onclick="FilterUI.goToPage(1, '<?= $filterId ?>')" style="cursor:pointer;"></i>
            <i class="fas fa-chevron-left" onclick="FilterUI.goToPage(<?= $page - 1 ?>, '<?= $filterId ?>')" style="cursor:pointer;"></i>
        <?php else: ?>
            <i class="fas fa-chevron-left" style="opacity: 0.2; cursor: not-allowed;"></i>
        <?php endif; ?>

        <?php if ($page < $pagination['totalPages']): ?>
            <i class="fas fa-chevron-right" onclick="FilterUI.goToPage(<?= $page + 1 ?>, '<?= $filterId ?>')" style="cursor:pointer;"></i>
        <?php else: ?>
            <i class="fas fa-chevron-right" style="opacity: 0.2; cursor: not-allowed;"></i>
        <?php endif; ?>
    </div>
</div>


<!-- filter button to open filter itself -->
<?php if($filterId === 'actLog'): ?>
<?php else: ?>
    <div class="filter-row">
        <i class="fas fa-filter" onclick="FilterUI.open('<?= $filterId ?>')"></i>
    </div>
<?php endif; ?>

    
<!-- filter mod -->
<div id="<?= $filterId ?>FilterOverlay" class="inventory-filter-overlay"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:3500;">
    <div class="inventory-filter-panel">
        <div class="filter-icon-top" style="text-align: center; margin-bottom: 10px; color: #0b4a7a; font-size: 24px;">
            <i class="fas fa-filter"></i>
            <i class="fas fa-close" id="close-btn" onclick="FilterUI.close('<?= $filterId ?>')"></i>
        </div>

        <div class="inventory-filter-title">Filters</div>

        <div class="inventory-filter-group">
            <?php if ($role != 3): ?>
                <?php foreach ($filterOptions as $key => $values): ?>
                    <div class="select-wrapper">
                        <div class="custom-filter" data-filter="<?= $key ?>" onclick="toggleInventorySelect(this)">
                            <span class="select-label"><?= ucfirst($key) ?>:</span>
                            <span class="select-value" id="<?= $filterId ?>-<?= $key ?>">
                                <?= htmlspecialchars($selectedFilters[$key]) ?>
                            </span>
                            <i class="fas fa-chevron-down select-icon"></i>
                            <div class="filter-menu">
                                <?php foreach ($values as $val): ?>
                                    <div class="filter-item"
                                        onclick="FilterUI.set('<?= $filterId ?>','<?= $key ?>','<?= htmlspecialchars($val) ?>', event)">
                                        <?= htmlspecialchars($val) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="custom-filter">
                <span class="select-label">Date:</span>
                <span class="select-value"
                    id="<?= $filterId ?>-date"><?= htmlspecialchars($selectedFilters['date']) ?></span>
            </div>

            <div class="calendar-wrapper">
                <div class="cal-header">
                    <i class="fas fa-chevron-left" onclick="FilterUI.changeMonth(-1)"></i>
                    <span id="<?= $filterId ?>-month"></span>
                    <i class="fas fa-chevron-right" onclick="FilterUI.changeMonth(1)"></i>
                </div>
                <div class="cal-grid" id="<?= $filterId ?>-calendar"></div>
            </div>
        </div>

        <div class="inventory-filter-footer">
            <button class="inventory-clear-btn"
                onclick="FilterUI.clear('<?= $filterId ?>'), FilterUI.apply('<?= $filterId ?>')">Clear</button>
            <button class="inventory-apply-btn" onclick="FilterUI.apply('<?= $filterId ?>')">Apply</button>
        </div>
    </div>
</div>
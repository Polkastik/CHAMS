<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($q)) {
    require_once '../Config/queryHandler.php';
    $q = new QueryHandler();
}

if (!isset($filterId)) {
    $filterId = $_GET['filterId']; 
}

if ($filterId === 'inventory') {
    $selectedCat = $_GET['cat_id'] ?? null;
    $selectedItemName = $_GET['item_name'] ?? null;
    $viewDepleted = $_GET['view_depleted'] ?? null;

    if ($selectedItemName && $selectedCat) {
        $filter = $_GET['filter'] ?? null;
        $items = $q->getItemsInGroup($selectedItemName, $selectedCat, $filter);
        $viewMode = 'units';
    } elseif ($viewDepleted === 'true') {
        $items = $q->getDepletedItems();
        $viewMode = 'items';
        $currentCategoryName = "DEPLTETED";
    } elseif ($selectedCat) {
        $items = $q->getGroupedInventory($selectedCat);
        $viewMode = 'items';
    } else {
        $items = $q->getInventoryCategories();
        $viewMode = 'categories';
    }
}

if ($filterId === 'ticketing' && !isset($tickets)) {
    $filters = [
        'status' => $_GET['status'] ?? null,
        'priority' => $_GET['priority'] ?? null,
        'department' => $_GET['department'] ?? null,
        'name' => $_GET['name'] ?? null,
        'type' => $_GET['type'] ?? null,
        'date' => $_GET['date'] ?? null,
        'search' => $_GET['search'] ?? null,
    ];

    $tickets = $q->getTickets($_SESSION['role'], $_SESSION['user_id'], $filters);
}

if ($filterId === 'actLog' && !isset($logs)) {
    $logs = $q->getActivityLogs();
}

?>

<div id="tileList" class="<?= ($filterId === 'inventory') ? 'inventory-list view-' . $viewMode : 'ticketing-list' ?>">
    <?php
    if ($filterId === 'inventory'): ?>
        <?php if (empty($items)): ?>
            <div class="no-data" style="text-align:center; padding: 5vh;">No inventory data found.</div>
        <?php else: ?>
            <?php if ($viewMode === 'categories'): ?>
                <?php foreach ($items as $cat):
                    $bgColor = !empty($cat['category_color']) ? $cat['category_color'] : '#e3f2fd';
                    $iconColor = '#1976d2'; ?>

                    <div class="ticket-card category-card" onclick="window.location.href='inventory.php?cat_id=<?= $cat['IC_ID'] ?>'">
                        <?php if ($role === 1): ?>
                            <div class="category-actions">
                                <button class="btn-icon edit" title="Edit"
                                    onclick="event.stopPropagation(); openEditModal(<?= $cat['IC_ID'] ?>,
                                '<?= addslashes($cat['category_name']) ?>', '<?= addslashes($cat['IC_Desc']) ?>', '<?= $bgColor ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                        <div class="ticket-avatar" style="background: <?= $bgColor ?>; color: #333; border: 1px solid #ccc;">
                            <i class="<?= $q->getCategoryIcon($cat['category_name']) ?>"></i>
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-title"><?= htmlspecialchars($cat['category_name']) ?></div>
                            <div class="ticket-meta"><?= htmlspecialchars($cat['IC_Desc'] ?? 'No description available') ?></div>
                        </div>
                        <div class="badge assigned"> View Items <i class="fas fa-arrow-right" style="margin-left:5px;"></i>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="ticket-card category-card depleted-tile" style="border-left: 5px solid #ff4d4d; cursor: pointer;"
                    onclick="window.location.href='inventory.php?view_depleted=true'">
                    <div class="ticket-avatar" style="background: #ffebee; color: #ff4d4d; border: 1px solid #ffcdd2;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="ticket-info">
                        <div class="ticket-title" style="color: #b71c1c;">DEPLETED ASSETS</div>
                        <div class="ticket-meta">Items requiring immediate reorder</div>
                    </div>
                    <div class="badge high" style="margin:auto;">Action Required</div>
                </div>

            <?php elseif ($viewMode === 'items'): ?>
                <?php
                $groupedData = [];
                $isSpecialDepletedView = isset($_GET['view_depleted']) && $_GET['view_depleted'] === 'true';

                foreach ($items as $item) {
                    $name = $item['item_name'];
                    if (!isset($groupedData[$name])) {
                        $groupedData[$name] = [
                            'info' => $item,
                            'total' => 0
                        ];
                    }
                    $groupedData[$name]['total'] += (int) $item['TotalQuantity'];
                }

                $currentHeader = "";
                foreach ($groupedData as $name => $data):
                    $item = $data['info'];
                    $totalQty = $data['total'];

                    $targetHeader = $isSpecialDepletedView ? "DEPLETED" : $item['category_name'];

                    if ($currentHeader !== $targetHeader):
                        $currentHeader = $targetHeader; ?>
                        <div class="inventory-section-header" style="grid-column: span 2; width: 100%;">
                            <h3><?= htmlspecialchars($currentHeader) ?></h3>
                            <hr>
                        </div>
                    <?php endif; ?>

                    <?php
                    $threshold = (int) ($item['Threshold'] ?? 0);
                    $qtyClass = ($totalQty <= $threshold) ? 'high' : 'resolved';
                    ?>

                    <div class="ticket-card ticketing-card">
                        <a href="inventory.php?cat_id=<?= $item['categ_ID'] ?>&item_name=<?= urlencode($name) ?><?= ($isSpecialDepletedView ? '&filter=depleted' : '&filter=active') ?>"
                            style="text-decoration: none; display: flex; align-items: center; width: 100%; color: inherit;">
                            <div class="ticket-avatar">
                                <i class="fas <?= ($totalQty <= 0) ? 'fa-exclamation-circle' : 'fa-boxes' ?>"></i>
                            </div>
                            <div class="ticket-info">
                                <div class="ticket-title"><?= htmlspecialchars($name) ?></div>
                                <div class="ticket-meta">Grouped Asset</div>
                            </div>
                            <div class="badge <?= $qtyClass ?>" style="margin-left: auto; width: 125px;">Total Qty: <?= $totalQty ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            <?php elseif ($viewMode === 'units'): ?>
                <?php foreach ($items as $unit):
                    $qty = (int) ($unit['Quantity'] ?? 0);
                    $threshold = (int) ($unit['Threshold'] ?? 2);
                    $qtyClass = ($qty <= $threshold) ? 'high' : 'resolved';
                    ?>

                    <div class="ticket-card ticketing-card">

                        <a href="tileView.php?id=<?= $unit['I_ID'] ?>&mode=inventory"
                            style="text-decoration: none; display: flex; align-items: center; width: 100%; color: inherit;">
                            <div class="ticket-avatar">
                                <?php if (empty($unit['Serial_number'])): ?>
                                    <i class="<?= $q->getCategoryIcon($cat['category_name']) ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-barcode"></i>
                                <?php endif; ?>
                            </div>
                            <div class="ticket-info">
                                <?php if (empty($unit['Serial_number'])): ?>
                                    <div class="ticket-title"><?= htmlspecialchars($unit['item_name']) ?></div>
                                    <div class="ticket-meta">
                                        Input by: <?= htmlspecialchars($unit['created_by']) ?>
                                        <i style="margin-right: 20%;"></i>
                                        <?= date('d M Y', strtotime($unit['date_received'])) ?>
                                    </div>

                                <?php else: ?>
                                    <div class="ticket-title">SN: <?= htmlspecialchars($unit['Serial_number']) ?></div>
                                    <div class="ticket-meta">
                                        <?= date('d M Y', strtotime($unit['date_received'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="badge <?= $qtyClass ?>" style="margin: 0 2.5px 0 0;">Qty: <?= $qty ?></div>
                            <div class="badge <?= ($unit['Defects'] === 'Yes') ? 'high' : 'resolved' ?>" style="margin-left:auto;">
                                <?= ($unit['Defects'] === 'Yes') ? 'Defective' : 'Good Condition' ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif;
        endif;

    // activity log
    elseif ($filterId === 'actLog'):
        if (empty($logs)): ?>
            <div class="no-data" style="text-align:center; padding: 5vh;">No recent activities.</div>
        <?php else:
            foreach ($logs as $log):
                $userName = htmlspecialchars($log['FN'] . ' ' . $log['LN']);
                ?>
                <div class="ticket-card activity-card" style="cursor: auto;">
                    <div class="ticket-avatar"><i class="fas fa-history"></i></div>

                    <div class="ticket-info">
                        <div class="ticket-title" style="color: #0056b3; font-weight: bold;">
                            <?= $userName ?>
                        </div>
                        <div class="ticket-meta">
                            Performed: <strong><?= htmlspecialchars($log['act']) ?></strong>
                            in <i><?= htmlspecialchars($log['module']) ?></i>
                            (Ref ID: #<?= htmlspecialchars($log['ref_ID']) ?>)
                        </div>
                    </div>

                    <div class="time" style="margin-left: auto;">
                        <i class="fas fa-history"></i>
                        <?= date('M d, Y | h:i A', strtotime($log['created_at'])) ?>
                    </div>
                </div>
            <?php endforeach;
        endif;

    else:
        // ticketing 
        if (empty($tickets)): ?>
            <div class="no-data" style="text-align:center; padding: 5vh;">No tickets found.</div>
        <?php else:
            foreach ($tickets as $row):
                $ticketId = htmlspecialchars($row['T_ID']);
                $status = htmlspecialchars($row['Status'] ?? 'Unresolved');
                $assigned = !empty($row['staff_FN']) ? 'Assigned' : 'Unassigned';
                $isOverdue = (!empty($row['due_date']) && strtotime($row['due_date']) < time() && $status !== 'Resolved');
                ?>
                <div class="ticket-card ticketing-card" data-category="<?= htmlspecialchars($row['categ_name']) ?>"
                    data-status="<?= $status ?>">
                    <?php if ($isOverdue): ?>
                        <div class="overdue">OVERDUE</div><?php endif; ?>

                    <?php if ($role != 3): ?>
                        <input type="checkbox" class="ticket-checkbox" value="<?= $ticketId ?>" onchange="checkSelection()">
                    <?php else: ?>
                        <div class="ticket-checkbox"></div>
                    <?php endif; ?>

                    <a href="tileView.php?id=<?= $ticketId ?>"
                        style="text-decoration: none; display: flex; align-items: center; gap: 2%; flex: 1; color: inherit;">
                        <div class="ticket-avatar"><i class="fas fa-user"></i></div>
                        <div class="ticket-info">
                            <div class="ticket-title"><?= htmlspecialchars($row['FN'] . ' ' . $row['LN']) ?></div>
                            <div class="ticket-desc"><?= htmlspecialchars($row['Title']) ?></div>
                            <div class="ticket-meta"><?= htmlspecialchars($row['categ_name']) ?></div>
                        </div>

                        <div class="badge <?= ($assigned === 'Assigned') ? 'Assigned' : 'Unassigned' ?>"><?= $assigned ?></div>
                        <div class="badge <?= $status ?>"><?= $status ?></div>
                        <div class="badge <?= strtolower($row['Priority']) ?>"><?= htmlspecialchars($row['Priority']) ?></div>
                        <div class="time"><?= timeAgo($row['created_at']) ?></div>
                    </a>
                </div>
            <?php endforeach;
        endif;
    endif; ?>
</div>

<!-- Edit category modal -->
<div id="editCategoryModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <h3>Edit Category</h3>
        <form id="editCategoryForm" action="../Config/updateAction.php" method="POST">
            <input type="hidden" name="action" value="update_category">
            <input type="hidden" name="cat_id" id="edit_cat_id">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" id="edit_cat_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="category_desc" id="edit_cat_desc" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Category Color</label>
                <input type="color" name="category_color" id="edit_cat_color" class="form-control"
                    style="height: 45px;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn download">Save Changes</button>
            </div>
        </form>
    </div>
</div>
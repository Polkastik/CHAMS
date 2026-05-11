<?php
$qtyClass = 'good';
$defects = 'good';

if ($mode === 'inventory') {
    $qty = (int) ($data['Quantity'] ?? 0);
    $threshold = (int) ($data['Threshold'] ?? 0);

    if ($qty <= ($threshold - 5)) {
        $qtyClass = 'high';
    } elseif ($qty <= $threshold) {
        $qtyClass = 'medium';
    } else {
        $qtyClass = 'good';
    }

    $hasDefects = $data['Defects'] ?? 'No';
    if ($hasDefects === 'Yes') {
        $defects = 'high';
    } else {
        $defects = 'good';
    }
}

$from = $_GET['from'] ?? '';

if ($from === 'inventory') {
    $backPath = "window.location.href='inventoryTracker.php'";
} else {
    $backPath = "window.location.href='ticket.php'";
}
?>

<div class="content">
    <?php if ($mode === 'maintenance'): ?>
        <div class="page-header" onclick="history.back()">
            <i class="fas fa-chevron-left"></i> VIEWING MAINTENANCE #<?= htmlspecialchars($data['M_ID']) ?>
        </div>
        <div class="info-grid">
            <div>
                <div class="grid-row">
                    <span class="label">Asset Name:</span>
                    <span class="value"><?= htmlspecialchars($data['Asset_name']) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Created at:</span>
                    <span class="value"><?= date('M d, Y | h:i A', strtotime($data['created_at'])) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Department:</span>
                    <span class="value"><?= htmlspecialchars($data['Dept_ID']) ?></span>
                </div>
            </div>

            <div>
                <div class="grid-row">
                    <span class="label">Maintenance Type:</span>
                    <span class="value"><?= htmlspecialchars($data['M_type'] ?? 'N/A') ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Next Maintenance:</span>
                    <span class="value">
                        <?= !empty($data['next_m'])
                            ? date("M d, Y", strtotime($data['next_m']))
                            : 'Not Scheduled' ?>
                    </span>
                </div>
            </div>
        </div>

        <span class="message-label">Maintenance Description:</span>
        <div class="message-box" id="dispMessage">
            <?= nl2br(htmlspecialchars($data['desc'])) ?>
        </div>

        <div class="status-section">
            <div class="status-row">
                <span class="status-label">Priority:</span>
                <span
                    class="badge Priority <?= strtolower($data['Priority']) ?>"><?= htmlspecialchars($data['Priority'] ?? 'N/A') ?></span>
            </div>
            <div class="status-row">
                <span class="status-label">Status:</span>
                <span
                    class="badge Status <?= strtolower($data['Status']) ?>"><?= htmlspecialchars(strtoupper($displayStatus)) ?></span>
            </div>
        </div>

        <?php if ($data['Status'] !== 'Resolved'): ?>
            <form method="POST" action="../Config/updateAction.php" onsubmit="submitEditForm(this)">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="mode" value="maintenance">
                <div class="actions" style="margin-top: -7%;">

                    <?php if (empty($data['next_m']) || $data['next_m'] == ""): ?>
                        <div class="maintenance-resolve-box"
                            style="width: 25%; background: #e3f2fd; border-left: 5px solid #2196F3; padding: 20px;">
                            <p style="font-weight: bold;"><i class="fas fa-tools"></i> MAINTENANCE ACTION</p>
                            <label>Next Maintenance Interval:</label>
                            <select name="interval" class="value" style="width: 100%; margin: 10px 0;" onfocus="stopTileRefresh()">
                                <option value="+1 month" <?= ($data['M_type'] == 'Predictive') ? 'selected' : '' ?>>Monthly</option>
                                <option value="+3 months" <?= ($data['M_type'] == 'Preventive' || empty($data['M_type'])) ? 'selected' : '' ?>>Quarterly</option>
                                <option value="+6 months">Semi-Annual</option>
                                <option value="+1 year">Annual</option>
                            </select>

                            <button type="submit" name="action" value="resolve_maintenance" class="btn resolved">
                                RESOLVE & SCHEDULE <i class="fas fa-calendar-check"></i>
                            </button>
                        </div>
                        <a href="../Flow/tileView.php?id=<?= $data['M_ID'] ?>&mode=maintenance&edit=true" class="btn edit-btn">
                            EDIT <i class="fas fa-pen"></i>
                        </a>
                    <?php else: ?>
                        <a href="../Flow/tileView.php?id=<?= $data['M_ID'] ?>&mode=maintenance&edit=true" class="btn edit-btn">
                            EDIT <i class="fas fa-pen"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>

    <?php elseif ($mode === 'inventory'): ?>
        <div class="page-header" onclick="history.back()">
            <i class="fas fa-chevron-left"></i> VIEWING ITEM # <?= htmlspecialchars(strtoupper($data['I_ID'])) ?> :
            <?= htmlspecialchars(strtoupper($data['item_name'])) ?>
        </div>

        <div class="info-grid">
            <div>
                <div class="grid-row">
                    <span class="label">Item Name:</span>
                    <span class="value"><?= htmlspecialchars(strtoupper($data['item_name'])) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Item Type:</span>
                    <span class="value"><?= htmlspecialchars($data['item_type'] ?? 'Uncategorized') ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Item Brand:</span>
                    <span class="value"><?= htmlspecialchars($data['item_brand'] ?? 'Unlabled') ?></span>
                </div>
            </div>
            <div>
                <div class="grid-row">
                    <span class="label">Supplier:</span>
                    <span class="value"><?= htmlspecialchars($data['item_supplier']) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Date Delivered:</span>
                    <span class="value"><?= date("M d, Y", strtotime($data['date_received'])) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Added By:</span>
                    <span class="value"><?= htmlspecialchars($data['creator_FN'] . ' ' . $data['creator_LN']) ?></span>
                </div>
            </div>
        </div>

        <div class="status-section" id="pageHeadText">
            <div class="status-row">
                <span class="status-label">Serial No.:</span>
                <span
                    class="badge assigned"><?= (!empty($data['Serial_number'])) ? htmlspecialchars($data['Serial_number']) : 'N/A' ?></span>
            </div>
            <div class="status-row">
                <span class="status-label">Quantity:</span>
                <span
                    class="badge <?= ($data['Quantity'] <= 0) ? 'high' : $qtyClass ?>"><?= htmlspecialchars($data['Quantity'] ?? '0') ?></span>
            </div>
            <div class="status-row">
                <span class="status-label">Defects:</span>
                <span class="badge <?= $defects ?>">
                    <?= htmlspecialchars($data['Defects']) ?>
                </span>
            </div>
        </div>

        <div class="actions" id="pageHeadText">
            <?php if ($data['Quantity'] != 0 && $role === 1): ?>
                <a href="../Flow/tileView.php?id=<?= $id ?>&mode=<?= $mode ?>&edit=true" class="btn edit-btn">
                    EDIT <i class="fas fa-pen"></i>
                </a>
            <?php endif; ?>
            <a href="../Config/exportAction.php?id=<?= $id ?>&type=inventory" class="btn"
                style="background: #28a745; color: white;">
                EXPORT CSV <i class="fas fa-file-excel"></i>
            </a>
        </div>

    <?php else: ?>
        <!-- ticketing -->
        <?php if ($role === 3): ?>
            <div class="page-header" id="pageHeadText" style="padding: 1.3%;"
                onclick="window.location.href='../Flow/dashboard.php'">
                <i class="fas fa-chevron-left"></i> VIEWING <?= htmlspecialchars(strtoupper($data['ticket_num'])) ?>
            </div>
        <?php else: ?>
            <div class="page-header" id="pageHeadText" style="padding: 1.3%;" onclick="<?= $backPath ?>">
                <i class="fas fa-chevron-left"></i> VIEWING <?= htmlspecialchars(strtoupper($data['ticket_num'])) ?>
            </div>
        <?php endif ?>

        <div class="info-grid">
            <div>
                <div class="grid-row">
                    <span class="label">Applicant Name:</span>
                    <span class="value"><?= htmlspecialchars($data['creator_FN'] . ' ' . $data['creator_LN']) ?></span>
                </div>
                <div class="grid-row">
                    <span class="label">Category:</span>
                    <span class="value"><?= htmlspecialchars($data['categ_name']) ?></span>
                </div>
                <!-- <div class="grid-row">
                    <span class="label">Title:</span>
                    <span class="value"><?= htmlspecialchars($data['Title']) ?></span>
                </div> -->
                <?php if (!empty($data['issued_item_name'])): ?>
                    <div class="grid-row" style="color: #28a745; font-weight: bold;">
                        <span class="label">Issued Item:</span>
                        <span class="value"><?= htmlspecialchars($data['issued_item_name']) ?></span>
                    </div>
                <?php endif; ?>

            </div>

            <div>
                <div class="grid-row">
                    <span class="label">Department:</span>
                    <span class="value"><?= htmlspecialchars($data['dept_name'] ?? 'N/A') ?></span>
                </div>
                
                <?php if (!empty($data['issued_item_name'])): ?>
                    <div class="grid-row" style="color: #28a745; font-weight: bold;">
                        <span class="label">Quantity:</span>
                        <span class="value"><?= htmlspecialchars($data['issued_qty']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="pageHeadText" style="border-radius: 25px 25px 0 0;">
            <span class="message-label"><i class="fas fa-newspaper"></i> Description:</span>
            <div class="message-box" id="dispMessage">
                <?= nl2br(htmlspecialchars($data['T_description'])) ?>
            </div>
            <span class="message-label"><i class="fas fa-comments"></i> Technician Comments:</span>
            <div class="message-box" id="commentSection">
                <?php 
                $comments = $q->getTicketComments($id);
                if (empty($comments)): ?>
                    <p style="color: #999; font-style: italic;">No comments yet.</p>
                <?php else: foreach ($comments as $c): ?>
                        <?= nl2br(htmlspecialchars($c['comment_text'])) ?>
                <?php endforeach; endif; ?>
            </div>
        </div>
        <div class="status-section" id="pageHeadText" style="border-radius: 0 0 25px 25px;">
            <div class="status-row">
                <span class="status-label">Time Created | Resolved:</span>
                <span class="badge <?= strtolower($data['Status']) ?>">
                    <?= htmlspecialchars($data['created_at'] . " | " . $data['resolved_at']) ?>
                </span>
            </div>
            <div class="status-row">
                <span class="status-label">Due Date:</span>
                <?php if ($data['Status'] === 'Resolved'): ?>
                    <span class="badge assigned" style="background-color: #28ba1b;">
                        Resolved</span>
                <?php elseif (!empty($data['due_date'])): ?>
                    <span class="badge assigned"><i class="far fa-calendar-alt"></i>
                        <?= date("M d, Y h:i:A", strtotime($data['due_date'])) ?></span>
                <?php else: ?>
                    <span class="badge unassigned">Unassigned</span>
                <?php endif; ?>
            </div>
            <div class="status-row">
                <?php
                $displayStatus = ($data['Status'] === 'Unresolved') ? 'Pending' : $data['Status'];

                ?>
                <span class="status-label">Status:</span>
                <span class="badge <?= strtolower($data['Status']) ?>"><?= htmlspecialchars($displayStatus) ?></span>
            </div>
            <?php if ($role === 1): ?>
                <div class="status-row">
                    <span class="status-label">Priority:</span>
                    <span class="badge <?= strtolower($data['Priority']) ?>"><?= htmlspecialchars($data['Priority']) ?></span>
                </div>
            <?php endif; ?>
            <div class="status-row">
                <span class="status-label">Assigned to:</span>
                <?php if (!empty($data['staff_FN'])): ?>
                    <span class="badge assigned"><i class="fas fa-user-check"></i>
                        <?= htmlspecialchars($data['staff_FN'] . ' ' . $data['staff_LN']) ?></span>
                <?php else: ?>
                    <span class="badge unassigned">Unassigned</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($mode === 'ticketing'): ?>
        <div class="form-footer">
            <div class="attachment">
                <button type="button" class="attach-btn" onclick="viewAttachment()">
                    <i class="fas fa-eye"></i> See Attachment
                </button>
            </div>
        </div>

        <div class="actions" style="margin-right: 3%;">
            <?php if ($role === 1 && $data['Status'] === 'Resolved' && $mode === 'ticketing' && empty($data['issued_item_name'])): ?>
                <form method="POST" action="../Config/updateAction.php" onsubmit="submitEditForm(this)">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="mode" value="ticketing">
                    <div class="admin-inventory-control"
                        style="background: #fff3cd; padding: 20px; border-left: 5px solid #ffc107; margin-top: -10%;">
                        <p style="font-size: 0.8rem; font-weight: bold; margin-bottom: 5px;">
                            <i class="fas fa-shield-alt"></i> ADMIN: ISSUE ASSETS
                        </p>
                        <select name="issued_item_id" class="value" style="width: 100%; margin-bottom: 5px;"
                            onfocus="stopRefresh()">
                            <option value="">-- No Item Issued --</option>
                            <?php
                            $inventory = $q->getAllInventory(true);
                            if (!empty($inventory)): ?>
                                <?php foreach ($inventory as $item): ?>
                                    <?php
                                    $isDepleted = ($item['category_name'] === 'Depleted');
                                    ?>
                                    <option value="<?= $item['I_ID'] ?>" <?= $isDepleted ? 'disabled' : '' ?>>
                                        <?= $isDepleted ? '[DEPLETED] ' : '' ?>
                                        <?= htmlspecialchars($item['item_name']) ?>
                                        (Stock: <?= htmlspecialchars($item['Quantity']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No items found in database</option>
                            <?php endif; ?>
                        </select>
                        <div style="display: flex; gap: 5%;">
                            <input type="number" name="issued_qty" placeholder="Qty" min="0" value="1" style="width: 60px;"
                                onfocus="stopRefresh()">
                            <button name="action" value="save" class="btn resolved">
                                SAVE <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form action="../Config/updateAction.php" method="POST" style="margin-left: -95vh;">
                    <input type="hidden" name="id" value="<?= $id ?>"> <input type="hidden" name="ticket_id" value="<?= $id ?>">
                    <input type="hidden" name="mode" value="ticketing"> <input type="hidden" name="action"
                        value="reopen_ticket">
                    <button type="submit" class="btn edit-btn"><i class="fas fa-history"></i>Reopen Ticket</button>
                </form>
            <?php elseif ($data['Status'] != 'Resolved' && $role === 1): ?>
                <a href="../Flow/tileView.php?id=<?= $id ?>&mode=<?= $mode ?>&edit=true" class="btn edit-btn">
                    EDIT <i class="fas fa-pen"></i>
                </a>
            <?php elseif ($data['Status'] === 'Resolved' && $role === 1): ?>
                <form action="../Config/updateAction.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>"> <input type="hidden" name="ticket_id" value="<?= $id ?>">
                    <input type="hidden" name="mode" value="ticketing"> <input type="hidden" name="action"
                        value="reopen_ticket">
                    <button type="submit" class="btn edit-btn"><i class="fas fa-history"></i>Reopen Ticket</button>
                </form>
            <?php endif; ?>

            <?php if ($role === 3): ?>
                <?php if (empty($data['staff_FN']) && $data['Status'] === 'Unresolved'): ?>
                    <a href="../Flow/tileView.php?id=<?= $id ?>&mode=<?= $mode ?>&edit=true" class="btn edit-btn">
                        EDIT <i class="fas fa-pen"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($role === 2 && $mode === 'ticketing'): ?>
                <?php if (empty($data['staff_FN'])): ?>
                    <form method="POST" action="../Config/updateAction.php" onsubmit="submitEditForm(this)">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="mode" value="ticketing">
                        <button type="submit" name="action" value="accept" class="btn download">ACCEPT <i
                                class="fas fa-check"></i></button>
                    </form>
                <?php elseif ($data['Status'] !== 'Resolved' && $data['Assigned_To'] == $uid): ?>
                    <form method="POST" action="../Config/updateAction.php" onsubmit="submitEditForm(this)">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="mode" value="ticketing">
                        <button name="action" value="resolve" class="btn resolved">RESOLVE <i class="fas fa-check"></i></button>
                    </form>
                <?php elseif ($data['Assigned_To'] != $uid && !empty($data['staff_FN'])): ?>
                    <span class="badge assigned" style="padding-top: 0.9%; cursor: default;">Assigned to
                        <?= htmlspecialchars($data['staff_FN']) ?> </span>
                <?php elseif ($data['Status'] == 'Resolved' && empty($comments)): ?>
                    <button type="button" class="btn edit-btn" onclick="openCommentModal()">
                        COMMENT <i class="fas fa-comment-dots"></i>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="content">
    <div class="section-label" id="dashTitle">Operational Overview</div>
    <div class="ticket-summary">
        <div class="summary-card" onclick="window.location.href='../Flow/ticket.php?overdue=1&status=Unresolved'">
            <h4>OVERDUE</h4>
            <div class="count" id="stat-overdue" style="color: #ff2d8d;"><?= $stats['overdue'] ?></div>
        </div>

        <div class="summary-card" onclick="window.location.href='../Flow/ticket.php?unassigned=1&status=Unresolved'">
            <h4>UNASSIGNED</h4>
            <div class="count" id="stat-open"><?= $stats['open'] ?></div>
        </div>

        <div class="summary-card" onclick="window.location.href='../Flow/ticket.php?status=Unresolved'">
            <h4>PENDING</h4>
            <div class="count" id="stat-unresolved"><?= $stats['status'] ?></div>
        </div>

        <div class="summary-card" onclick="window.location.href='../Flow/ticket.php?priority=High&status=Unresolved'">
            <h4>URGENT</h4>
            <div class="count" id="stat-urgent" style="color:#bbb;"><?= $stats['urgent'] ?></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="grid-box activity-box" style="width: 80%">
            <div class="section-label">Available Tickets</div>
            <div id="ticket-loader" class="loader-overlay">
                <div class="spinner"></div>
                <span>Loading Data...</span>
            </div>
            <div id="available-tickets-container">
                <?php if (empty($tickets)): ?>
                    <div class="no-data" style="text-align:center; padding: 5vh;">No tickets found.</div>
                <?php else:
                    $limitedTickets = array_slice($tickets ?? [], 0, 4);
                    foreach ($limitedTickets as $row):
                        $ticketId = htmlspecialchars($row['T_ID']);
                        $status = htmlspecialchars($row['Status'] ?? 'Unresolved');
                        $assigned = !empty($row['staff_FN']) ? 'Assigned' : 'Unassigned';
                        $isUnassigned = empty($row['staff_FN']);
                        if ($isUnassigned && $status !== 'Resolved'):
                            $isOverdue = (!empty($row['due_date']) && strtotime($row['due_date']) < time() && $status !== 'Resolved');
                            ?>
                            <div class="activity-item" data-category="<?= htmlspecialchars($row['categ_name']) ?>"
                                data-status="<?= $status ?>" style="max-height:75px ;">
                                
                                <a href="tileView.php?id=<?= $ticketId ?>"
                                    style="text-decoration: none; display: flex; align-items: center; gap: 2%; flex: 1; color: inherit; margin-top: -1%;">
                                    <?php if ($isOverdue): ?>
                                        <div class="overdue-badge">OVERDUE</div>
                                    <?php endif; ?>
                                    <div class="initial-circle"><i class="fas fa-user"></i></div>
                                    <div class="activity-list">
                                        <div class="ticket-title" id="staff-title">
                                            <?= htmlspecialchars($row['FN'] . ' ' . $row['LN']) ?> -
                                            <?= htmlspecialchars($row['Title']) ?>
                                        </div>
                                        <div class="ticket-desc"></div>
                                        <div class="ticket-meta">
                                            <?= htmlspecialchars($row['categ_name']) ?>
                                        </div>
                                    </div>
                                    <div class="time" style="margin-left: auto;">
                                        <?= timeAgo($row['created_at']) ?>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        <div class="grid-box stock-box" onclick="window.location.href='../Flow/inventory.php'" style="cursor: pointer;">
            <div class="section-label" style="text-align:left;">Inventory Levels</div>

            <div id="graph-loader1" class="loader-overlay">
                <div class="spinner"></div>
                <span>Loading Data...</span>
            </div>
            <canvas id="pieChart" data-chart='<?php echo json_encode($inventoryPieData); ?>'></canvas>
        </div>
    </div>
</div>
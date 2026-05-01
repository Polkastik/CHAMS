<div class="content">
    <div class="section-label">Operational Overview</div>
    <div class="ticket-summary">
        <div class="summary-card" onclick="window.location.href='../flow/ticket.php'">
            <h4>OVERDUE</h4>
            <div class="count" id="stat-overdue" style="color: #ff2d8d;"><?= $stats['overdue'] ?></div>
        </div>
        <div class="summary-card" onclick="window.location.href='../flow/ticket.php'">
            <h4>OPEN</h4>
            <div class="count" id="stat-open"><?= $stats['open'] ?></div>
        </div>
        <div class="summary-card" onclick="window.location.href='../flow/ticket.php'">
            <h4>UNRESOLVED</h4>
            <div class="count" id="stat-unresolved"><?= $stats['status'] ?></div>
        </div>
        <div class="summary-card" onclick="window.location.href='../flow/ticket.php'">
            <h4>URGENT</h4>
            <div class="count" id="stat-urgent" style="color:#bbb;"><?= $stats['urgent'] ?></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="grid-box activity-box" style="width: 70%">
            <div class="section-label">Available Ticketsss</div>
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
                                <?php if ($isOverdue): ?>
                                    <div class="overdue">OVERDUE</div><?php endif; ?>


                                <a href="tileView.php?id=<?= $ticketId ?>"
                                    style="text-decoration: none; display: flex; align-items: center; gap: 2%; flex: 1; color: inherit; margin-top: -1%;">
                                    <div class="initial-circle"><i class="fas fa-user"></i></div>
                                    <div class="activity-list">
                                        <div class="ticket-title">
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
        <div class="grid-box stock-box" style="width: 30%">
            <a href="../Flow/inventory.php">
                <div class="section-label" style="text-align:left;">Inventory Levels</div>

                <?php
                include '../Modules/pieGraph.php';
                ?>
                <div id="graph-loader1" class="loader-overlay">
                    <div class="spinner"></div>
                    <span>Loading Data...</span>
                </div>
                <canvas id="pieChart" data-chart='<?= json_encode($inventoryPieData) ?>'></canvas>

                <div class="stock-legend">
                    <?php foreach ($inventoryPieData as $name => $data): ?>
                        <?php if ($data['value'] > 0): ?>
                            <div class="legend-item">
                                <span class="legend-dot" style="background-color: <?= $data['color'] ?>;"></span>
                                <span class="legend-label"><?= htmlspecialchars($name) ?></span>
                                <span class="legend-percent"><?= round($data['value']) ?>%</span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </a>
        </div>
    </div>
</div>
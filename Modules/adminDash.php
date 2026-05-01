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
        <div class="grid-box stock-box" onclick="window.location.href='../Flow/inventory.php'" style="cursor: pointer;">
            <div class="section-label" style="text-align:left;">Inventory Levels</div>

            <div id="graph-loader1" class="loader-overlay">
                <div class="spinner"></div>
                <span>Loading Data...</span>
            </div>
            <canvas id="pieChart" data-chart='<?php echo json_encode($inventoryPieData); ?>'></canvas>

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
        </div>

        <!-- ticket bar graph -->
        <div class="grid-box perf-box" onclick="window.location.href='../Flow/profile.php'" style="cursor: pointer;">
            <div class="section-label">Ticket Resolution Performance</div>
            <div class="chart-val">
                <div id="graph-loader2" class="loader-overlay">
                    <div class="spinner"></div>
                    <span>Loading Data...</span>
                </div>
                <canvas id="performanceChart" data-values='<?= json_encode($chartData) ?>'></canvas>
            </div>
        </div>

        <!-- recent acts -->
        <div class="grid-box activity-box">
            <div class="section-label">Recent Activity</div>
            <div class="activity-list" onclick="window.location.href='../Flow/activityLog.php'" style="cursor: pointer;"
                id="activityContainer">
                <?php
                // limited to the most recent 5 un lng kasya hahaha
                $recentLogs = array_slice($logs, 0, 5);

                if (empty($recentLogs)): ?>
                    <div class="activity-item">No recent activity found.</div>
                <?php else: ?>
                    <?php foreach ($recentLogs as $log):
                        // Get initials based sa db
                        $initials = strtoupper(substr($log['FN'], 0, 1) . substr($log['LN'], 0, 1));
                        ?>
                        <div class="activity-item">
                            <div class="initial-circle">
                                <?= $initials ?>
                            </div>
                            <div class="activity-list">
                                <b>
                                    <?= htmlspecialchars($log['FN'] . ' ' . $log['LN']) ?>
                                </b>
                                <br>
                                <?= htmlspecialchars($log['act']) ?>
                                <br>
                                <small style="color: #888;">
                                    <?= date('M d, h:i A', strtotime($log['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../config/queryHandler.php';

$q = new QueryHandler();
$data = $q->getInventorySummary();

// ALWAYS initialize
$total = 0;
foreach ($data as $row) {
    $total += $row['total'];
}

$total = ($total == 0) ? 1 : $total;

$inventoryPieData = [];
foreach ($data as $row) {
    $name = $row['category_name'];
    $percent = ($row['total'] / $total) * 100;
    
    $inventoryPieData[$name] = [
        'value' => $percent,
        'color' => $row['category_color'] ?? '#cccccc'
    ];
}
<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();
$items = $q->getAllInventory();

$filterId = "inventory";
$mode = "inventory";

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();

$selectedCat = $_GET['cat_id'] ?? null;

if ($selectedCat) {
    $displayData = $q->getGroupedInventory($selectedCat);
    $viewMode = 'items';
    $currentCatName = $q->getCategoryNameById($selectedCat);
} else {
    // If no category is clicked, get all categories
    $displayData = $q->getInventoryCategories();
    $viewMode = 'categories';
}

if (isset($_GET['ajax']) && $_GET['ajax'] === 'list') {
    ob_start();

    include '../Modules/tileBox.php';

    echo ob_get_clean();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - INVENTORY</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/inventory.css">
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/filter.css">
</head>

<body id="altBody">
    <!-- Header -->
    <?php include '../Modules/header.php' ?>

    <!-- sidebar -->
    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content">
            <div id="pageHeadText">
                <div class="page-header">
                    <?php if ($viewMode === 'items'): ?>
                        <div onclick="history.back()">
                            <i class="fas fa-chevron-left"></i>
                            INVENTORY: <?= htmlspecialchars(strtoupper($currentCatName)) ?>
                        </div>
                        <?php if ($role === 1): ?>
                            <div class="plus-icon">
                                <div class="plus-icon-item" onclick="window.location.href='createItem.php'">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div onclick="history.back()">
                            <i class="fas fa-chevron-left"></i>
                            INVENTORY CATEGORIES
                        </div>
                        <?php if ($role === 1): ?>
                            <div class="plus-icon">
                                <div class="plus-icon-item" onclick="document.getElementById('catModal').style.display='flex'"
                                    title="Add Category">
                                    <i class="fas fa-folder-plus"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- no time left decided to just put it here -->
                <div id="catModal" class="modal-overlay">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="fas fa-folder-plus"></i>
                            <h3>Create New Category</h3>
                        </div>
                        <form action="../Config/updateAction.php" method="POST">
                            <input type="hidden" name="action" value="create_category">
                            <div class="form-group">
                                <label>Category Name *</label>
                                <input type="text" name="cat_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="cat_desc" class="form-control"></textarea>
                            </div>
                            <div style="display:flex; justify-content:flex-end; gap:10px;">
                                <button type="button" class="btn cancel"
                                    onclick="document.getElementById('catModal').style.display='none'">Cancel</button>
                                <button type="submit" class="btn download">
                                    <i class="fas fa-plus"></i>
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php include '../Modules/tileBox.php'; ?>
            </div>
        </div>
    </div> 
    
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/inventory.js"></script>
    <script src="../Assets/JS/filter.js"></script>
</body>

</html>
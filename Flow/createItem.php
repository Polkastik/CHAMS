<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $received = !empty($_POST['date_received'])
        ? date('Y-m-d H:i:s', strtotime($_POST['date_received']))
        : null;

    $data = [
        'name' => trim($_POST['title']),
        'categ_id' => $_POST['categ_id'] ?? null,
        'type_id' => $_POST['type_id'] ?? null,
        'brand' => !empty(trim($_POST['brand'])) ? trim($_POST['brand']) : null,
        'quantity' => intval($_POST['quantity']),
        'threshold' => intval($_POST['threshold']),
        'supplier'  => !empty(trim($_POST['supplier'])) ? trim($_POST['supplier']) : null,
        'defects' => $_POST['defects'] ?? 'No',
        'serial'    => !empty(trim($_POST['serial'])) ? strtoupper(trim($_POST['serial'])) : null,
        'received' => $received
    ];

    if (empty($data['name']) || empty($data['categ_id']) || empty($data['type_id'])) {
        die("Missing required fields.");
    }

    if ($data['quantity'] < 0) {
        die("Quantity cannot be negative.");
    }

    if ($q->createInventoryItem($data)) {
        header("Location: inventory.php?msg=success");
        exit;
    } else {
        echo "Error creating item.";
    }
}

$categories = $q->getInventoryCategories();
$types = $q->getInventoryTypes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - CREATE ITEM</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/createTicket.css">
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
</head>

<body>
    <!-- Header -->
    <?php include '../Modules/header.php' ?>

    <!-- sidebar -->
    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content">
            <div class="page-header" onclick="window.location.href='inventory.php'">
                <i class="fas fa-chevron-left"></i> CREATING ITEM
            </div>
            <div class="form-container" style="padding: 3% 3% 10% 3%;">
                <form id="ticketForm" method="POST">
                    <div class="form-group">
                        <label for="title">Item Name</label>
                        <input type="text" id="title" name="title" placeholder="e.g., LaserJet Pro M404" required>
                    </div>

                    <div class="inline">
                        <div class="form-group inline-item">
                            <label for="categ_id">Inventory Category</label>
                            <select name="categ_id" id="categ_id" required>
                                <option value="" disabled selected>Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['IC_ID'] ?>"><?= htmlspecialchars($cat['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group inline-item">
                            <label for="type_id">Item Type</label>
                            <select name="type_id" id="type_id" required>
                                <option value="" disabled selected>Select Type</option>
                                <?php foreach ($types as $t): ?>
                                    <option value="<?= $t['IT_ID'] ?>"><?= htmlspecialchars($t['type']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brand">Item Brand</label>
                        <input type="text" name="brand" id="brand" placeholder="e.g., HP, Dell, Logitech" required>
                    </div>

                    <div class="inline">
                        <div class="form-group inline-item">
                            <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" id="quantity" min="1" value="1" required>
                        </div>
                        <div class="form-group inline-item">
                            <label for="threshold">Low Stock Threshold</label>
                            <input type="number" name="threshold" id="threshold" min="0" value="2" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <input type="text" name="supplier" id="supplier" placeholder="Vendor name" required>
                    </div>

                    <div class="status-section">
                        <div class="status-row">
                            <span class="status-label">Date Received:</span>
                            <input type="datetime-local" name="date_received" class="badge assigned"
                                value="<?= date('Y-m-d\TH:i') ?>">
                        </div>

                        <div class="status-row">
                            <span class="status-label">Defects:</span>
                            <select name="defects" id="defectsSelect" class="badge" required>
                                <option value="No" <?= (isset($_POST['defects']) && $_POST['defects'] == 'No') ? 'selected' : '' ?>>No</option>
                                <option value="Yes" <?= (isset($_POST['defects']) && $_POST['defects'] == 'Yes') ? 'selected' : '' ?>>Yes</option>
                            </select>
                        </div>

                        <div class="status-row">
                            <span class="status-label">Serial Number:</span>
                            <input type="text" name="serial" class="badge unassigned" placeholder="Enter SN...">
                        </div>
                    </div>

                    <div class="form-footer" style="margin-top: 1%;">
                        <button type="button" class="btn-cancel"
                            onclick="window.location.href='inventory.php'">Cancel</button>
                        <button type="submit" class="btn-submit">Create Item</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="../Assets/JS/sidebar.js"></script>
        <script src="../Assets/JS/createItem.js"></script>
</body>

</html>
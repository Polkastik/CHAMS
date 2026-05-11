<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = trim($_POST['description'] ?? "");
    $categ = $_POST['type'] ?? "";
    $attachmentName = null;

    if (empty($desc) || empty($categ)) {
        $message = "All required fields must be filled out.";
    } else {
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $fileName = $_FILES['attachment']['name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileTmp = $_FILES['attachment']['tmp_name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $fileSize < 5000000) {
                $attachmentName = "CHAMS_" . uniqid() . "." . $ext;
                $uploadPath = "../Assets/Gen_Files/" . $attachmentName;
                if (!move_uploaded_file($fileTmp, $uploadPath)) {
                    $attachmentName = null;
                }
            }
        }

        $ticketNum = $q->createTicket($desc, $uid, $dept, $categ, $attachmentName);

        if ($ticketNum) {
            header("Location: dashboard.php?success=1");
            exit;
        } else {
            $message = "Database error: Failed to create ticket.";
        }
    }
}
$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - CREATE TICKET</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/createTicket.css">
</head>

<body>
    <div class="ball"></div>
    <!-- Header -->
    <?php include '../Modules/header.php' ?>

    <!-- sidebar -->
    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <div class="content">
            <div class="page-header" onclick="window.location.href='dashboard.php'">
                <i class="fas fa-chevron-left"></i> CREATING TICKET
            </div>
            <div class="form-container">
                <form id="ticketForm" method="POST" enctype="multipart/form-data">
                    <!-- <div class="form-group">
                        <label for="title">Subject / Title</label>
                        <input type="text" id="title" name="title" placeholder="e.g., Printer not working" required>
                    </div> -->

                    <div class="form-group">
                        <label for="type">Category</label>
                        <select name="type" id="type" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php
                            $categories = $q->getTicketCategories();
                            foreach ($categories as $cat): ?>
                                <option value="<?= $cat['TC_ID'] ?>">
                                    <?= htmlspecialchars($cat['categ_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Detailed Description</label>
                        <textarea id="description" name="description" rows="6"
                            placeholder="Describe the issue in detail..." required></textarea>
                    </div>

                    <div class="form-group attachment">
                        <label for="attachment">Image Attachment: (MAXIMUM OF 5MB) </label>
                        <input type="file" name="attachment" id="attachment" accept="image/*">
                    </div>

                    <div class="form-footers">
                        <button type="button" class="btn-cancel"
                            onclick="window.location.href='dashboard.php'">Cancel</button>
                        <button type="submit" class="btn-submit">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="../Assets/JS/sidebar.js"></script>
        <script src="../Assets/JS/createTicket.js"></script>
        <script src="../Assets/JS/background.js"></script>
</body>

</html>
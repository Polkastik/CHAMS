<?php
session_start();

require_once '../Config/queryHandler.php';
$q = new QueryHandler();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$role = $_SESSION['role'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$fullname = $fname . " " . $lname;

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - FAQS</title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/faq.css">
</head>

<body>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php'; ?>
    
        <div class="content">
            <div class="page-header" onclick="window.location.href='setting.php'">
                <i class="fa-solid fa-chevron-left"></i> FAQs
            </div>

            <div class="faq-container">
                <div class="faq-title">HOW CAN WE HELP?</div>

                <div class="search-faq">
                    <input type="text" placeholder="Search for a question or keyword...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="faq-list">
                    <div class="faq-item">How do I submit a new support ticket? <i
                            class="fa-solid fa-chevron-right"></i></div>
                    <div class="faq-answer">
                        To submit a new support ticket, go to the <b>Tickets</b> section in the sidebar and click
                        <b>Create New Ticket</b>. Fill in the required details such as the issue description, category,
                        and priority level, then click Submit.
                    </div>

                    <div class="faq-item">Where can I view the current status of my open tickets? <i
                            class="fa-solid fa-chevron-right"></i></div>
                    <div class="faq-answer">
                        You can check the status of your requests in the <b>Tickets</b> section. Each ticket will show
                        its current status such as Pending, In Progress, or Resolved.
                    </div>

                    <div class="faq-item">How do I update an item in the Inventory section? <i
                            class="fa-solid fa-chevron-right"></i></div>
                    <div class="faq-answer">
                        Navigate to <b>Inventory</b> in the sidebar. To update an existing item, select the item and
                        click <b>Edit</b> to adjust quantity or details.
                    </div>

                    <div class="faq-item">Where do I change my staff profile details? <i
                            class="fa-solid fa-chevron-right"></i></div>
                    <div class="faq-answer">
                        Go to the <b>Settings</b> section from the sidebar. From there, you can update your personal
                        information and profile details.
                    </div>

                    <div class="faq-item">Who do I contact for System Errors? <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="faq-answer">
                        If you encounter a system error, create a <b>support ticket</b> in the Tickets section and
                        provide details about the error so the technical team can investigate.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/faq.js"></script>
</body>

</html>
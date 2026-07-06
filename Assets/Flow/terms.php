<?php
session_start();

require_once '../Config/queryHandler.php';
$q = new QueryHandler();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
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
    <title>CHAMS - Terms & Conditions</title>
    <?php include '../Config/univHead.php'; ?>
    <style>
        .terms-wrapper {
            max-width: 820px;
            margin: 0 auto;
        }

        .terms-header-card {
            background: #0b4a7a;
            border-radius: 1vw 1vw 0 0;
            padding: 4vh 6%;
            display: flex;
            align-items: center;
            gap: 1.2vw;
        }

        .terms-header-card i {
            font-size: 2.5vw;
            color: rgba(255,255,255,0.85);
        }

        .terms-header-card h1 {
            color: #fff;
            font-size: 1.6vw;
            font-weight: 800;
            margin: 0;
        }

        .terms-header-card p {
            color: rgba(255,255,255,0.65);
            font-size: 0.85vw;
            margin: 0.3vh 0 0;
        }

        .terms-body-card {
            background: #ffffff;
            border-radius: 0 0 1vw 1vw;
            padding: 4vh 6%;
            box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.07);
        }

        .terms-section {
            margin-bottom: 3vh;
            padding-bottom: 3vh;
            border-bottom: 1px solid #eef2f7;
        }

        .terms-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .terms-section-title {
            display: flex;
            align-items: center;
            gap: 0.7vw;
            font-size: 1vw;
            font-weight: 800;
            color: #0b4a7a;
            margin-bottom: 1.2vh;
        }

        .terms-section-title i {
            font-size: 1.1vw;
            color: #0b4a7a;
            opacity: 0.7;
        }

        .terms-section p {
            font-size: 0.92vw;
            color: #555;
            line-height: 1.8;
            margin: 0;
        }

        .terms-footer {
            margin-top: 3vh;
            padding: 2vh 3%;
            background: #f0f6ff;
            border-left: 4px solid #0b4a7a;
            border-radius: 0 0.5vw 0.5vw 0;
            font-size: 0.88vw;
            color: #0b4a7a;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="ball"></div>
    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php'; ?>

        <div class="content">
            <div class="page-header" id="pageHeadText" style="width: 30%; padding: 1.5%;"
                onclick="window.location.href='setting.php'">
                <i class="fa-solid fa-chevron-left"></i> Terms & Conditions
            </div>

                <div class="terms-wrapper">

                    <div class="terms-header-card">
                        <i class="fa-solid fa-file-contract"></i>
                        <div>
                            <h1>Terms & Conditions</h1>
                            <p>CHAMS-MISD &mdash; National Kidney and Transplant Institute</p>
                        </div>
                    </div>

                    <div class="terms-body-card">

                        <div class="terms-section">
                            <div class="terms-section-title">
                                <i class="fa-solid fa-circle-info"></i>
                                System Purpose & Scope
                            </div>
                            <p>CHAMS-MISD is intended solely for authorized personnel of the National Kidney and
                                Transplant Institute (NKTI). It is designed to support IT service request management,
                                asset monitoring, maintenance tracking, and related Management Information Systems
                                Division (MISD) operations. By accessing and using this system, you agree to comply
                                with the following terms and conditions.</p>
                        </div>

                        <div class="terms-section">
                            <div class="terms-section-title">
                                <i class="fa-solid fa-user-shield"></i>
                                Account Responsibility
                            </div>
                            <p>Users are responsible for maintaining the confidentiality of their login credentials
                                and must ensure that account access is not shared with unauthorized individuals. Any
                                activity performed using a registered account shall be considered the responsibility
                                of the account holder. Users must provide accurate, complete, and truthful information
                                when submitting service requests, maintenance records, or inventory-related data to
                                ensure proper monitoring and efficient service delivery.</p>
                        </div>

                        <div class="terms-section">
                            <div class="terms-section-title">
                                <i class="fa-solid fa-ban"></i>
                                Prohibited Activities
                            </div>
                            <p>The system shall only be used for legitimate institutional purposes related to IT
                                service management and asset monitoring. Unauthorized activities including misuse of
                                the system, falsification of records, unauthorized modification of data, attempts to
                                gain unauthorized access, or activities that disrupt system operations are strictly
                                prohibited and may result in account suspension, disciplinary action, or institutional
                                sanctions in accordance with NKTI policies.</p>
                        </div>

                        <div class="terms-section">
                            <div class="terms-section-title">
                                <i class="fa-solid fa-server"></i>
                                Data & System Availability
                            </div>
                            <p>CHAMS-MISD stores and processes institutional operational data to improve IT support
                                efficiency and asset management. While reasonable efforts are made to maintain system
                                availability, accuracy, and security, temporary interruptions due to maintenance,
                                upgrades, technical failures, or unforeseen circumstances may occur. MISD reserves
                                the right to modify, update, restrict, or discontinue certain system features when
                                necessary to improve operations and maintain security.</p>
                        </div>

                        <div class="terms-footer">
                            <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>
                            By continuing to use CHAMS-MISD, you acknowledge that you have read, understood, and
                            agreed to these Terms and Conditions and agree to use the system responsibly and in
                            accordance with institutional policies.
                        </div>

                    </div>
                </div>
            </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/faq.js"></script>
    <script src="../Assets/JS/background.js"></script>
</body>

</html>
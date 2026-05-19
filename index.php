<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - LOGIN</title>
    <?php include 'Config/univHead.php'; ?>
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/Login.css">
</head>

<body>

    <div class="left-panel">
        <div class="left-content">
            <div class="welcome-small">Welcome Back to</div>
            <div class="brand-large">CHAMS - MISD</div>
            <div class="tagline">
                Efficient IT Services. Accurate Asset Control. <strong>ONE</strong> Platform.
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="logo-area">
            <img src="../Assets/Images/ICONS/CHAMS.png" alt="CHAMS Logo" class="logo-img">
        </div>

        <div id="loginView" class="login-form">
            <div class="form-title" style="text-align: center;">Portal Access</div>
            <!-- Error Message based on the actual error -->
            <?php if (isset($_GET['error'])): ?>
                <div class="error-msg">
                    <?php
                    if ($_GET['error'] == 'invalid')
                        echo "Invalid Employee ID or Password";
                    if ($_GET['error'] == 'inactive')
                        echo "Account is inactive";
                    if ($_GET['error'] == 'notfound')
                        echo "User not found";
                    ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" class="login-form" method="POST" action="Config/loginProcess.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="empId" id="empId" class="form-input" placeholder="Employee ID" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Password"
                        required>
                </div>
                <button type="submit" class="btn-action" id="loginBtn">Login</button>
                <a class="toggle-link" onclick="toggleViews('forgot')">Forgot Password?</a>
            </form>
        </div>

        <div id="forgotView" class="login-form">
            <div class="form-title" style="text-align: center;">Reset Password</div>
            <p style="font-size: 0.8rem; color: #777; text-align: center; margin-bottom: 10px;">Enter your ID to request
                a reset link.</p>

            <form id="forgotForm" class="login-form">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="resetEmpId" class="form-input" placeholder="Employee ID" required>
                </div>
                <button type="submit" class="btn-action" id="forgotBtn" onclick="sendTestReset()">Submit Request</button>
                <a class="toggle-link" onclick="toggleViews('login')">Back to Login</a>
            </form>
        </div>
    </div>

    <script src="../Assets/JS/Login.js"></script>
</body>

</html>
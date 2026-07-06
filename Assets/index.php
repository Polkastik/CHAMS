<!DOCTYPE html>
<html lang="en">

<head>
    <title>CHAMS - LOGIN</title>
    <?php include 'Config/univHead.php'; ?>
    <link rel="stylesheet" type="text/css" href="../Assets/CSS/Login.css">
    <style>
        /* Modal Base Structures */
        .legal-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        .legal-modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 550px;
            max-height: 70vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: relative;
            animation: modalSlide 0.3s ease-out;
        }
        @keyframes modalSlide {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .legal-modal-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 15px;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 10px;
        }
        .legal-modal-body {
            font-size: 0.9rem;
            line-height: 1.6;
            color: #4a5568;
        }
        .legal-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #a0aec0;
            transition: color 0.2s;
        }
        .legal-modal-close:hover {
            color: #4a5568;
        }
        /* Custom styled checkbox label link */
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin: 15px 0;
            font-size: 0.82rem;
            color: #4a5568;
            text-align: left;
        }
        .checkbox-container input {
            margin-top: 3px;
            cursor: pointer;
        }
        .legal-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }
        .legal-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="left-panel">
        <div class="left-content">
            <div class="welcome-small">Welcome to</div>
            <div class="brand-large">CHAMS - MISD</div>
            <div class="tagline">
                Efficient IT Services. Accurate Asset Control. <strong>ONE</strong> Platform.
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="logo-area">
            <img src="../Assets/Images/ICONS/CHAMS.webp" alt="CHAMS Logo" class="logo-img">
        </div>

        <div id="loginView" class="login-form">
            <div class="form-title" style="text-align: center;">Portal Access</div>
            
            <?php if (isset($_GET['error'])): ?>
    <div class="error-msg" style="color: #e53e3e; background: #fff5f5; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.85rem; text-align: center; border: 1px solid #fed7d7;">
        <?php
        if ($_GET['error'] == 'invalid') echo "Invalid Employee ID or Password";
        if ($_GET['error'] == 'disabled') echo "Your account has been disabled. Please contact administration.";
        if ($_GET['error'] == 'retired') echo "Access denied. Retired staff accounts are deactivated.";
        if ($_GET['error'] == 'notfound') echo "User not found";
        if ($_GET['error'] == 'exists') echo "Registration Error: This Employee ID or Email is already registered.";
        if ($_GET['error'] == 'db_error') echo "Critical Connection Error encountered during account processing.";
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
    <div class="success-msg" style="color: #2f855a; background: #f0fff4; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.85rem; text-align: center; border: 1px solid #c6f6d5; font-weight: 600;">
        <i class="fas fa-check-circle"></i> Account created successfully! You can now log in.
    </div>
<?php endif; ?>

            <form id="loginForm" class="login-form" method="POST" action="Config/loginProcess.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="empId" id="empId" class="form-input" placeholder="Employee ID" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Password" required>
                </div>
                <button type="submit" class="btn-action" id="loginBtn">Login</button>
                
                <div style="display: flex; justify-content: space-between; margin-top: 15px; font-size: 0.85rem;">
                    <a class="toggle-link" onclick="toggleViews('forgot')">Forgot Password?</a>
                    <a class="toggle-link" onclick="toggleViews('register')" style="font-weight: 600; color: #2563eb;">Create Account</a>
                </div>
            </form>
        </div>

        <div id="forgotView" class="login-form" style="display: none;">
            <div class="form-title" style="text-align: center;">Reset Password</div>
            <p style="font-size: 0.8rem; color: #777; text-align: center; margin-bottom: 10px;">Enter your ID to request a reset link.</p>

            <form id="forgotForm" class="login-form" onsubmit="event.preventDefault();">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="resetEmpId" class="form-input" placeholder="Employee ID" required>
                </div>
                <button type="submit" class="btn-action" id="forgotBtn" onclick="sendTestReset()">Submit Request</button>
                <a class="toggle-link" onclick="toggleViews('login')">Back to Login</a>
            </form>
        </div>

        <div id="registerView" class="login-form" style="display: none; margin-top: -10%;">
            <div class="form-title" style="text-align: center;">Create Account</div>
            
            <form id="registerForm" class="login-form" method="POST" action="Config/registerProcess.php" onsubmit="return validateRegistrationForm()">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="regEmpId" id="regEmpId" class="form-input" placeholder="Employee ID Number" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="regEmail" id="regEmail" class="form-input" placeholder="Corporate Email Address" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="regPassword" id="regPassword" class="form-input" placeholder="Password" required>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                    <label for="agreeTerms">
                        I read and agree to the <span class="legal-link" onclick="openLegalModal('termsModal')">Terms & Conditions</span> and <span class="legal-link" onclick="openLegalModal('privacyModal')">Privacy Policy</span>.
                    </label>
                </div>

                <button type="submit" class="btn-action" id="registerBtn">Register Account</button>
                <a class="toggle-link" onclick="toggleViews('login')">Already have an account? Login</a>
            </form>
        </div>
    </div>

    <div id="termsModal" class="legal-modal" onclick="closeLegalModalOutside(event, 'termsModal')">
        <div class="legal-modal-content">
            <span class="legal-modal-close" onclick="closeLegalModal('termsModal')">&times;</span>
            <div class="legal-modal-header">Terms and Conditions</div>
            <div class="legal-modal-body">
                <p><strong>1. Acceptance of Terms</strong><br>By accessing and creating an account on CHAMS-MISD (Computerized Helpdesk and Asset Management System), you agree to be bound by these institutional systems rules and security policies.</p>
                <p><strong>2. Account Security</strong><br>Users are explicitly responsible for maintaining the confidentiality of their portal passwords and authentication metrics. Any operations handled under your Employee ID profile will remain linked to your accountability matrix.</p>
                <p><strong>3. Acceptable Use Policy</strong><br>You agree not to bypass, manipulate, or insert malicious scripts into the system architecture, automated live database engines, or technical API endpoint parameters.</p>
            </div>
        </div>
    </div>

    <div id="privacyModal" class="legal-modal" onclick="closeLegalModalOutside(event, 'privacyModal')">
        <div class="legal-modal-content">
            <span class="legal-modal-close" onclick="closeLegalModal('privacyModal')">&times;</span>
            <div class="legal-modal-header">Privacy Policy</div>
            <div class="legal-modal-body">
                <p><strong>1. Information Collection</strong><br>CHAMS handles processing for internal enterprise records, including Employee Names, IDs, assigned Departments, contact numbers, and asset tracking histories.</p>
                <p><strong>2. Data Usage and Infrastructure Protection</strong><br>Collected telemetry profiles and location strings are utilized purely to process real-time helpdesk maintenance tickets and log asset allocation shifts accurately across departments.</p>
                <p><strong>3. Security Safeguards</strong><br>Data is isolated securely behind parameterized query modules and token-verified session checkpoints to block unauthorized leaks or visibility breaches.</p>
            </div>
        </div>
    </div>

    <script src="../Assets/JS/Login.js"></script>
    <script>
        // Inline Modal Controller Functions
        function openLegalModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeLegalModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function closeLegalModalOutside(event, modalId) {
            if (event.target === document.getElementById(modalId)) {
                closeLegalModal(modalId);
            }
        }

        // Frontend validation guard to ensure checkbox selection
        function validateRegistrationForm() {
            const check = document.getElementById('agreeTerms');
            if(!check.checked) {
                alert('You must review and accept the system Terms and Privacy Policies to proceed.');
                return false;
            }
            return true;
        }

        // In case your custom toggleViews function in Login.js needs an extension handler
        const originalToggleViews = window.toggleViews;
        window.toggleViews = function(view) {
            // Hide all subform cards safely
            document.getElementById('loginView').style.display = 'none';
            document.getElementById('forgotView').style.display = 'none';
            document.getElementById('registerView').style.display = 'none';

            if(view === 'login') {
                document.getElementById('loginView').style.display = 'block';
            } else if(view === 'forgot') {
                document.getElementById('forgotView').style.display = 'block';
            } else if(view === 'register') {
                document.getElementById('registerView').style.display = 'block';
            } else if (typeof originalToggleViews === 'function') {
                originalToggleViews(view);
            }
        };
    </script>
</body>

</html>
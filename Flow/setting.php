<?php
session_start();
ob_clean();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

// Check if your system uses an alternative session variable for the string token lookup
$uid = $_SESSION['user_id'] ?? 0;
if (isset($_SESSION['employee_id'])) {
    $uid = $_SESSION['employee_id'];
}

$user = $q->getUserByEmpId($uid);
$stats = $q->getDashboardStats();
$test = $q->getUserById($uid);

// Dynamically read whatever data comes back from the database record payload
$firstName = $user['FN'] ?? $user['fn'] ?? ''; 
$lastName  = $user['LN'] ?? $user['ln'] ?? '';

$currentContact = $test['contact_no'];
$rawAddress     = $test['address'];

// Split Address Logic
$bldg = ''; $street = ''; $brgy = ''; $city = '';
if (!empty($rawAddress) && strpos($rawAddress, '|') !== false) {
    $parts = explode('|', $rawAddress);
    $bldg   = trim($parts[0] ?? '');
    $street = trim($parts[1] ?? '');
    $brgy   = trim($parts[2] ?? '');
    $city   = trim($parts[3] ?? '');
} else {
    $bldg = $rawAddress;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CHAMS - SETTING</title>
    <?php include dirname(__DIR__) . '/Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/setting.css">
    <link rel="stylesheet" href="../Assets/CSS/filter.css">
</head>
<body>
<div class="ball"></div>
    <?php include dirname(__DIR__) . '/Modules/header.php' ?>

    <div class="container">
        <?php include dirname(__DIR__) . '/Modules/sidebar.php' ?>

        <div id="bugOverlay">
            <div class="bug-container">
                <div class="bug-close" onclick="closeBugReport()">×</div>
                <div class="bug-icon"><i class="fas fa-bug"></i></div>
                <h2>REPORT A BUG</h2>
                <textarea class="bug-textarea" id="bugInput" placeholder="Describe the issue here..."></textarea>
                <br>
                <button class="bug-submit" onclick="submitBug()" id="submitBugBtn">
                    <span id="btnText">Submit Report</span>
                    <span id="btnLoader" style="display: none;">
                        <i class="fa fa-spinner fa-spin"></i> Sending...
                    </span>
                </button>
            </div>
        </div>

        <div class="content">
            <div class="page-header" id="pageHeadText" style="width: 19%; padding: 2%; cursor: pointer;" onclick="window.location.href='dashboard.php'">
                <i class="fa-solid fa-chevron-left"></i> SETTINGS
            </div>

            <div class="settings-layout-wrapper" style="display: flex; gap: 30px; width: 100%; align-items: flex-start; justify-content: space-between;">
                
                <div class="profile-section" style="flex: 1; min-width: 300px; background: white; border-radius: 12px; padding: 25px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div class="big-avatar"><i class="fas fa-user"></i></div>
                    <div class="big-name"><?php echo htmlspecialchars($fullname); ?></div>
                    <div class="big-role">
                        <?php echo htmlspecialchars($rna . " | " . $dna) ?>
                    </div>

                    <div class="action-container" style="margin-top: 20px;">
                        <?php if ($role === 2): ?>
                            <div class="profile-btn" onclick="window.location.href='profile.php'">
                                <i class="fas fa-user-circle"></i>
                                <span>Account Profile</span>
                                <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="profile-btn" onclick="openEditName()">
                            <i class="fas fa-edit"></i>
                            <span>Change Display Name</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <div class="profile-btn" onclick="openChangePassword()">
                            <i class="fas fa-lock"></i>
                            <span>Change Password</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <div class="profile-btn" onclick="window.location.href='faqs.php'">
                            <i class="fas fa-question-circle"></i>
                            <span>Frequently Asked Questions</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>
                        <div class="profile-btn" onclick="window.location.href='terms.php'">
                            <i class="fas fa-file-contract"></i>
                            <span>Terms & Conditions</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>
                        
                        <div class="report-bug" onclick="openRecoveryLedger()">
                            <i class="fas fa-trash"></i>
                            <span>Trash</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>
                        <div class="report-bug" onclick="openBugReport()">
                            <i class="fas fa-bug"></i>
                            <span>Report a Bug</span>
                            <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 0.8rem; opacity: 0.5;"></i>
                        </div>

                        <div class="signout-btn" onclick="window.location.href='../Config/logout.php'">
                            <i class="fas fa-power-off"></i>
                            <span>Sign Out</span>
                        </div>
                    </div>
                </div>

                
                <div id="archiveModal" class="custom-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
                    <div class="modal-box" style="background:#fff; width:70%; max-height:80vh; border-radius:12px; padding:25px; box-shadow:0 10px 25px rgba(0,0,0,0.2); display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #f1f1f1; padding-bottom:15px; margin-bottom:15px;">
                            <h3 style="margin:0; color:#c0392b;"><i class="fas fa-trash-alt"></i> CHAMS Centralized Recovery Ledger</h3>
                            <button onclick="document.getElementById('archiveModal').style.display='none'" style="background:none; border:none; font-size:20px; cursor:pointer; color:#888;">&times;</button>
                        </div>
                        
                        <div style="overflow-y:auto; flex-grow:1;">
                            <table style="width:100%; border-collapse:collapse; font-size:13px; text-align:left;">
                                <thead>
                                    <tr style="background:#f8f9fa; border-bottom:2px solid #ddd;">
                                        <th style="padding:10px;">Module</th>
                                        <th style="padding:10px;">Ref ID</th>
                                        <th style="padding:10px;">Removed By</th>
                                        <th style="padding:10px;">Timestamp</th>
                                        <th style="padding:10px; text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $archives = $q->getArchiveLedger();
                                    if(empty($archives)): ?>
                                        <tr><td colspan="5" style="text-align:center; padding:30px; color:#999; font-style:italic;">The system recycle bin ledger is completely clear.</td></tr>
                                    <?php else: foreach($archives as $item): ?>
                                        <tr style="border-bottom:1px solid #eee;">
                                            <td style="padding:10px;"><span class="badge" style="background:#7f8c8d; color:#fff; padding:3px 8px; border-radius:4px; font-size:11px;"><?= $item['Module_Type'] ?></span></td>
                                            <td style="padding:10px; font-weight:bold; color:#2c3e50;"><?= htmlspecialchars($item['Reference_Num']) ?></td>
                                            <td style="padding:10px;"><?= htmlspecialchars($item['FN'] . ' ' . $item['LN']) ?></td>
                                            <td style="padding:10px;"><?= date('M d, Y h:i A', strtotime($item['Deleted_At'])) ?></td>
                                            <td style="padding:10px; text-align:center;">
                                                <button type="button" class="btn" style="background:#27ae60; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; font-size:11px;" onclick="triggerRestore(<?= $item['A_ID'] ?>)">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div style="flex: 1.5; min-width: 350px;">
                    
                    <div id="contactViewCard" style="background: white; border-radius: 12px; padding: 25px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="margin:0; font-size: 1.15rem; color: #111827;">
                                <i class="fas fa-id-card" style="color: #4a5568; margin-right: 5px;"></i> Personal Information
                            </h3>
                            <button onclick="toggleContactForm()" style="background: #eff6ff; color: #2563eb; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-pen"></i> Edit Info
                            </button>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <div style="font-size: 13px; color: #6b7280; font-weight: 500;">Contact Number</div>
                            <div style="font-size: 15px; font-weight: 600; color: #111827; margin-top: 5px;">
                                <?= htmlspecialchars($currentContact) ?>
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 13px; color: #6b7280; font-weight: 500;">Address</div>
                            <div style="font-size: 15px; font-weight: 600; color: #111827; margin-top: 5px; line-height: 1.5;">
                                <?php
                                $addressString = implode(', ', array_filter(array_map('trim', [$bldg, $street, $brgy, $city])));
                                echo !empty($addressString) ? htmlspecialchars($addressString) : '<span style="font-weight:400; color:#a0aec0; font-style:italic;">Not provided</span>';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div id="contactEditCard" style="display: none; background: #fafafa; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; box-shadow: inset 0 1px 3px rgba(0,0,0,0.01); margin-bottom: 20px;">
                        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.1rem; color: #2d3748; border-bottom: 2px solid #edf2f7; padding-bottom: 8px;">
                            <i class="fas fa-edit" style="color: #4a5568;"></i> Update Contact Information
                        </h3>

                        <div style="margin-bottom: 15px;">
                            <label style="display:block; font-size:13px; font-weight:600; color:#4a5568; margin-bottom:4px;">Primary Contact Number</label>
                            <input type="text" id="setContactNo" value="<?= htmlspecialchars($currentContact) ?>" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;" placeholder="e.g., 09123456789">
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <label style="display:block; font-size:11px; font-weight:700; color:#718096; text-transform:uppercase; margin-bottom:4px;">Bldg / House No.</label>
                                <input type="text" id="setBldg" placeholder="e.g., Blk 4 Lot 2" value="<?= htmlspecialchars($bldg) ?>" style="width:100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1.5;">
                                <label style="display:block; font-size:11px; font-weight:700; color:#718096; text-transform:uppercase; margin-bottom:4px;">Street Name</label>
                                <input type="text" id="setStreet" placeholder="e.g., Lapu-Lapu St." value="<?= htmlspecialchars($street) ?>" style="width:100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                            <div style="flex: 1;">
                                <label style="display:block; font-size:11px; font-weight:700; color:#718096; text-transform:uppercase; margin-bottom:4px;">Barangay</label>
                                <input type="text" id="setBrgy" placeholder="e.g., Barangay 171" value="<?= htmlspecialchars($brgy) ?>" style="width:100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                            <div style="flex: 1;">
                                <label style="display:block; font-size:11px; font-weight:700; color:#718096; text-transform:uppercase; margin-bottom:4px;">City</label>
                                <input type="text" id="setCity" placeholder="e.g., Caloocan City" value="<?= htmlspecialchars($city) ?>" style="width:100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="toggleContactForm()" style="background: #e5e7eb; border: none; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 13px;">
                                Cancel
                            </button>
                            <button id="saveContactBtn" type="button" onclick="savePersonalContactInfo()" style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>

                </div>
            </div> </div>
    </div>

    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/setting.js"></script>
    <script src="../Assets/JS/background.js"></script>

    <script>
        // --- BUG REPORTING MODULE ---
        function openBugReport() {
            document.getElementById('bugOverlay').style.display = 'flex';
        }

        function closeBugReport() {
            document.getElementById('bugOverlay').style.display = 'none';
            document.getElementById('bugInput').value = '';
        }

        function submitBug() {
            const description = document.getElementById('bugInput').value.trim();
            if (!description) {
                alert('Please provide details about the bug.');
                return;
            }

            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const submitBtn = document.getElementById('submitBugBtn');

            // Show loading indicators
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            submitBtn.disabled = true;

            const payload = new URLSearchParams();
            payload.append('description', description);

            fetch('../Config/reportBug.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: payload
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP status ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Bug report submitted successfully!');
                    closeBugReport();
                } else {
                    alert('Failed to submit report: ' + (data.message || 'Server error.'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Network error. Could not connect to the action engine.');
            })
            .finally(() => {
                // Reset UI elements back to default state
                btnText.style.display = 'inline-block';
                btnLoader.style.display = 'none';
                submitBtn.disabled = false;
            });
        }


        // --- RECOVERY & INFORMATION MODULE ---
        function openRecoveryLedger() {
            if (typeof stopRefresh === 'function') {
                stopRefresh();
            } else if (typeof stopTrackerRefresh === 'function') {
                stopTrackerRefresh();
            }

            const archiveModal = document.getElementById('archiveModal');
            if (archiveModal) {
                archiveModal.style.display = 'flex';
                archiveModal.style.opacity = '0';
                
                setTimeout(() => {
                    archiveModal.style.transition = 'opacity 0.2s ease-in-out';
                    archiveModal.style.opacity = '1';
                }, 10);
            } else {
                console.error("CHAMS Core Error: Core target DOM container 'archiveModal' could not be initialized.");
            }
        }

        function triggerRestore(archiveId) {
    const archiveModal = document.getElementById('archiveModal');
    if (archiveModal) { archiveModal.style.display = 'none'; }
    
    Swal.fire({
        title: 'Restore Record?',
        text: "This will push the archived data row parameters back into the live system tables.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#27ae60',
        cancelButtonColor: '#7f8c8d',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../Config/updateAction.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'restore_archive',
                    archive_id: archiveId
                })
            })
            // 1. Grab raw text first to inspect it
            .then(res => {
                if (!res.ok) throw new Error('HTTP status ' + res.status);
                return res.text();
            })
            .then(rawText => {
                // 2. Locate where the actual JSON begins, filtering out accidental PHP notices/whitespace
                const jsonStartIndex = rawText.indexOf('{');
                if (jsonStartIndex === -1) {
                    throw new Error('No valid JSON object found in response payload.');
                }
                
                const cleanJsonString = rawText.substring(jsonStartIndex);
                const data = JSON.parse(cleanJsonString);

                // 3. Evaluate the structural data flags
                if (data.status === 'success' || data.success === true) {
                    Swal.fire('Restored!', data.message || 'Record successfully re-injected.', 'success');
                    setTimeout(() => { location.reload(); }, 1000);
                } else {
                    if (archiveModal) archiveModal.style.display = 'flex';
                    Swal.fire('Restore Failed', data.message || 'The server rejected the transaction.', 'error');
                }
            })
            .catch(err => {
                console.error("CHAMS Pipeline Debug Log:", err);
                if (archiveModal) archiveModal.style.display = 'flex';
                Swal.fire('Parsing/Network Error', 'The action completed, but the server sent back unparseable text data.', 'error');
            });
        }
    });
}

        function toggleContactForm() {
            const editCard = document.getElementById('contactEditCard');
            if (editCard.style.display === 'none') {
                editCard.style.display = 'block';
                editCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                editCard.style.display = 'none';
            }
        }

        function savePersonalContactInfo() {
            const contactVal = document.getElementById('setContactNo').value.trim();
            const bldg = document.getElementById('setBldg').value.trim();
            const street = document.getElementById('setStreet').value.trim();
            const brgy = document.getElementById('setBrgy').value.trim();
            const city = document.getElementById('setCity').value.trim();
            
            if(!contactVal) {
                alert('Please include your primary contact number.');
                return;
            }

            const joinedAddress = `${bldg}|${street}|${brgy}|${city}`;

            const payload = new URLSearchParams();
            payload.append('contactNo', contactVal);
            payload.append('address', joinedAddress);

            const saveBtn = document.getElementById('saveContactBtn');
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

            fetch('../Config/updateContact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: payload
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP status error ' + response.status);
                }
                return response.json();
            })
            .then(result => {
                if(result.success) {
                    saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
                    saveBtn.style.backgroundColor = '#38a169';
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    alert('Failed to save parameters: ' + (result.message || 'Database rejected'));
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                }
            })
            .catch(error => {
                console.error('Submission failed:', error);
                alert('Server pipeline communication issue occurred.');
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
            });
        }
    </script>
</body>
</html>
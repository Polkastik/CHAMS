<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';
$q = new QueryHandler();

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$mode = $_GET['mode'] ?? 'ticketing';
$isEditMode = isset($_GET['edit']) && $_GET['edit'] == 'true' && $_SESSION['role'] != 2;

$data = null;

if ($mode === 'inventory') {
    $data = $q->getInventoryById($id);
    $pageTitle = "Viewing Item: " . ($data['item_name'] ?? 'Unknown');

} elseif ($mode === 'maintenance') {
    $data = $q->getMaintenanceById($id);
    $pageTitle = "Viewing Maintenance: #" . ($data['M_ID'] ?? 'Unknown');

} else {
    $data = $q->getTicketById($id);
    $pageTitle = "Viewing Ticket: #" . ($data['T_ID'] ?? 'Unknown');
}

if (isset($_GET['ajax']) && $_GET['ajax'] === 'view') {
    ob_start();

    if (!$data) {
        echo "Record not found.";
        exit;
    }

    if ($isEditMode) {
        include '../Modules/edit.php';
    } else {
        include '../Modules/view.php';
    }

    echo ob_get_clean();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= 'CHAMS - ' . $pageTitle ?></title>
    <?php include '../Config/univHead.php'; ?>
    <link rel="stylesheet" href="../Assets/CSS/tile.css">
    <link rel="stylesheet" href="../Assets/CSS/edit.css">
</head>

<body>
    <div class="ball"></div>

    <?php include '../Modules/header.php' ?>

    <div class="container">
        <?php include '../Modules/sidebar.php' ?>

        <?php
        if ($isEditMode) {
            include '../Modules/edit.php';
        } else {
            include '../Modules/view.php';
        }
        ?>

    </div>

<div id="virtualAssetModal" class="modal-overlay" style="display: none; fixed: true; z-index: 9999; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; padding: 25px; border-radius: 8px; width: 60%; max-height: 80vh; overflow-y: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0; color: #333;">
                <i class="fas fa-boxes"></i> Serialized Asset Breakdown (Total: <?= htmlspecialchars($data['Quantity']) ?>)
            </h3>
            <button onclick="closeVirtualModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">&times;</button>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 10px;">Asset ID Tag</th>
                    <th style="padding: 10px;">Item Name</th>
                    <th style="padding: 10px;">Generated Serial Number</th>
                    <th style="padding: 10px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalUnits = (int)($data['Quantity'] ?? 0);
                $itemId = htmlspecialchars($data['I_ID']);
                $itemName = htmlspecialchars($data['item_name']);
                $baseSerial = !empty($data['Serial_number']) ? htmlspecialchars($data['Serial_number']) : "NKTI-" . strtoupper(substr($itemName, 0, 3));

                if ($totalUnits <= 0): 
                ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #999;">No physical stocks registered for this item profile.</td>
                    </tr>
                <?php 
                else: 
                    // Loop precisely 100 times to simulate separate items
                    for ($i = 1; $i <= $totalUnits; $i++): 
                        // Generates sequences like: AST-005-001, AST-005-002, etc.
                        $assetTag = "AST-" . str_pad($itemId, 3, '0', STR_PAD_LEFT) . "-" . str_pad($i, 3, '0', STR_PAD_LEFT);
                        // Appends sequential endings to the base serial tag
                        $virtualSerial = $baseSerial . "-" . str_pad($i, 3, '0', STR_PAD_LEFT);
                ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px; font-weight: bold; color: #0056b3;"><?= $assetTag ?></td>
                        <td style="padding: 10px;"><?= $itemName ?></td>
                        <td style="padding: 10px; font-family: monospace; font-size: 14px;"><?= $virtualSerial ?></td>
                        <td style="padding: 10px;">
                            <span class="badge assigned" style="background: #e3f2fd; color: #0d47a1; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                <?= ($data['Defects'] === 'Yes' && $i === 1) ? 'Defective' : 'In Stock / Available' ?>
                            </span>
                        </td>
                    </tr>
                <?php 
                    endfor; 
                endif; 
                ?>
            </tbody>
        </table>
    </div>
</div>
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/edit.js"></script>
    <script src="../Assets/JS/background.js"></script>

    <script> // I put it here cuz it has php codes -Nathan
		const globalDeptOptions = `<?= $deptOptions ?>`;
        const CURRENT_DATA = <?= json_encode($data) ?>;
        const IS_EDIT_MODE = <?= $isEditMode ? 'true' : 'false' ?>;

        function updateBadgeColor(selectElement) {
            const colorClasses = [
                'unlabeled', 'low', 'medium', 'high',
                'unresolved', 'ongoing', 'resolved',
                'assigned', 'unassigned'
            ];

            selectElement.classList.remove(...colorClasses);
            let newValue = selectElement.value.toLowerCase();

            if (selectElement.name === 'staff_id') {
                newValue = (selectElement.value === "") ? 'unassigned' : 'assigned';
            }

            if (newValue) {
                selectElement.classList.add(newValue);
            }
        }

        <?php if ($mode === 'ticketing'): ?>
            function viewAttachment() {
                const fileName = "<?= $data['attachment'] ?? '' ?>";
                if (fileName && fileName.trim() !== "") {
                    window.open("../Assets/Gen_Files/" + fileName, "_blank");
                } else {
                    alert("No attachment provided for this ticket. :)");
                }
            }

            function downloadTicket() {
                const ticketNum = "<?= $data['ticket_num'] ?? '0000' ?>";
                const applicant = "<?= addslashes($data['creator_LN'] ?? 'User') ?>";
                const originalTitle = document.title;

                document.title = "CHAMS_Ticket_" + ticketNum + "_" + applicant;
                window.print();
                document.title = originalTitle;
            }
        <?php endif; ?>

        <?php if ($mode === 'inventory'): ?>
            function printInventory() {
                window.print();
            }
        <?php endif; ?>


        // AJAX
        let refreshInterval;

        function startTileRefresh() {

            if (IS_EDIT_MODE) return;
            const id = <?= json_encode($id) ?>;
            const mode = "<?= $mode ?>";
            const urlParams = new URLSearchParams(window.location.search);
            const from = urlParams.get('from') || '';

            refreshInterval = setInterval(() => {
                fetch(`tileView.php?id=${id}&mode=${mode}&from=${from}&ajax=view`)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newContent = doc.querySelector('.content');
                        const currentContent = document.querySelector('.content');

                        if (newContent && currentContent) {
                            currentContent.innerHTML = newContent.innerHTML;
                        }
                    })
                    .catch(err => console.error("Tile refresh error:", err));
            }, 1000);
        }

        function stopRefresh() {
            clearInterval(refreshInterval);
        }

        startTileRefresh();

        async function openCommentModal() {
            const { value: text } = await Swal.fire({
                title: 'Add a Comment',
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your comment here...',
                inputAttributes: { 
                    'aria-label': 'Type your comment here',
                    'maxlength': '250',
                },
                footer: '<small id="swalCharCount" style="color: gray; font-family: sans-serif;">0 / 250 characters</small>',
                showCancelButton: true,
                confirmButtonColor: '#28ba1b',

                // 3. Attach a live tracking callback as soon as the DOM opens
                didOpen: () => {
                    const textarea = Swal.getInput();
                    const counter = document.getElementById('swalCharCount');

                    if (textarea && counter) {
                        textarea.addEventListener('input', function() {
                            counter.innerText = this.value.length + ' / 250 characters';
                        });
                    }
                }
            });

            if (text) {
                // Send to your PHP action handler
                post('../Config/updateAction.php', {
                    action: 'add_comment',
                    ticket_id: '<?= $id ?>',
                    comment: text
                }).then(res => {
                    if (res.includes('success')) {
                        Swal.fire('Saved', '', 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', res, 'error');
                    }
                });
            }
        }
        
function openVirtualModal() {
    document.getElementById('virtualAssetModal').style.display = 'flex';
}

function closeVirtualModal() {
    document.getElementById('virtualAssetModal').style.display = 'none';
}
    </script>
</body>

</html>
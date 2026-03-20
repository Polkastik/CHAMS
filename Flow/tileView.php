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


    <script>
        const globalDeptOptions = `<?= $deptOptions ?>`;
    </script>
    <script src="../Assets/JS/sidebar.js"></script>
    <script src="../Assets/JS/edit.js"></script>
    <script src="../Assets/JS/background.js"></script>

    <script> // I put it here cuz it has php codes -Nathan

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
                inputAttributes: { 'aria-label': 'Type your comment here' },
                showCancelButton: true,
                confirmButtonColor: '#28ba1b'
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

    </script>
</body>

</html>
<?php
session_start();
require_once 'auth.php';
require_once 'queryHandler.php';

$q = new QueryHandler();

function clean_input($data)
{
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

$_POST = clean_input($_POST);

function toInt($val)
{
    return filter_var($val, FILTER_VALIDATE_INT);
}

function toString($val)
{
    return is_string($val) ? trim($val) : null;
}

$allowedTypes = ['Preventive', 'Predictive', 'Corrective'];
$allowedPriority = ['Low', 'Medium', 'High', 'N/A'];
$allowedStatus = ['Scheduled', 'Ongoing', 'Resolved', null];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine if we are updating a category or a record first
    if (isset($_POST['action']) && $_POST['action'] === 'create_category') {
        $name = $_POST['cat_name'];
        $desc = $_POST['cat_desc'];
        $userId = $_SESSION['user_id'];

        if ($q->createCategory($name, $desc, $userId)) {
            header("Location: ../Flow/inventory.php?success=CategoryAdded");
        } else {
            header("Location: ../Flow/inventory.php?error=Failed");
        }
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_category') {
        $catId = $_POST['cat_id'];
        $name = $_POST['category_name'];
        $desc = $_POST['category_desc'];
        $color = $_POST['category_color'];
        $userId = $_SESSION['user_id'];

        if ($q->updateCategory($catId, $name, $desc, $color, $userId)) {
            header("Location: ../Flow/inventory.php?success=CategoryUpdated");
        } else {
            header("Location: ../Flow/inventory.php?error=UpdateFailed");
        }
        exit;

        // maintenance
    } elseif (isset($_POST['mode']) && $_POST['mode'] === 'maintenance_create') {

        $asset = $_POST['asset_name'] ?? 'Asset';
        $dept = $_POST['Dept_ID'] ?? null;
        $type = $_POST['m_type'] ?? null;
        $desc = $_POST['description'] ?? null;
        $priority = !empty($_POST['priority']) ? $_POST['priority'] : null;

        $status = !empty($_POST['status']) ? $_POST['status'] : null;
        $interval = $_POST['interval'] ?? null;

        $nextDate = null;

        if (!empty($interval) && $status !== null) {
            $nextDate = date('Y-m-d H:i:s', strtotime($interval));
        }

        if (!in_array($type, $allowedTypes))
            $type = null;
        if (!in_array($priority, $allowedPriority))
            $priority = null;
        if (!in_array($status, $allowedStatus))
            $status = null;

        $validDepartments = array_column($q->getDepartments(), 'D_ID');
        if (!in_array($dept, $validDepartments)) {
            $dept = null;
        }

        $success = $q->createMaintenance(
            $asset,
            $dept,
            $type,
            $desc,
            $priority,
            $status,
            $nextDate
        );

        if ($success) {
            header("Location: ../Flow/maintenanceLog.php?success=created");
        } else {
            header("Location: ../Flow/maintenanceLog.php?error=failed");
        }
        exit;
    }

    $id = $_POST['id'] ?? null;
    $mode = $_POST['mode'] ?? null;

    if (!$mode) {
        header("Location: ../Flow/dashboard.php?error=mode_unspecified");
        exit;
    }

    if (!$id) {
        header("Location: ../Flow/inventory.php?error=not_found");
        exit;
    }

    if ($_POST['mode'] === 'maintenance') {

        $id = $_POST['id'];
        $asset = $_POST['asset_name'];
        $dept = $_POST['Dept_ID'] ?? null;
        $type = $_POST['m_type'];
        $desc = $_POST['description'];
        $priority = $_POST['priority'];
        $status = !empty($_POST['status']) ? $_POST['status'] : null;
        $interval = $_POST['interval'] ?? null;

        $currentNext = $_POST['current_next'] ?? null;

        $nextDate = null;

        if (!empty($interval) && $status !== null) {
            $baseDate = $currentNext ? strtotime($currentNext) : time();
            $nextDate = date('Y-m-d H:i:s', strtotime($interval, $baseDate));
        }

        if (!in_array($type, $allowedTypes))
            $type = null;
        if (!in_array($priority, $allowedPriority))
            $priority = null;
        if (!in_array($status, $allowedStatus))
            $status = null;

        $validDepartments = array_column($q->getDepartments(), 'D_ID');
        if (!in_array($dept, $validDepartments)) {
            $dept = null;
        }


        $success = $q->updateMaintenance(
            $id,
            $asset,
            $dept,
            $type,
            $desc,
            $priority,
            $status,
            $nextDate
        );

        if ($success) {
            $userId = $_SESSION['user_id'];
            $actionText = "Updated Maintenance #$id";
            $q->logActivity($userId, $actionText, $id, 'Maintenance');
        }
        if (isset($_POST['action']) && $_POST['action'] === 'resolve_maintenance') {

            $id = $_POST['id'];
            $interval = $_POST['interval'] ?? null;

            if (!empty($interval)) {
                $nextDate = date('Y-m-d H:i:s', strtotime($interval));

                $current = $q->getMaintenanceById($id);

                $dept = $current['Dept_ID'] ?? null;

                $success = $q->updateMaintenance(
                    $id,
                    $current['Asset_name'],
                    $dept,
                    $current['M_type'],
                    $current['desc'],
                    $current['Priority'],
                    $current['Status'],
                    $nextDate
                );
            }
        }

    } elseif ($mode === 'inventory') {
        // inventory
        $current = $q->getInventoryById($id);
        if (!$current) {
            header("Location: ../Flow/inventory.php?error=not_found");
            exit;
        }

        $categ_ID = $_POST['categ_id'] ?? $current['categ_ID'];
        $item_name = $_POST['item_name'] ?? $current['item_name'];
        $item_type = $_POST['item_type'] ?? $current['item_type'];
        $item_brand = $_POST['item_brand'] ?? $current['item_brand'];
        $quantity = $_POST['quantity'] ?? $current['Quantity'];
        $threshold = $_POST['threshold'] ?? $current['Threshold'];
        $item_supplier = $_POST['supplier'] ?? $current['item_supplier'];
        $defects = $_POST['defects'] ?? $current['Defects'];
        $serial_number = !empty(trim($_POST['serial'])) ? $_POST['serial'] : null;
        $date_received = $_POST['date_received'] ?? $current['date_received'];
        $collected_by = $_POST['collected_by'] ?? $current['collected_by'];


        $quantity = toInt($quantity);
        $threshold = toInt($threshold);

        if ($quantity < 0)
            $quantity = 0;
        if ($threshold < 0)
            $threshold = 0;

        $admins = $q->getUsersByRole(1);
        if ($quantity < $current['Quantity'] && $quantity <= $threshold) {
            foreach ($admins as $admin) {
                $q->createNotification(
                    $admin['U_ID'],
                    "Item '$item_name' is low on stock.",
                    "inventory",
                    $id
                );
            }
        }

        $success = $q->updateInventory(
            $id,
            $categ_ID,
            $item_name,
            $item_type,
            $item_brand,
            $quantity,
            $threshold,
            $item_supplier,
            $defects,
            $serial_number,
            $date_received,
            $collected_by
        );

        if ($success) {
            $userId = $_SESSION['user_id'];
            $actionText = "Updated Item: " . $item_name;
            $q->logActivity($userId, $actionText, $id, 'Inventory');
        }

    } elseif ($mode === 'ticketing') {
        // ticketing logic

        $id = toInt($id);
        $current = $q->getTicketById($id);

        if (!$current) {
            header("Location: ../Flow/ticketing.php?error=not_found");
            exit;
        }

        $title = $_POST['title'] ?? $current['Title'];
        $description = $_POST['description'] ?? $current['T_description'];
        $priority = $_POST['priority'] ?? $current['Priority'];
        $type = $_POST['type'] ?? $current['t_type'];
        $adminId = $_SESSION['user_id'];
        $staff_id = $_POST['staff_id'] ?? $current['Assigned_To'];
        $status = $_POST['status'] ?? $current['Status'];
        $due_date = !empty($_POST['due_date']) ? date('Y-m-d H:i:s', strtotime($_POST['due_date'])) : $current['due_date'];
        $issued_item_id = isset($_POST['issued_item_id']) ? $_POST['issued_item_id'] : $current['issued_item_id'];
        $issued_qty = isset($_POST['issued_qty']) ? $_POST['issued_qty'] : $current['issued_qty'];
        $issued_qty = toInt($issued_qty);

        $itemData = $q->getInventoryById($issued_item_id);

        if ($issued_qty < 1)
            $issued_qty = 1;

        $staff_id = toInt($staff_id);
        $issued_item_id = toInt($issued_item_id);

        switch ($_POST['action']) {
            case 'accept':
                $status = 'Ongoing';
                $staff_id = $_SESSION['user_id'];
                $q->logActivity($_SESSION['user_id'], "Accepted Ticket: " . $title, $id, 'Ticketing');

                $q->createNotification($current['Created_By'], "Your ticket #$id has been accepted.", "ticket", $id);
                break;

            case 'resolve':
                $status = 'Resolved';

                $q->logActivity($_SESSION['user_id'], "Resolved Ticket: " . $title, $id, 'Ticketing');

                $q->createNotification($current['Created_By'], "Your ticket #$id has been resolved.", "ticket", $id);
                break;

            case 'save':
                if ($_SESSION['role'] == 1 && !empty($_POST['issued_item_id'])) {

                    $itemId = $_POST['issued_item_id'];
                    $qty = $_POST['issued_qty'] ?? 1;
                    $ticketId = $_POST['id'];
                    $receivedBy = $current['Created_By'];
                    $adminId = $_SESSION['user_id'];

                    // Check stock before updating
                    if ($itemData['Quantity'] < $issued_qty) {
                        header("Location: ../Flow/tileView.php?id=$id&mode=ticketing&error=insufficient_stock");
                        exit;
                    }

                    $success = $q->issueInventoryFromTicket($itemId, $qty, $ticketId, $receivedBy, $adminId);

                    if ($success) {
                        header("Location: ../Flow/tileView.php?id=$ticketId&mode=ticketing&success=issued");
                        $q->logActivity($adminId, "Issued Item #$itemId to Ticket #$ticketId", $itemId, 'Inventory');
                        exit;
                    } else {
                        header("Location: ../Flow/tileView.php?id=$ticketId&mode=ticketing&error=db_fail");
                        exit;
                    }
                }
                break;
        }

        // updating invDb after editing in edit.php
        if (!empty($issued_item_id)) {
            $receivedBy = $current['Created_By'] ?? 'Applicant';
            $userId = $_SESSION['user_id'];

            // if the Item ID has changed
            if (!empty($current['issued_item_id']) && $issued_item_id != $current['issued_item_id']) {
                // Return old item to stock
                $q->adjustInventoryStock($current['issued_item_id'], -$current['issued_qty'], $id, $adminId);
                // Deduct new item from stock
                $q->adjustInventoryStock($issued_item_id, $issued_qty, $id, $adminId, $issued_item_id);

                $logMsg = "Swapped Item in Ticket #$id: from ID " . $current['issued_item_id'] . " to ID " . $issued_item_id;
                $q->logActivity($userId, $logMsg, $id, 'Ticketing');
            }

            // if quantity is different but same item
            elseif ($current['issued_item_id'] == $issued_item_id && $current['issued_qty'] != $issued_qty) {
                $difference = $issued_qty - $current['issued_qty'];

                if ($difference > 0) {
                    if ($itemData['Quantity'] < $difference) {
                        header("Location: ../Flow/tileView.php?id=$id&mode=ticketing&error=insufficient_stock");
                        exit;
                    }
                }

                $q->adjustInventoryStock($issued_item_id, $difference, $id, $adminId);
                $logMsg = "Adjusted Qty in Ticket #$id: " . $current['issued_qty'] . " -> " . $issued_qty;
                $q->logActivity($userId, $logMsg, $id, 'Ticketing');
            }

            // default (new insert if ever)
            elseif (empty($current['issued_item_id'])) {
                $q->issueInventoryFromTicket($issued_item_id, $issued_qty, $id, $receivedBy, $adminId);
            }
        }
        // \

        if (isset($_POST['action']) && $_POST['action'] === 'reopen_ticket') {
            $ticketId = $_POST['ticket_id'];
            if ($q->reopenTicket($ticketId)) {
                $q->logActivity($_SESSION['user_id'], "Reopened Ticket #$ticketId", $ticketId, 'Ticketing');
                header("Location: ../Flow/tileView.php?id=$ticketId&mode=ticketing&msg=reopened");
                exit();
            }
        }
        // \

        $requestedQty = (int) $_POST['issued_qty'];

        $currentStock = 0;

        if (!empty($issued_item_id)) {
            $itemData = $q->getInventoryById($issued_item_id);
            $currentStock = $itemData['Quantity'] ?? 0;
        }

        if (
            !empty($issued_item_id) &&
            isset($_POST['action']) &&
            $_POST['action'] === 'save' &&
            $issued_qty > $currentStock
        ) {
            header("Location: ../Flow/tileView.php?id=$id&mode=ticketing&error=over_capacity");
            exit;
        }

        $changes = [];

        if ($title != $current['Title'])
            $changes[] = "Title";
        if ($status != $current['Status'])
            $changes[] = "Status to $status";
        if ($priority != $current['Priority'])
            $changes[] = "Priority";
        if ($staff_id != $current['Assigned_To']) {
            $staffName = $q->getStaffNameById($staff_id);
            $changes[] = "Assigned to $staffName.";

            $q->createNotification(
                $staff_id, 
                "New Assignment: You have been assigned to Ticket #$id (" . htmlspecialchars($title) . ").", 
                "assignment", 
                $id
            );
        }


        if ($status === 'Resolved' && $current['Status'] !== 'Resolved') {
            $q->createNotification(
                $current['Created_By'],
                "ticket #$id has been resolved by " . ($_SESSION['user_name'] ?? "Staff"),
                "ticket",
                $id
            );
        }

        $success = $q->updateTicket($id, $title, $description, $priority, $status, $staff_id, $due_date, $type, $issued_item_id, $issued_qty);

        if ($success) {
            $userId = $_SESSION['user_id'];
            if (!empty($changes)) {
                $actionText = "Updated Ticket #" . $id . " (" . implode(", ", $changes) . ")";
            } else {
                $actionText = "Saved changes to Ticket #" . $id;
            }
            $q->logActivity($userId, $actionText, $id, 'Ticketing');
        }
    }

    if ($success) {
        header("Location: ../Flow/tileView.php?id=" . $id . "&mode=" . $mode . "&msg=updated");
        exit;
    } else {
        echo "Error updating " . htmlspecialchars($mode) . ".";
    }

} else {
    header("Location: ../Flow/dashboard.php");
    exit;
}
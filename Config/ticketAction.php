<?php
require_once '../Config/db.php';
require_once '../Config/queryHandler.php';

$db = new database();
$db->connect();

$q = new QueryHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';
    $ids = json_decode($_POST['ids'] ?? '[]', true);

    if (empty($ids)) {
        echo "No IDs provided.";
        exit;
    }

    try {

        if ($action === 'bulk_delete') {

            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $stmt = $q->ticketDB->prepare("
                DELETE FROM tickets 
                WHERE T_ID IN ($placeholders)
            ");

            $stmt->execute($ids);
            echo "Deleted successfully";


        } elseif ($action === 'bulk_resolve') {

            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $stmt = $q->ticketDB->prepare("
                UPDATE tickets 
                SET Status = 'Resolved', resolved_at = NOW()
                WHERE T_ID IN ($placeholders)
            ");

            $stmt->execute($ids);
            echo "Resolved successfully";

        } else {
            echo "Invalid action";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
<!-- for export csv only -->
<?php
session_start();
require_once 'queryHandler.php';
$q = new QueryHandler();

if (isset($_GET['id']) && $_GET['type'] === 'inventory') {
    $id = $_GET['id'];
    $data = $q->getInventoryById($id);

    if ($data) {
        ob_end_clean();
        ob_start();
        
        $filename = "Asset_" . $data['Serial_number'] . "_" . date('Ymd') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        fputcsv($output, ['Item Name', 'Category', 'Brand', 'Quantity', 'Threshold','Supplier', 'Defects', 'Serial Number', 'Received Date', 'Added By']);

        fputcsv($output, [
            $data['item_name'],
            $data['categ_ID'],
            $data['item_brand'],
            $data['Quantity'],
            $data['Threshold'],
            $data['item_supplier'],
            $data['Defects'],
            $data['Serial_number'],
            $data['date_received'],
            $data['creator_FN'] . ' ' . $data['creator_LN']
        ]);

        fclose($output);
        exit();
    }
}
?>
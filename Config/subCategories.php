<?php
require_once 'queryHandler.php';
$q = new QueryHandler();

ob_clean();

$catId = $_GET['cat_id'] ?? 0;

$subCategories = $q->getSubCategoriesByCatId($catId);

header('Content-Type: application/json');
echo json_encode($subCategories);
exit;
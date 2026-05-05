<?php
// require_once '../Config/queryHandler.php';
// $q = new QueryHandler();

// if (isset($_GET['term']) && strlen($_GET['term']) > 2) {
//     $data = $q->globalSearch($_GET['term']);
    
//     if (empty($data['tickets']) && empty($data['assets']) && empty($data['logs'])) {
//         echo '<div class="search-item">No results found.</div>';
//     } else {
//         foreach ($data as $category => $items) {
//             if (!empty($items)) {
//                 echo "<div class='search-cat-header'>" . strtoupper($category) . "</div>";
//                 foreach ($items as $item) {
//                     echo "<div class='search-item' onclick='goToResult(\"{$item['type']}\", \"{$item['id']}\")'>
//                             {$item['title']} <span class='search-id'>#{$item['id']}</span>
//                           </div>";
//                 }
//             }
//         }
//     }
// }

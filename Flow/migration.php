<!-- makes not  hashed, hashed -->
<?php
require '../Config/db.php'; // This file creates $conn

$stmt = $conn->query("SELECT U_ID, pass_hash FROM users WHERE LENGTH(pass_hash) < 60");
$users = $stmt->fetchAll();

foreach ($users as $user) {

    $newHash = password_hash($user['pass_hash'], PASSWORD_DEFAULT);
    
    $update = $conn->prepare("UPDATE users SET pass_hash = ? WHERE U_ID = ?");
    $update->execute([$newHash, $user['U_ID']]);
    
    echo "Updated User ID: " . $user['U_ID'] . " (James is now hashed!)<br>";
}

echo "Migration complete! Now go to Login.php and try logging in.";

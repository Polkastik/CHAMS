<?php
session_start();

require_once 'queryHandler.php';
$q = new QueryHandler();

// log before logging out haha get it
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $q->logLogout($uid);

    if (!$result) {
        error_log("Logout log failed for User ID: " . $uid);
    }
}

$_SESSION = array();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

header("Location: ../Flow/Login.php?status=loggedout");
exit();
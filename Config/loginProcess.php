<?php
session_start();
require_once 'db.php';
require_once 'queryHandler.php';

$q = new QueryHandler();

//Get form data
$empId = trim($_POST['empId']);
$password = $_POST['password'];

//Get user
$user = $q->getUserByEmpId($empId);

if ($user) {

    if ($user['status'] !== 'active') {
        $q->logLogin($user['U_ID'], 'failed');
        header("Location: ../index.php?error=inactive");
        exit;
    }

    $db_password = $user['pass_hash'];
    $login_success = false;

    //if the password is already hashed
    if (password_verify($password, $db_password)) {
        $login_success = true;
    }

    //if not hashed then hash
    elseif ($password === $db_password) {

        // Re-hash and update using USERS DB
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Access DB from handler (quick fix approach)
        $stmt = $q->usersDB->prepare("
            UPDATE users SET pass_hash = :hash WHERE U_ID = :id
        ");
        $stmt->execute([
            'hash' => $hashed,
            'id' => $user['U_ID']
        ]);

        $login_success = true;
    }

    else {
        $q->logLogin($user['U_ID'], 'failed');
        header("Location: ../index.php?error=invalid");
        exit;
    }

    if ($login_success) {
        // messy but it works !! DO NOT REMOVE SYSTEM WILL GO DOWN !!
        // Basically it gets all the necessary info of the user
        $_SESSION['user_id'] = $user['U_ID'];
        $_SESSION['role'] = $user['role_id'];
        $_SESSION['rna'] = $user['role_name'];
        $_SESSION['dept'] = $user['D_ID'];
        $_SESSION['dna'] = $user['Dept_Name'];
        $_SESSION['fname'] = $user['FN'];
        $_SESSION['lname'] = $user['LN'];

        $q->logLogin($user['U_ID'], 'Login');

        header("Location: ../Flow/dashboard.php");
        exit;
    }

} else {
    $q->logLogin($user['U_ID'], 'failed');
    header("Location: ../index.php?error=notfound");
    exit;
}
?>
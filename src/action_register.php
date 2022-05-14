<?php
    require_once('database/user.class.php');
    require_once('database/connection.db.php');

    session_start();

    $db = getDatabaseConnection();
    $email = $_POST["email"];
    $fist_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    
    if (User::emailInUse($db, $email)) {
        $referer = '../register.php';
    }
    else if ($confirm_password != $password) {
        $referer = '../register.php'; 
    }
    else if (User::newUser($db, $fist_name, $last_name, $email, $password)) {
            $referer = '../login.php';
        } 

    header('Location: ' . $referer);
?>
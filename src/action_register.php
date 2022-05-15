<?php
    declare(strict_types = 1);

    require_once('database/user.class.php');
    require_once('database/connection.db.php');

    session_start();

    $db = getDatabaseConnection();
    $email = $_POST["email"];
    $fist_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
        header('Location: ../register.php?register=empty');
        exit();
      }
    else if (User::emailInUse($db, $email)) {
        header('Location: ../register.php?register=email');
        exit();
    }
    else if ($confirm_password != $password) {
        header('Location: ../register.php?register=password');
        exit();
    }
    else if (User::newUser($db, $fist_name, $last_name, $email, $password)) {
        header('Location: ../login.php?login=register');
        exit();
    }
?>
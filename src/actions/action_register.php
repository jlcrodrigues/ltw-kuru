<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();


    $db = getDatabaseConnection();
    $email = $_POST["email"];
    $fist_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
        $session->addMessage('error', 'You have to fill in all fields.');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
      }
    else if (User::emailInUse($db, $email)) {
        $session->addMessage('error', 'Email already in use');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }
    else if ($confirm_password != $password) {
        $session->addMessage('error', "Passwords don't match");
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }
    else if (User::newUser($db, $fist_name, $last_name, $email, $password)) {
        $session->addMessage('success', 'Register successfull!');
        die(header('Location: ../pages/login.php'));
    }
?>
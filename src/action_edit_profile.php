<?php
    declare(strict_types = 1);

    session_start();

    require_once('database/user.class.php');
    require_once('database/connection.db.php');

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_SESSION['id']);

    if ($user) {
        if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
            header('Location: ../profile.php?profile=failed_empty');
            exit();
        }

        if ( !preg_match ("/^[a-zA-Z ]+$/", $_POST['first_name']) || !preg_match ("/^[a-zA-Z ]+$/", $_POST['last_name'])) {
            header('Location: ../profile.php?profile=failed_name');
            exit();
          }

        $email = $_POST["email"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $phone = $_POST["phone"];
        
        if (User::updateUser($db, $email, $first_name, $last_name, $address, $city, $country, $phone, $_SESSION['id'])) {
            header('Location: ../profile.php?profile=success');
            exit();
        }
        else {
            header('Location: ../profile.php?profile=failed');
        exit();
        }

    }
?>
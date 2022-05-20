<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();
    if(!$session->isLoggedIn()) die(header('Location: /'));

    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_SESSION['id']);

    if ($user) {
        if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
            $session->addMessage('error', 'Names and email cannot empty!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }

        if ( !preg_match ("/^[a-zA-Z ]+$/", $_POST['first_name']) || !preg_match ("/^[a-zA-Z ]+$/", $_POST['last_name'])) {
            $session->addMessage('error', 'Names can only contain spaces and letters!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
          }

        $email = $_POST["email"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $phone = $_POST["phone"];
        
        if (User::updateUser($db, $email, $first_name, $last_name, $address, $city, $country, $phone, $_SESSION['id'])) {
            $session->addMessage('success', 'Profile updated!');
            die(header('Location: ../pages/profile.php'));
        }
        else {
            $session->addMessage('error', 'Email already in use!');
            die(header('Location: ' . $_SERVER('HTTP_REFERER')));
        }

    }
?>
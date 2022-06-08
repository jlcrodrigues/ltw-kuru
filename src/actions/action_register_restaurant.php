<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();
    if(!$session->isLoggedIn()) die(header('Location: /'));


    $db = getDatabaseConnection();
    $user_id = $session->getId();
    $name = $_POST["name"];
    $opens = $_POST["opens"];
    $closes = $_POST["closes"];
    $category = $_POST["category"];
    $address = $_POST["address"];

    if (empty($_POST['name']) || empty($_POST['opens']) || empty($_POST['closes']) || empty($_POST['category']) || empty($_POST['address'])) {
        $session->addMessage('error', 'You have to fill in all fields.');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
      }
    else if (Restaurant::newRestaurant($db, $user_id, $name, $opens, $closes, $category, $address)) {
        $session->addMessage('success', 'Register successfull!');
        die(header('Location: ../pages/profile.php'));
     }
     else {
        $session->addMessage('error', 'Failed!');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
     }
    
?>
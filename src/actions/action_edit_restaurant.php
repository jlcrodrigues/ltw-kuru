<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $id = intval($_GET['id']);

    if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || Restaurant::getRestaurantOwner($db, $id) != $session->getId()) {
        die(header('Location: /')); 
     }



    if (empty($_POST['name']) || empty($_POST['opens']) || empty($_POST['closes']) || empty($_POST['category'] || empty($_POST['address']))) {
        $session->addMessage('error', 'All fields must be filled!');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }

    if ( !preg_match ("/^[a-zA-Z0-9\-\' ]+$/", $_POST['name'])) {
        $session->addMessage('error', 'Invalid name!');
        die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }

    $id = $_GET['id'];
    $name = $_POST["name"];
    $opens = $_POST["opens"];
    $closes = $_POST["closes"];
    $category = $_POST["category"];
    $address = $_POST["address"];
    
    if (Restaurant::updateRestaurant($db, $name, $opens, $closes, $category, $address, intval($id))) {
        $session->addMessage('success', 'Restaurant updated!');
        die(header('Location: ../pages/index.php'));
    }
    else {
        $session->addMessage('error', 'Register failed!');
        die(header('Location: ' . $_SERVER('HTTP_REFERER')));
    }
?>
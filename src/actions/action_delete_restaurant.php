<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');

require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/../database/connection.db.php');


$session = new Session();
    $db = getDatabaseConnection();
     $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));

     if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
         die(header('Location: /')); 
      }

    if (Restaurant::deleteRestaurant($db, intval($restaurant->id))) {
        $session->addMessage('success', 'Restaurant deleted!');
        die(header('Location: ../pages/index.php'));
    }
    else {
        $session->addMessage('error', 'Failed to delete restaurant');
        die(header('Location: ../pages/owner_view.php?id=' . $restaurant->id));
    }
?>
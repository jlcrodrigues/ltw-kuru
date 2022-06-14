<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/../database/connection.db.php');


$session = new Session();
$db = getDatabaseConnection();
$id_dish = $_GET['id'];
$restaurant = Restaurant::getDishRestaurant($db, $id_dish);

if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
    die(header('Location: /'));
}

if (!valid_input($_GET['id'])) {
    die(header('Location: /'));
}

if (Dish::deleteDish($db, intval($id_dish))) {
    $session->addMessage('success', 'Dish deleted!');
    die(header('Location: ../pages/owner_view.php?id=' . $restaurant->id));
} else {
    $session->addMessage('error', 'Failed to delete dish');
    die(header('Location: ../pages/owner_view.php?id=' . $restaurant->id));
}

<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/../database/connection.db.php');


if (!$session->getCSRF()) {
    $session->setCSRF(generate_random_token());
  }
if ($session->getCSRF() !== $_POST['csrf']) {
    die(header('Location: ../index.php'));
}

$db = getDatabaseConnection();
$restaurant = Restaurant::getRestaurant($db, intval($_GET["id"]));


if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
    die(header('Location: /'));
}

if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category'])) {
    $session->addMessage('error', 'All fields must be filled!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

if (!valid_input_list(array($_POST["name"], $_POST["description"], $_POST["price"], $_POST["category"]))) {
    $session->addMessage('error', 'Invalid name!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

$name = $_POST["name"];
$description = $_POST["description"];
$price = $_POST["price"];
$category = $_POST["category"];

if (Dish::newDish($db, intval($restaurant->id), $name, $description, floatval($price), $category)) {
    $session->addMessage('success', 'Dish created successfully!');
    die(header('Location: ../pages/owner_view.php?id=' . $restaurant->id));
} else {
    $session->addMessage('error', 'Failed to create dish!');
    die(header('Location: ../pages/owner_view.php?id=' . $restaurant->id));
}

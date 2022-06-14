<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  if (!valid_input($_GET['search'])) {
    $session->addMessage('error', 'Invalid input!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  $restaurants = Restaurant::searchRestaurants($db, $_GET['search'], 5);

  echo json_encode($restaurants);
?>
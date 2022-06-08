<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $restaurants = Restaurant::searchRestaurants($db, $_GET['search'], 5);

  echo json_encode($restaurants);
?>
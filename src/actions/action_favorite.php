<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  if(!$session->isLoggedIn()) 
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  $db = getDatabaseConnection();

  $idRestaurant = intval($_POST["id"]);
  $type = $_POST["type"];

  if ($type == "restaurant") {
    User::setFavoriteRestaurant($db, $session->getId(), $idRestaurant);
  }

  header("Location: ../pages/restaurant.php?id=$idRestaurant");
?>
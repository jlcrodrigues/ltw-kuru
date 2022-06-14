<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/review.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  if(!$session->isLoggedIn()) 
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  $db = getDatabaseConnection();

  $idRestaurant = intval($_POST["idRestaurant"]);
  $rating = intval($_POST["rating"]);
  $text = $_POST["text"];

  Review::addReview($db, $session->getId(), $idRestaurant, $rating, $text);

?>
<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn())
  die(header('Location: ' . $_SERVER['HTTP_REFERER']));

$db = getDatabaseConnection();

$idRestaurant = intval($_POST["idRestaurant"]);
$type = $_POST["type"];
if (!valid_input_list(array(
  $_POST["type"],
  $_POST["idRestaurant"]
))) {
  $session->addMessage('error', 'Invalid input!');
  die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

if ($type == "restaurant") {
  echo User::setFavoriteRestaurant($db, $session->getId(), $idRestaurant);
} elseif ($type == "dish") {
  $id = intval($_POST["id"]);
  if (!valid_input($_POST["id"])) {
    $session->addMessage('error', 'Invalid input!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }
  echo User::setFavoriteDish($db, $session->getId(), $id);
}

<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $session = new Session();
  if(!$session->isLoggedIn()) 
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  $db = getDatabaseConnection();

  $action = $_POST["action"];

  if ($action == "add") {
    $idDish = intval($_POST["idDish"]);
    $quantity = intval($_POST["quantity"]);
    Dish::addDishToOrder($db, intval($idDish), $session->getId(), $quantity);
  }
  if ($action == "remove-order") {
    $idOrder = intval($_POST["idOrder"]);
    User::deleteOrder($db, $session->getId(), $idOrder);
  }
  if ($action == "submit-order") {
    $idOrder = intval($_POST["idOrder"]);
    User::submitOrder($db, $session->getId(), $idOrder);
  }
  if ($action == "deliver-order") {
    $idOrder = intval($_POST["idOrder"]);
    $restaurant = Restaurant::getOrderRestaurant($db, $idOrder);
    if ($session->isOwnerRestaurant($restaurant->id)) {
      User::deliverOrder($db, $session->getId(), $idOrder);
    }
  }
  if ($action == "remove-dish") {
    $idOrder = intval($_POST["idOrder"]);
    $idDish = intval($_POST["idDish"]);
    User::deleteOrderDish($db, $session->getId(), $idOrder, $idDish);
  }
  if ($action == "repeat-order") {
    $idOrder = intval($_POST["idOrder"]);
    User::repeatOrder($db, $session->getId(), $idOrder);
  }
?>
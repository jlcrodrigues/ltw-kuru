<?php
  declare(strict_types=1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../utils/security.php');
  
  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/review.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

  $session = new Session();
  if (!$session->getCSRF()) {
    $session->setCSRF(generate_random_token());
  }

  $db = getDatabaseConnection();
  $id_dish = intval($_GET['id']);
  $restaurant = Restaurant::getDishRestaurant($db, $id_dish);


if (!valid_input($_GET['id'])) {
  $session->addMessage('error', 'Invalid input!');
  die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
  die(header('Location: /'));
}


$id = intval($_GET['id']);
$dish = Dish::getDish($db, $id);

output_header($session);
output_edit_dish_form($db, $session, $dish);
output_footer();

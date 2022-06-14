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
    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
        die(header('Location: /')); 
     }

if (!valid_input($_GET['id'])) {
  $session->addMessage('error', 'Invalid input!');
  die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

output_header($session);
output_add_dish_form($db, $session, $restaurant);
output_footer();

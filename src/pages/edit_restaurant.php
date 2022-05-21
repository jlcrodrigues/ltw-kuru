<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  
  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/review.class.php');

  $session = new Session();
  if (!$session->isOwner($session->getId()) || !$session->isLoggedIn()) {
    if(!$session->isLoggedIn()) die(header('Location: /')); 
  }

  $db = getDatabaseConnection();

  $id = $_GET['id'];
  $restaurant = Restaurant::getRestaurant($db, intval($id));

  output_header($session);
  output_edit_restaurant($db, $session, $restaurant);
  output_footer();
?>
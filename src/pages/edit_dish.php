<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  
  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/review.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');


    $session = new Session();
    $db = getDatabaseConnection();
    $id = intval($_GET['id']);

    if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || Restaurant::getRestaurantOwner($db, $id) != $session->getId()) {
        die(header('Location: /')); 
     }


  $id = intval($_GET['id']);
  $dish = Dish::getDish($db, $id);

  output_header($session);
  output_edit_dish_form($db, $session, $dish);
  output_footer();
?>
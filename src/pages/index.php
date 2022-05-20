<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');
  require_once(__DIR__ . '/../templates/search.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $restaurants = Restaurant::getRestaurants($db, 60);

  output_header($session);
  output_search_bar();

  $offset = 0;
  for ($i = 0; $i < 10; $i++) {
   output_restaurant_slide(array_slice($restaurants, $offset, 6));
   $offset += 6;
  }
  output_footer();
?>
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

  $categories = Restaurant::getCategories($db);

  output_header($session);
  output_search_bar();

  foreach ($categories as $category) {
    $restaurants = Restaurant::getRestaurantsByCategory($db, $category);
    if (sizeof($restaurants) < 5) continue;
    output_restaurant_slide($restaurants, ucwords($category));
  }
  output_footer();
?>
<?php declare(strict_types = 1); ?>

<?php
  session_start();

  require_once('database/connection.db.php');
  require_once('database/restaurant.class.php');

  require_once('templates/common.php');
  require_once('templates/restaurants.php');
  require_once('templates/search.php');

  $db = getDatabaseConnection();

  $restaurants = Restaurant::getRestaurants($db, 60);

  output_header();
  output_search_bar();

  $offset = 0;
  for ($i = 0; $i < 10; $i++) {
   output_restaurant_slide(array_slice($restaurants, $offset, 6));
   $offset += 6;
  }
  output_footer();
?>
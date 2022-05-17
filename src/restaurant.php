<?php declare(strict_types = 1); ?>

<?php
  session_start();

  require_once('database/connection.db.php');
  require_once('database/restaurant.class.php');
  require_once('database/dish.class.php');
  require_once('database/review.class.php');
  require_once('database/user.class.php');

  require_once('templates/common.php');
  require_once('templates/restaurants.php');
  require_once('templates/search.php');

  $db = getDatabaseConnection();

  $id = $_GET['id'];
  $restaurant = Restaurant::getRestaurant($db, intval($id));
  $dishes = Dish::getRestaurantDishes($db, intval($id));
  $reviews = Review::getRestaurantReviews($db, intval($id));
  $average = Restaurant::getAverage($db, intval($id));
  // $users = User::getUsers($db, );


  output_header();
  output_restaurant_card($restaurant, $dishes, $reviews, $average); 
  output_footer();
?>
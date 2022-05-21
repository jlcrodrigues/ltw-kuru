<?php declare(strict_types = 1); ?>

<?php
  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/review.class.php');
  require_once(__DIR__ . '/../database/user.class.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');
  require_once(__DIR__ . '/../templates/search.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $id = $_GET['id'];
  $restaurant = Restaurant::getRestaurant($db, intval($id));
  $dishes = Dish::getRestaurantDishes($db, intval($id));
  $reviews = Review::getRestaurantReviews($db, intval($id));
  $average = Restaurant::getAverage($db, intval($id));


  output_header($session);
  output_restaurant_card($db, $session, $restaurant, $dishes, $reviews, $average); 
  output_footer();
?>
<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $restaurants = Restaurant::searchRestaurants($db, $_POST['search'], 5);
  /*$categories = $_POST['selected_categories'];
  if (empty($categories)){
    $categories = Restaurant::getCategories($db);
  }
  $restaurants = array();
  foreach ($categories as $category){
    $restaurants_by_category = Restaurant::getRestaurantsByCategory($db,$category);
    $restaurants = array_merge($restaurants,$restaurants_by_category);
  }
  */
  $averages = array();
  foreach ($restaurants as $restaurant){
    $averages[$restaurant->id] = Restaurant::getAverage($db, $restaurant->id);
  }
  echo json_encode(array('a'=>$restaurants,'b'=>$averages));
?>

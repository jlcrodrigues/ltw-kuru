<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $categories = explode(",",$_POST['selected_categories'][0]);
  if (empty($categories)){
    $categories = Restaurant::getCategories($db);
  }
  $restaurants = array();
  foreach ($categories as $category){
    $restaurants_by_category = Restaurant::searchRestaurantsByCategory($db,$category,$_POST['search']);
    $restaurants = array_merge($restaurants,$restaurants_by_category);
  }

  $averages = array();
  $final_restaurants = array();
  $i=0;
  foreach ($restaurants as $restaurant){
    if(($averages[$restaurant->id] = Restaurant::getAverage($db, $restaurant->id))>=$_POST['minimum_rating']){
        array_push($final_restaurants,  $restaurant);
    }
    $i++;
    if($i>4){
        break;
    }
  }
  echo json_encode(array('a'=>$final_restaurants,'b'=>$averages));
?>

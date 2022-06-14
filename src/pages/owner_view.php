<?php

declare(strict_types=1); ?>

<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/../database/review.class.php');
require_once(__DIR__ . '/../database/user.class.php');

require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../templates/restaurants.php');
require_once(__DIR__ . '/../templates/search.php');

if (!valid_input($_GET['id'])) {
  $session->addMessage('error', 'Invalid input!');
  die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

$db = getDatabaseConnection();
$id = intval($_GET['id']);

$session = new Session();
if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || Restaurant::getRestaurantOwner($db, $id) != $session->getId()) {
  die(header('Location: /'));
}

$id = $_GET['id'];
$restaurant = Restaurant::getRestaurant($db, intval($id));
$dishes = Dish::getRestaurantDishes($db, intval($id));
$reviews = Review::getRestaurantReviews($db, intval($id));
$average = Restaurant::getAverage($db, intval($id));


output_header($session);
output_owner_restaurant_card($db, $session, $restaurant, $dishes, $reviews, $average);
output_footer();
?>
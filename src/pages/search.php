<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../templates/restaurants.php');
require_once(__DIR__ . '/../templates/search.php');


$session = new Session();

$db = getDatabaseConnection();

if (isset($_POST['search'])) {
  if (!valid_input($_POST['search'])) {
    $session->addMessage('error', 'Invalid input!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }
}

$query = $_POST['search'];

$restaurants = Restaurant::getRestaurants($db, 5);


output_header($session);
output_search_bar($query);
echo '<div id="search">';
output_search_filter();
output_restaurant_search($restaurants);
echo '</div>';
output_footer();

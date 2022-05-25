<?php
declare(strict_types=1); 

require_once(__DIR__ . '/../utils/session.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../templates/restaurants.php');
require_once(__DIR__ . '/../templates/search.php');


$session = new Session();

$db = getDatabaseConnection();

$restaurants = Restaurant::getRestaurants($db, 5);


output_header($session);
output_search_bar();
echo '<div id="search">';
output_search_filter();
output_restaurant_search($restaurants);
echo '</div>';
output_footer();

?>
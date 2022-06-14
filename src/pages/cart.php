<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/user.class.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/orders.php');

  $session = new Session();

  if (!$session->isLoggedIn())
    header("Location: ../pages/login.php");

  $db = getDatabaseConnection();

  output_header($session);

  $orders_id = User::getOrdersByState($db, $session->getId(), 'Ordering');
  foreach ($orders_id as $id) {
    $restaurant = Restaurant::getOrderRestaurant($db, intval($id));
    if (!isset($restaurant)) {
      continue;
    }
    $dishes = Dish::getOrderDishes($db, intval($id));
    output_order_cart(intval($id), $restaurant, $dishes);
  }
  if (count($orders_id) == 0) {?>
    <div class="empty-page">
      <h2>No orders yet!</h1>
    </div>
  <?php }

  output_footer();
?>
<?php declare(strict_types = 1); ?>

<?php
  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/user.class.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/favorites.php');

  $session = new Session();

  $db = getDatabaseConnection();

  $restaurants = User::getFavoriteRestaurants($db, intval($_SESSION['id']));
  $dishes = User::getFavoriteDishes($db, intval($_SESSION['id']));

  output_header($session);
  output_favorites($restaurants, $dishes);
  output_footer();
?>
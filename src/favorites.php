<?php declare(strict_types = 1); ?>

<?php
  session_start();
  
  require_once('database/user.class.php');

  require_once('templates/common.php');
  require_once('templates/favorites.php');

  $db = getDatabaseConnection();

  $restaurants = User::getFavoriteRestaurants($db, $_SESSION['id']);

  output_header();
  output_favorites($restaurants);
  output_footer();
?>
<?php declare(strict_types = 1); ?>

<?php
  require_once('../templates/common.php');
  require_once('../templates/restaurants.php');
  require_once('../templates/search.php');

  output_header();
  output_restaurant_card(1000);
  output_footer();
?>
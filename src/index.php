<?php declare(strict_types = 1); ?>

<?php
  require_once('templates/common.php');
  require_once('templates/restaurants.php');
  require_once('templates/search.php');

  output_header();
  output_search_bar();
  for ($i = 0; $i < 10; $i++) {
    output_restaurant_slide();
  }
  output_footer();
?>
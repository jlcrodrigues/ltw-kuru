<?php declare(strict_types = 1); ?>

<?php
  session_start();
  
  require_once('templates/common.php');
  require_once('templates/favorites.php');

  output_header();
  output_favorites();
  output_footer();
?>
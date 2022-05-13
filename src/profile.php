<?php declare(strict_types = 1); ?>

<?php
  session_start();
  
  require_once('templates/common.php');
  require_once('templates/account.php');
  require_once('templates/search.php');

  output_header();
  output_profile(1);
  output_footer();
?>
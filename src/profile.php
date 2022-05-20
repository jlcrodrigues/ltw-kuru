<?php declare(strict_types = 1); ?>

<?php
  session_start();
  
  require_once('templates/common.php');
  require_once('templates/account.php');

  output_header();
  output_profile(intval($_SESSION['id']));
  output_footer();
?>
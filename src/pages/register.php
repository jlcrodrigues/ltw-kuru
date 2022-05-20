<?php declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');

  
  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/account.php');
  require_once(__DIR__ . '/../templates/search.php');

  $session = new Session();

  output_header($session);
  output_register();
  output_footer();

?>

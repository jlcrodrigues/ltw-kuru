<?php 
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  
  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/restaurants.php');


  $session = new Session();
  if (!$session->getCSRF()) {
    $session->setCSRF(generate_random_token());
  }
  
  $db = getDatabaseConnection();

     if (!$session->isOwner($session->getId()) || !$session->isLoggedIn()) {
      die(header('Location: /')); 
   }

  output_header($session);
  output_register_restaurant_form($db, $session);
  output_footer();
?>
<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../utils/security.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/account.php');
  require_once(__DIR__ . '/../templates/search.php');


  $session = new Session();
  if (!$session->getCSRF()) {
    $session->setCSRF(generate_random_token());
  }

  output_header($session);
  if (isset($_SESSION['id'])) { 
    header('Location: ../pages/profile.php');
  }
  else { 
    output_login($session);
  }
  output_footer();
?>
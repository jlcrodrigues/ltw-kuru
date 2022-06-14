<?php
  declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/security.php');

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    if (!$session->getCSRF()) {
      $session->setCSRF(generate_random_token());
    }
    if ($session->getCSRF() !== $_POST['csrf']) {
      die(header('Location: ../index.php'));
    }

    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
      $session->addMessage('error', 'You have to fill in all fields.');
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }
    else if ($user == NULL) {
      $session->addMessage('error', 'Wrong email or password');
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }
    else if (!valid_input_list(array($_POST['email']))) {
      $session->addMessage('error', 'Invalid input!');
      die(header('Location: ' . $_SERVER['HTTP_REFERER']));
    }
    else {
      $session->setId($user->id);
      $session->setName($user->first_name);
      $session->addMessage('success', 'Login Successfull');
      die(header('Location: ../pages/index.php'));
    }
?>
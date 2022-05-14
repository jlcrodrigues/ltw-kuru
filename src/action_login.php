<?php
  declare(strict_types = 1);

  if (isset($_POST["submit"])) {

    session_start();

    require_once('database/connection.db.php');
    require_once('database/user.class.php');

    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
      header('Location: ../login.php?login=empty');
      exit();
    }

    else if ($user == NULL) {
      header('Location: ../login.php?login=password'); 
      exit();
    }

    else {
      $_SESSION['id'] = $user->id;
      $_SESSION['name'] = $user->name;
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
?>
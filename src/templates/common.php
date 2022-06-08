<?php

declare(strict_types=1); ?>

<?php
function output_header(Session $session)
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Kuru</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/text.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <script src="../js/script.js" defer></script>
  </head>

  <body>
    <header>
      <h1><a href="../pages/index.php">Kuru</a></h1>
      <h3><a href="../pages/search.php">Search</a></h1>
        <?php
        if ($session->isLoggedIn()) { ?>
          <h3><a href="../pages/favorites.php">Favorites</a></h1>
          <?php } else { ?>
            <h3><a href="../pages/login.php">Favorites</a></h1>
            <?php } ?>
            <?php
            if ($session->isLoggedIn()) { ?>
              <a href="../pages/cart.php">
                <i class="material-icons icon-4x">shopping_cart</i>
              </a>
              <a href="../pages/profile.php">
                <i class="material-icons icon-4x">account_circle</i>
              </a>
            <?php } else { ?>
              <a href="../pages/login.php">
                <i class="material-icons icon-4x">account_circle</i>
              </a>
            <?php }
            ?>
    </header>

    <article id="messages">
      <?php foreach ($session->getMessages() as $message) { ?>
        <section class="message <?= $message['type'] ?>">
          <p><?= $message['text'] ?></p>
          <button 
            class="close-message"
            onclick="closeMessage(event)">
            <i class="material-symbols-rounded">close</i>
          </button>
        </section>
      <?php } ?>
    </article>

  <?php } ?>

  <?php
  function output_footer()
  { ?>
    <div id="footer-prev"></div>
    <footer>
      <p>&copy; Kuru, 2022</p>
    </footer>
  </body>

  </html>

<?php } ?>
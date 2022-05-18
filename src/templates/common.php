<?php
declare(strict_types=1); ?>

<?php
function output_header()
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Restaurant</title>
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
      <h1><a href="../index.php">Restaurant</a></h1>
      <h3><a href="search.php">Search</a></h1>
      <h3><a href="">Favorites</a></h1>
      <?php 
          if (isset($_SESSION['id'])) { ?>
            <a href="profile.php">
            <i class="material-icons icon-4x">account_circle</i>
            </a>
          <?php }
          else { ?>
            <a href="login.php">
            <i class="material-icons icon-4x">account_circle</i>
          </a>
        <?php }
      ?>
    </header>


  <?php }

function output_footer()
{ ?>
    <footer>
      <p>&copy; Restaurant, 2002</p>
    </footer>
  </body>

  </html>

<?php } ?>
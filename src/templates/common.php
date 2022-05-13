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
      <a href="profile.php">
        <i class="material-icons icon-4x">account_circle</i>
      </a>
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
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  </head>

  <body>
    <header>
      <h1><a href="../index.php">Restaurant</a></h1>
      <a href="../pages/profile.php">
        <i class="material-icons">account_circle</i>
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
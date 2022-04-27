<?php declare(strict_types = 1); ?>

<?php
function output_header()
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Restaurant</title>
    <meta charset="UTF-8">
  </head>

  <body>
    <header>
      <h1><a href="index.php">Restaurant</a></h1>
      <a href="login.php">Login</a>
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
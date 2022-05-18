<?php

declare(strict_types=1);

require_once("restaurants.php");
?>

<?php
function output_favorites(array $restaurants, array $dishes)
{ ?>
  <section id="favorites">
    <header>
      <h1>Favorites</h1>
    </header>

    <body>
      <?php 
      foreach ($restaurants as $restaurant) {
        output_restaurant_card_nano($restaurant);
      }
      foreach ($dishes as $dish) {
        output_meal($dish);
      } ?>
    </body>
  </section>

<?php } ?>
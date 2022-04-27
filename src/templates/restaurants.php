<?php

declare(strict_types=1); ?>

<?php
function output_restaurant_card(int $id)
{ ?>
  <a href="../pages/restaurant.php" id="restaurant">
    <img src="https://picsum.photos/id/10<?php echo $id ?>/300/300" alt="">
    <h3>Restaurant</h3>
    <h4>Location</h4>
  </a>
<?php }

function output_restaurant_slide()
{
?>
  <section id="restaurants">
    <?php
    for ($i = 0; $i < 5; $i++) {
      output_restaurant_card($i);
    }
    ?>
  </section>
<?php
} ?>

<?php
function output_restaurant_details(int $id)
{ ?>
  <a href="../pages/restaurant.php" id="restaurant">
    <img src="https://picsum.photos/id/10<?php echo $id ?>/300/300" alt="">
    <h3>Restaurant</h3>
    <h4>Location</h4>
    <p>Adress</p>
    <p>Rating</p>
    <p>Preço</p>
  </a>
<?php } ?>

<?php
function output_restaurant_search()
{ ?>
  <section id="restaurants">
    <?php
    for ($i = 0; $i < 5; $i++) {
      output_restaurant_details($i);
    }
    ?>
  </section>
<?php } ?>
<?php declare(strict_types = 1); ?>

<?php
function output_restaurant_card(int $id)
{ ?>
  <a href="restaurant.php" id="restaurant">
    <img src="https://picsum.photos/id/10<?php echo $id?>/300/300" alt="">
    <h3>Restaurant</h3>
    <h4>Location</h4>
  </a>
<?php }

function output_restaurant_section()
{
  for ($i = 0; $i < 5; $i++) {
    output_restaurant_card($i);
  }
} ?>
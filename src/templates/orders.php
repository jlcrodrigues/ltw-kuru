<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/restaurants.php');
?>

<?php
function output_cart_dish(Dish $dish) { ?>
  <section class="dish">
    <div>
      <h3><?php echo $dish->name ?></h3>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price?>€</p>
  </section>
<?php } ?>

<?php 
function output_order_cart(int $idOrder, Restaurant $restaurant, array $dishes)
{ ?>
  <article class="cart card">
    <h2><?=$restaurant->name?></h2>
    <button class="remove-order">
      <i class="material-symbols-rounded">delete</i>
    </button>
    <input type="hidden" name="idOrder" value="<?=$idOrder?>">
    <?php
    foreach ($dishes as $dish) { 
      output_cart_dish($dish);
     }
    ?>
    <hr>
    <div class="total">
      <h3>Total</h3>
      <h3>5.76€</h3>
      <br>
      <button>
        Order
      </button>
    </div>
  </article>

<?php } ?>
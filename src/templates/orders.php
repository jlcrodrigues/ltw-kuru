<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/dish.class.php');
require_once(__DIR__ . '/restaurants.php');
?>

<?php
function output_cart_dish(Dish $dish, int $quantity) { ?>
  <section class="dish">
    <div>
      <h3><?=$dish->name ?></h3>
      <h4><?=$dish->description ?></h4>
    </div>
    <p><?=$quantity?></p>
    <p><?=$dish->price?>€</p>
  </section>
<?php } ?>

<?php 
function output_order_cart(int $idOrder, Restaurant $restaurant, array $dishes)
{ 
  $total = 0;
  $dish_count = [];
  foreach ($dishes as $dish) {
    $total += $dish->price;
    if (!isset($dish_count[$dish->idDish])) $dish_count[$dish->idDish] = 0;
    $dish_count[$dish->idDish]++;
  }
  ?>
  <article class="cart card">
    <input type="hidden" name="idOrder" value="<?=$idOrder?>">
    <a href="../pages/restaurant.php?id=<?=$restaurant->id?>">
      <h2><?=$restaurant->name?></h2>
      <i class="material-symbols-rounded">navigate_next</i>
    </a>
    <button class="remove-order">
      <i class="material-symbols-rounded">delete</i>
    </button>
    <?php
    foreach ($dishes as $dish) { 
      if ($dish_count[$dish->idDish] > 0) {
        output_cart_dish($dish, $dish_count[$dish->idDish]);
        $dish_count[$dish->idDish] = 0;
      }
     }
    ?>
    <hr>
    <div class="total">
      <h3>Total</h3>
      <h3><?=$total?>€</h3>
      <br>
      <button class="submit-order">
        Order
      </button>
    </div>
  </article>

<?php } ?>
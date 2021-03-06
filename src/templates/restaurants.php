<?php

declare(strict_types=1); ?>

<?php

require_once(__DIR__ . '/../utils/session.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/restaurant.class.php');
require_once(__DIR__ . '/../database/review.class.php');
require_once(__DIR__ . '/../database/dish.class.php');

require_once(__DIR__ . '/../templates/orders.php');

function output_restaurant_card_nano(PDO $db, Session $session, Restaurant $restaurant)
{
?>
  <a href="../pages/restaurant.php?id=<?=urlencode(strval($restaurant->id))?>" class="restaurant-nano">
    <?php output_restaurant_photo($db, $session, $restaurant, 'thumbnails'); ?>
    <div class="nano-text">
      <h3><?php echo $restaurant->name ?></h3>
      <h4><?php echo $restaurant->address ?></h4>
    </div>
  </a>
<?php }

function output_restaurant_slide(PDO $db, Session $session, array $restaurants, string $title)
{
?>
  <section class="slide-category">
    <h2><?php echo $title ?></h2>
    <div class="slide">
      <div class="slide-box card">
        <?php
        foreach ($restaurants as $restaurant) {
          output_restaurant_card_nano($db, $session, $restaurant);
        }
        ?>
      </div>
      <a class="slide-left slide-button" onclick="sliderScrollLeft(event)">
        <i class="material-symbols-rounded">navigate_before</i>
      </a>
      <a class="slide-right slide-button" onclick="sliderScrollRight(event)">
        <i class="material-symbols-rounded">navigate_next</i>
      </a>
    </div>
  </section>
<?php
} ?>

<?php

function output_restaurant_card_mini(PDO $db, Session $session, Restaurant $restaurant)
{  ?>
  <a href="../pages/restaurant.php?id=<?=urlencode(strval($restaurant->id))?>" class="restaurant-mini">
    <?php output_restaurant_photo($db, $session, $restaurant, 'mini'); ?>
    <div class="mini-text">
      <h3><?php echo $restaurant->name?></h3>
      <h4><?php echo $restaurant->address?></h4>
      <p class="category"><?php echo $restaurant->category?></p>
      <p><?php echo Restaurant::getAverage($db, $restaurant->id)?>
        <i class="material-symbols-rounded">star</i>
      </p>
      <p id="opening-time"><?php echo substr($restaurant->opens, 0, 5) ?></p>
      <p id="closing-time"><?php echo substr($restaurant->closes, 0, 5) ?></p>
    </div>
  </a>
<?php } ?>

<?php
function output_restaurant_search(PDO $db, Session $session, array $restaurants)
{ ?>
  <section class="restaurants-search">
    <?php
    foreach ($restaurants as $restaurant) {
      output_restaurant_card_mini($db, $session, $restaurant);
    }
    ?>
  </section>
<?php } ?>


<?php
function output_dish(PDO $db, Session $session, Dish $dish)
{ ?>
  <section class="dish">
    <?php output_dish_photo($db, $session, $dish, 'mini'); ?>
    <div>
      <h3><?php echo $dish->name ?></h3>
      <?php
      if ($session->isLoggedIn()) { ?>
        <div class="fav-dish-form">
          <?php
          $db = getDatabaseConnection();
          if (User::isFavoriteDish($db, $session->getId(), $dish->idDish)) {
          ?>
            <button class="favorite-button favorite-active">
            <?php } else { ?>
              <button class="favorite-button">
              <?php } ?>
              <i class="material-symbols-rounded">favorite</i>
              </button>
              <input type="hidden" name="id" value="<?php echo $dish->idDish ?>">
              <input type="hidden" name="idRestaurant" value="<?php echo $dish->idRestaurant ?>">
              <input type="hidden" name="type" value="dish">
        </div>
      <?php } ?>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price ?>???</p>
    <?php if ($session->isLoggedIn()) { ?>
      <button class="open-add-card">
        <i class="material-symbols-rounded">add</i>
      </button>
      <div class="add-card" style="display: none">
        <div class="add-content card">
          <button class="close-add">
            <i class="material-symbols-rounded">close</i>
          </button>
          <h3><?php echo $dish->name ?></h3>
          <h4><?php echo $dish->description ?></h4>
          <input type="number" name="quantity" min="1" value="1">
          <br>
          <button class="add-to-cart">Add to Cart</button>
          <input type="hidden" name="idDish" value="<?php echo $dish->idDish ?>">
        </div>
      </div>
    <?php } else { ?>
      <button class="open-add-card login-redirect">
        <i class="material-symbols-rounded">add</i>
      </button>
    <?php } ?>
  </section>
<?php } ?>


<?php

function output_dish_category(PDO $db, $session, string $category, int $idRestaurant)
{
?><section class="category-section" id=<?= rawurlencode($category) ?>>
    <?php
    $dishes = Dish::getRestaurantDishesByCategory($db, $category, $idRestaurant);

    echo '<h2>' . ucwords($category) . '</h2><hr>';

    foreach ($dishes as $dish) {
      output_dish($db, $session, $dish);
    }
    ?></section><?php
              } ?>

<?php
function output_favorite_dish(Dish $dish, $session)
{ ?>
  <section class="dish">
    <div>
      <h3>
        <a href=<?php echo "\"../pages/restaurant.php?id=$dish->idRestaurant\">";
                echo $dish->name; ?> </a>
      </h3>
      <?php
      if ($session->isLoggedIn()) { ?>
        <div class="fav-dish-form">
          <?php
          $db = getDatabaseConnection();
          if (User::isFavoriteDish($db, $session->getId(), $dish->idDish)) {
          ?>
            <button class="favorite-button favorite-active">
            <?php } else { ?>
              <button class="favorite-button">
              <?php } ?>
              <i class="material-symbols-rounded">favorite</i>
              </button>
              <input type="hidden" name="id" value="<?php echo $dish->idDish ?>">
              <input type="hidden" name="idRestaurant" value="<?php echo $dish->idRestaurant ?>">
              <input type="hidden" name="type" value="dish">
        </div>
      <?php } ?>
      <h4><?php echo $dish->description ?></h4>
    </div>
  </section>
<?php } ?>

<?php
function output_review(Session $session, Review $review)
{ ?>
  <?php
  $db = getDataBaseConnection();
  $user = User::getUserById($db, $review->idUser);
  ?>
  <section class="review">
    <div class="review-title">
      <img src="https://picsum.photos/50/50" alt="">
      <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
      <h4><?php echo $review->rating ?></h4>
      <i class="material-symbols-rounded">star</i>
      <p>&#183;</p>
    </div>
    <p><?php echo $review->fullText ?></p>
    <?php
    if ($session->isOwnerRestaurant($review->idRestaurant)) { ?>
      <div class='comment'>
        <button id='comment' class='comment'>Comment</button>
      </div>
    <?php } ?>
  </section>
<?php } ?>



<?php
function output_restaurant_card(PDO $db, Restaurant $restaurant, Session $session)
{
  $categories = Dish::getDishCategories($db, $restaurant->id);
  $reviews = Review::getRestaurantReviews($db, intval($restaurant->id));
  $average = Restaurant::getAverage($db, intval($restaurant->id));
?>
  <article id="restaurant" class="card">
    <header>
      <?php output_restaurant_photo($db, $session, $restaurant, 'medium'); ?>
      <div id="restaurant-header-text">
        <h3><?=htmlspecialchars($restaurant->name)?></h3>
        <h4> &#183; <?php echo "$average" ?></h4>
        <i class="material-symbols-rounded">star</i>
        <?php if (Restaurant::getRestaurantOwner($db, $restaurant->id) == $session->getId()) { ?>
          <span title="owner view">
            <a href="../pages/owner_view.php?id=<?=urlencode(strval($restaurant->id))?>">
              <i class="material-icons">work</i>
            </a>
          </span>
        <?php } ?>
        <br>
        <i class="material-icons">place</i>
        <p><?php echo $restaurant->address ?></p>
        <br>
        <p class="category"><?php echo $restaurant->category ?></p>
        <br>
        <p id="opening-time"><?php echo substr($restaurant->opens, 0, 5) ?></p>
        <p id="closing-time"><?php echo substr($restaurant->closes, 0, 5) ?></p>
      </div>
      <?php
      if ($session->isLoggedIn()) { ?>
        <div id="form-favorite">
          <?php
          $db = getDatabaseConnection();
          if (User::isFavoriteRestaurant($db, $session->getId(), $restaurant->id)) {
          ?>
            <button class="favorite-button favorite-active">
            <?php } else { ?>
              <button class="favorite-button">
              <?php } ?>
              <i class="material-symbols-rounded">favorite</i>
              </button>
              <input type="hidden" name="idRestaurant" value="<?php echo $restaurant->id ?>">
              <input type="hidden" name="type" value="restaurant">
        </div>
      <?php } ?>
    </header>
    <div id="tabs">
      <button id="menu-button" class="restaurant-button" onclick="openRestaurantTab(event, 'restaurant-menu')">
        Menu
      </button>
      <button class="restaurant-button" onclick="openRestaurantTab(event, 'restaurant-reviews')">
        Reviews
      </button>
      <button class="restaurant-button" onclick="openRestaurantTab(event, 'restaurant-about')">
        About
      </button>
    </div>
    <article id="restaurant-menu" class="restaurant-tab">
      <?php
      foreach ($categories as $category) {
        output_dish_category($db, $session, $category, $restaurant->id);
      }
      ?>
    </article>
    <article id="restaurant-reviews" class="restaurant-tab">
    <?php if ($session->isLoggedIn()) { ?>
      <button class="open-add-card">
        Add review
      </button>
      <div class="add-review-card" style="display: none">
        <div class="add-content card">
          <button class="close-add">
            <i class="material-symbols-rounded">close</i>
          </button>
          <h2>Add a Review</h2>
          <input type="number" name="rating" min="0" max="10">
          <textarea name="text" rows="5" cols="60"></textarea>
          <button class="add-review">Review</button>
          <input type="hidden" name="idRestaurant" value="<?php echo $restaurant->id ?>">
        </div>
      </div>
    <?php }
      if (count($reviews) == 0) { ?>
        <p>No reviews here yet!</p>
      <?php } else {
        foreach ($reviews as $review) {
          output_review($session, $review);
        }
      }
      ?>
    </article>
    <section id="restaurant-about" class="restaurant-tab">
      <?php
      $address_url = rawurlencode($restaurant->address);
      echo "<iframe width='425' height='350' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q={$address_url}&amp;output=embed'></iframe>";
      ?>
    </section>
    <section id="side-section">
      <div id="ratings">
        <?php if ($average != null) { ?>
          <h2><?php echo "$average" ?></h2>
          <h4><?= count($reviews) ?> reviews</h4>
        <?php } ?>
      </div>
      <nav>
        <?php
        foreach ($categories as $category) { ?>
          <a href="#<?= rawurlencode($category) ?>"><?= ucwords($category) ?></a>
        <?php } ?>
      </nav>
    </section>
  </article>
<?php } ?>






<!-- EDIT SECTION -->


<?php
function output_edit_restaurant_form(PDO $db, Session $session, Restaurant $restaurant)
{
?>
  <div class="account">
    <form action="../actions/action_edit_restaurant.php?id=<?=urlencode(strval($restaurant->id))?>" method="post">
      <input type="hidden" name="csrf" value="<?=$session->getCSRF()?>">
      <label for="name">Name:</label>
      <input id="name" type="text" name="name" value="<?= $restaurant->name ?>">

      <label for="opens">Opens:</label>
      <input id="opens" type="time" name="opens" min=00:00 max=23:59 value="<?= $restaurant->opens ?>">

      <label for="closes">Closes:</label>
      <input id="closes" type="time" name="closes" min=00:00 max=23:59 value="<?= $restaurant->closes ?>">

      <label for="category">Category:</label>
      <select name="category" id="category">
        <option value="" selected disabled hidden>Choose here</option>
        <option value="Super market">Super Market</option>
        <option value="grill">Grill</option>
        <option value="Fast Food">Fast Food</option>
        <option value="pretzels">Pretzels</option>
        <option value="Ice cream">Ice Creams</option>
        <option value="american">American</option>
        <option value="pizza">Pizza</option>
        <option value="Sea food">Sea Food</option>
        <option value="italian">Italian</option>
        <option value="donuts">Donuts</option>
        <option value="caffee">Caffee House</option>
        <option value="sandwiches">Sandwiches</option>
        <option value="juice">Juices</option>
        <option value="steakhouse">Steakhouse</option>
        <option value="Fast casual">Fast Casual</option>
        <option value="mexican">Mexican</option>
        <option value="bar">Bar</option>
      </select>

      <label for="address">Address:</label>
      <input id="address" type="text" name="address" value="<?= $restaurant->address ?>">

      <button type="submit">Save</button>
    </form>
  </div>
<?php } ?>


<?php
function output_owner_restaurant_card(PDO $db, Session $session, Restaurant $restaurant, array $dishes, array $reviews, ?float $average)
{ ?>
  <article id="restaurant" class="card">
    <header>
      <?php output_restaurant_photo($db, $session, $restaurant, 'medium'); ?>
      <div id="restaurant-header-text">
        <h3><?php echo "$restaurant->name" ?></h3>
        <h4> &#183; <?php echo "$average" ?></h4>
        <i class="material-symbols-rounded">star</i>
        <span title="user view">
          <a href="../pages/restaurant.php?id=<?=urlencode(strval($restaurant->id))?>">
            <i class="material-icons">person</i>
          </a></span>
        <span title="edit details">
          <a href="../pages/edit_restaurant.php?id=<?=urlencode(strval($restaurant->id))?>">
            <i class="material-icons">edit</i>
          </a>
        </span>
        <br>
        <i class="material-icons">place</i>
        <p><?php echo $restaurant->address ?></p>
        <br>
        <p class="category"><?php echo $restaurant->category ?></p>
        <br>
        <p id="opening-time"><?php echo substr($restaurant->opens, 0, 5) ?></p>
        <p id="closing-time"><?php echo substr($restaurant->closes, 0, 5) ?></p>
      </div>
      <form action="../actions/action_delete_restaurant.php?id=<?=urlencode(strval($restaurant->id))?>" method="post" class="restaurant" id="restaurant-delete">
        <button name=delete class="restaurant">
          <i class="material-icons">delete</i>
        </button>
      </form>
    </header>
    <section class="edit-photo">
      <form action="../actions/action_upload_photo.php" method="post" enctype="multipart/form-data">
        <label class="input-photo">
          <i class="material-icons">add_photo_alternate</i>
          <input type="hidden" name="id_restaurant" value="<?= $restaurant->id ?>">
          <input type="file" name="restaurant_image">
        </label>
        <label class="upload">
          <input type="submit" value="Upload">
          <i class="material-icons">upload_file</i>
        </label>
      </form>
      <form action="../actions/action_delete_restaurant_photo.php?id=<?= $restaurant->id ?>" method="post">
        <button name="delete" class="remove-photo">
          <i class="material-icons">delete</i>
        </button>
      </form>
    </section>
    <div id="tabs">
      <button id="menu-button" class="restaurant-button" onclick="openRestaurantTab(event, 'restaurant-menu')">
        Menu
      </button>
      <button class="restaurant-button" onclick="openRestaurantTab(event, 'restaurant-orders')">
        Orders
      </button>
    </div>
    <article id="restaurant-menu" class="restaurant-tab">
      <div id="add-meal">
        <a href="../pages/add_dish.php?id=<?=urlencode(strval($restaurant->id))?>">
          <button name="add" class="add_meal">
            <i class="material-icons">add_circle</i>
          </button>
        </a>
      </div>
      <?php
      foreach ($dishes as $dish) {
        output_edit_dish($db, $session, $dish);
      }
      ?>
    </article>
    <article id="restaurant-orders" class="restaurant-tab">
      <?php
      $orders = Restaurant::getRestaurantOrders($db, $restaurant->id);
      if (count($orders) == 0) { ?>
        <h3 class="empty">Nothing here!</h3>
      <?php }
      foreach ($orders as $order) {
        $dishes = Dish::getOrderDishes($db, $order);
        $user = User::getOrderUser($db, $order);
        output_restaurant_order($order, $dishes, $user);
      }
      ?>
    </article>
  </article>
<?php } ?>


<?php
function output_edit_dish(PDO $db, Session $session, Dish $dish)
{ ?>
  <section class="dish">
    <div class="edit-photo">
      <form action="../actions/action_upload_dish_photo.php" method="post" enctype="multipart/form-data">
        <label class="input-photo">
          <i class="material-icons">add_photo_alternate</i>
          <input type="hidden" name="id_dish" value="<?= $dish->idDish ?>">
          <input type="file" name="dish_image">
        </label>
        <label class="upload">
          <input type="submit" value="Upload">
          <i class="material-icons">upload_file</i>
        </label>
      </form>
      <form action="../actions/action_delete_dish_photo.php?id=<?= $dish->idDish ?>" method="post">
        <button name=delete class="remove-photo">
          <i class="material-icons">delete</i>
        </button>
      </form>
    </div>
    <?php output_dish_photo($db, $session, $dish, 'mini'); ?>
    <div>
      <h3><?php echo $dish->name ?></h3>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price ?>???</p>
    <a href="../pages/edit_dish.php?id=<?=urlencode(strval($dish->idDish))?>"
      <button name=delete class="delete_meal">
        <i class="material-icons">edit</i>
      </button>
    </a>
    <form action="../actions/action_delete_dish.php?id=<?=urlencode(strval($dish->idDish))?>" method="post" class="dish">
      <button name=delete class="delete_meal">
        <i class="material-icons">delete</i>
      </button>
    </form>

  </section>
<?php } ?>


<?php
function output_edit_dish_form(PDO $db, Session $session, Dish $dish)
{
?>
  <div class="account">
    <form action="../actions/action_edit_dish.php?id=<?=urlencode(strval($dish->idDish))?>" method="post">
      <input type="hidden" name="csrf" value="<?=$session->getCSRF()?>">
      <label for="name">Name:</label>
      <input id="name" type="text" name="name" value="<?= $dish->name ?>">

      <label for="description">Description:</label>
      <input id="description" type="text" name="description" value="<?= $dish->description ?>">

      <label for="price">Price:</label>
      <input id="price" type="number" name="price" min="0.00" max="10000.00" step="0.01" value="<?= $dish->price ?>">


      <label for="category">Category:</label>
      <select name="category" id="category">
        <option value="" selected disabled hidden>Choose here</option>
        <option value="Beverages">Beverages</option>
        <option value="Pizza">Pizza</option>
        <option value="Sandwiches">Sandwiches</option>
        <option value="Burgers">Burgers</option>
        <option value="Salads">Salads</option>
        <option value="Appetizers & Sides">Appetizers & Sides</option>
        <option value="Baked Goods">Baked Goods</option>
        <option value="Desserts">Desserts</option>
        <option value="Soup">Soup</option>
        <option value="Toppings & Ingredients">Toppings & Ingredients</option>
        <option value="Fried Potatoes">Fried Potatoes</option>
        <option value="Entrees">Entrees</option>
      </select>

      <button type="submit">Save</button>
    </form>
  </div>
<?php } ?>


<?php
function output_add_dish_form(PDO $db, Session $session, Restaurant $restaurant)
{
?>
  <div class="account">
    <form action="../actions/action_add_dish.php?id=<?= $restaurant->id ?>" method="post">
      <input type="hidden" name="csrf" value="<?=$session->getCSRF()?>">
      <input id="name" type="text" name="name" placeholder="Name">
      <input id="description" type="text" name="description" placeholder="Description">
      <input id="price" type="number" name="price" placeholder="Price" min="0.00" max="100000.00" step="0.01">

      <label for="category">Category:</label>
      <select name="category" id="category">
        <option value="" selected disabled hidden>Choose here</option>
        <option value="Beverages">Beverages</option>
        <option value="Pizza">Pizza</option>
        <option value="Sandwiches">Sandwiches</option>
        <option value="Burgers">Burgers</option>
        <option value="Salads">Salads</option>
        <option value="Appetizers & Sides">Appetizers & Sides</option>
        <option value="Baked Goods">Baked Goods</option>
        <option value="Desserts">Desserts</option>
        <option value="Soup">Soup</option>
        <option value="Toppings & Ingredients">Toppings & Ingredients</option>
        <option value="Fried Potatoes">Fried Potatoes</option>
        <option value="Entrees">Entrees</option>
      </select>

      <button type="submit">Add dish</button>
    </form>
  </div>
<?php } ?>


<?php
function output_register_restaurant_form(PDO $db, Session $session)
{
?>

  <div class="account">
    <form action="../actions/action_register_restaurant.php" method="post" class="profile">
      <input type="hidden" name="csrf" value="<?=$session->getCSRF()?>">

      <input id="name" type="text" name="name" placeholder="Name">

      <label for="opens">Opens:</label>
      <input id="opens" type="time" name="opens" min=00:00 max=23:59>

      <label for="closes">Closes:</label>
      <input id="closes" type="time" name="closes" min=00:00 max=23:59>

      <select name="category" id="category">
        <option value="" selected disabled hidden>Category</option>
        <option value="Super market">Super Market</option>
        <option value="grill">Grill</option>
        <option value="Fast Food">Fast Food</option>
        <option value="pretzels">Pretzels</option>
        <option value="Ice cream">Ice Creams</option>
        <option value="american">American</option>
        <option value="pizza">Pizza</option>
        <option value="Sea food">Sea Food</option>
        <option value="italian">Italian</option>
        <option value="donuts">Donuts</option>
        <option value="caffee">Caffee House</option>
        <option value="sandwiches">Sandwiches</option>
        <option value="juice">Juices</option>
        <option value="steakhouse">Steakhouse</option>
        <option value="Fast casual">Fast Casual</option>
        <option value="mexican">Mexican</option>
        <option value="bar">Bar</option>
      </select>

      <input id="address" type="text" name="address" placeholder="Address">

      <button type="submit">Register restaurant</button>
    </form>
  </div>


<?php } ?>


<?php function output_restaurant_photo(PDO $db, Session $session, Restaurant $restaurant, string $size)
{
  if (isset($restaurant->photo)) { ?>
    <img src="../photos/restaurants/<?= $size ?>/<?= $restaurant->photo ?>" alt="<?= $restaurant->name ?> photo">
  <?php } else { ?>
    <img src="../photos/defaults/restaurants/<?= $size ?>/<?= $restaurant->category ?>.jpg" alt="Restaurant's photo">
  <?php  } ?>
<?php } ?>

<?php function output_dish_photo(PDO $db, Session $session, Dish $dish, string $size)
{
  if (isset($dish->photo)) { ?>
    <img src="../photos/dishes/<?= $size ?>/<?= $dish->photo ?>" alt="<?= $dish->name ?> photo">
  <?php } else { ?>
    <img src="../photos/defaults/dishes/bread.jpg" alt="Dish photo">
  <?php  } ?>
<?php } ?>
<?php
declare(strict_types = 1); ?>

<?php
  
  require_once(__DIR__ . '/../utils/session.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once(__DIR__ . '/../database/review.class.php');
  require_once(__DIR__ . '/../database/dish.class.php');

function output_restaurant_card_nano(Restaurant $restaurant)
{ ?>
  <a href="../pages/restaurant.php?id=<?=$restaurant->id?>" class="restaurant-nano">
    <img src="https://picsum.photos/id/101/250/150" alt="">
    <div class="nano-text">
      <h3><?php echo $restaurant->name ?></h3>
      <h4><?php echo $restaurant->address ?></h4>
    </div>
  </a>
<?php } 

function output_restaurant_slide(array $restaurants)
{
?>
  <section class="slide">
    <h2>Section Title</h2>
    <div class="slide-content">
      <?php
      foreach ($restaurants as $restaurant) { 
        output_restaurant_card_nano($restaurant); 
      }
      ?>
    </div>
  </section>
<?php
} ?>

<?php
function output_restaurant_card_mini(int $id)
{ ?>
  <a href="../pages/restaurant.php" class="restaurant-mini">
    <img src="https://picsum.photos/id/101<?php echo $id ?>/200/200" alt="">
    <div class="mini-text">
      <h3>Restaurant</h3>
      <h4>Location</h4>
      <p>Adress</p>
      <p>Rating</p>
      <p>Preço</p>
    </div>
  </a>
<?php } ?>

<?php
function output_restaurant_search()
{ ?>
  <section class="restaurants-search">
    <?php
    for ($i = 0; $i < 5; $i++) {
      output_restaurant_card_mini($i);
    }
    ?>
  </section>
<?php } ?>

<?php
function output_dish(Dish $dish, $session)
{ ?>
  <section class="dish">
    <div>
      <h3><?php echo $dish->name ?></h3>
      <?php
      if ($session->isLoggedIn()) { ?>
        <form class="fav-dish-form" action="../actions/action_favorite.php" method="post">
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
          <input type="hidden" name="id" value="<?php echo $dish->idDish?>">
          <input type="hidden" name="idRestaurant" value="<?php echo $dish->idRestaurant?>">
          <input type="hidden" name="type" value="dish">
        </form>
      <?php } ?>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price?>€</p>
    <form action="" method="post">
      <button class="add-to-cart">+</button>
    </form>
  </section>
<?php } ?>


<?php
function output_favorite_dish(Dish $dish, $session)
{ ?>
  <section class="dish">
    <div>
      <h3>
        <a href=<?php echo "\"../pages/restaurant.php?id=$dish->idRestaurant\">";
          echo $dish->name; ?>
        </a>
      </h3>
      <?php
      if ($session->isLoggedIn()) { ?>
        <form class="fav-dish-form" action="../actions/action_favorite.php" method="post">
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
          <input type="hidden" name="id" value="<?php echo $dish->idDish?>">
          <input type="hidden" name="idRestaurant" value="<?php echo $dish->idRestaurant?>">
          <input type="hidden" name="type" value="dish">
        </form>
      <?php } ?>
      <h4><?php echo $dish->description ?></h4>
    </div>
  </section>
<?php } ?>

<?php
function output_review(Review $review)
{ ?>
  <?php
    $db = getDataBaseConnection();
    $user = User::getUserById($db, $review->idUser);
  ?>
  <section class="review">
    <div class="review-title">
      <img src="https://picsum.photos/50/50" alt="">
      <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
      <h4><?php echo $review->rating?></h4>
      <i class="material-symbols-rounded">star</i>
      <p>&#183;</p>
    </div>
    <p><?php echo $review->fullText ?></p>
    <a class="add-comment">Comment</a>
  </section>
<?php } ?>



<?php
function output_restaurant_card(PDO $db, Restaurant $restaurant, Session $session)
{ 
  $dishes = Dish::getRestaurantDishes($db, intval($restaurant->id));
  $reviews = Review::getRestaurantReviews($db, intval($restaurant->id));
  $average = Restaurant::getAverage($db, intval($restaurant->id));
  ?>

  <article id="restaurant">
    <header>
      <img src="https://picsum.photos/500/300" alt="Restaurant's photo">
      <div id="restaurant-header-text">
        <h3><?php echo "$restaurant->name"?></h3>
        <h4>	&#183; <?php echo "$average"?></h4>
        <i class="material-symbols-rounded">star</i>
        <?php if(Restaurant::getRestaurantOwner($db, $restaurant->id) == $session->getId()) {?>
          <span title="owner view">
          <a href="../pages/owner_view.php?id=<?=$restaurant->id?>"><i class="material-icons">work</i></a>
          </span>
    <?php } ?>
        <br>
        <i class="material-icons">place</i>
        <p><?php echo $restaurant->address ?></p>
        <br>
        <p><?php echo $restaurant->category?></p>
      </div>
    </header>
    <?php
    if ($session->isLoggedIn()) { ?>
      <form id="form-favorite" action="../actions/action_favorite.php" method="post">
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
        <input type="hidden" name="idRestaurant" value="<?php echo $restaurant->id?>">
        <input type="hidden" name="type" value="restaurant">
      </form>
    <?php } ?>
    <div id="tabs">
      <button 
        id="menu-button"
        class="restaurant-button"
        onclick="openRestaurantTab(event, 'restaurant-menu')">
        Menu
      </button>
      <button
        class="restaurant-button"
        onclick="openRestaurantTab(event, 'restaurant-reviews')">
        Reviews
      </button>
      <button 
        class="restaurant-button"
        onclick="openRestaurantTab(event, 'restaurant-about')">
        About
      </button>
    </div>
    <article id="restaurant-menu" class="restaurant-tab">
      <?php
      foreach ($dishes as $dish) {
        output_dish($dish, $session);
      }
      ?>
    </article>
    <article id="restaurant-reviews" class="restaurant-tab">
      <?php
      if (count($reviews) == 0) { ?>
        <p>No reviews here yet!</p>
      <?php }
      else {
        foreach ($reviews as $review) {
          output_review($review);
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
      <div id="promotion">
        <p>100% off today</p>
      </div>
      <div id="ratings">
        <?php if ($average != null) {?> 
          <h4><?php echo "$average"?>/10</h4>
          <?php } ?>
      </div>
    </section>
  </article>
<?php } ?>






<!-- EDIT SECTION -->


<?php
  function output_edit_restaurant_form(PDO $db, Session $session, Restaurant $restaurant) {
?>
<article id="restaurant">
<header>
      <img src="https://picsum.photos/500/300" alt="Restaurant's photo">
      <form action="../actions/action_edit_restaurant.php?id=<?=$restaurant->id?>" method="post" class="restaurant">
      <label for="name">Name:</label>
      <input id="name" type="text" name="name" value="<?=$restaurant->name?>">
      
      <label for="opens">Opens:</label>
      <input id="opens" type="time" name="opens" min=00:00 max=23:59 value="<?=$restaurant->opens?>">  

      <label for="closes">Closes:</label>
      <input id="closes" type="time" name="closes" min=00:00 max=23:59 value="<?=$restaurant->closes?>">  
      
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
      <input id="address" type="text" name="address" value="<?=$restaurant->address?>">  

      <button type="submit">Save</button>
    </form>
    </header>
  </article>
    <?php } ?>


<?php
function output_owner_restaurant_card(PDO $db, Session $session, Restaurant $restaurant, array $dishes, array $reviews, ?float $average)
{ ?>
  <article id="restaurant">
    <header>
      <img src="https://picsum.photos/500/300" alt="Restaurant's photo">
      <div id="restaurant-header-text">
        <h3><?php echo "$restaurant->name"?></h3>
        <h4>	&#183; <?php echo "$average"?></h4>
        <i class="material-symbols-rounded">star</i>
        <span title="user view"> <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><i class="material-icons">person</i></a></span>
        <span title="edit details"><a href="../pages/edit_restaurant.php?id=<?=$restaurant->id?>"><i class="material-icons">edit</i></a></span>
        <br>
        <i class="material-icons">place</i>
        <p><?php echo $restaurant->address ?></p>
        <br>
        <p><?php echo $restaurant->category?></p>
      </div>
    </header>
    <div id="tabs">
      <button 
        id="menu-button"
        class="restaurant-button"
        onclick="openRestaurantTab(event, 'restaurant-menu')">
        Menu
      </button>
    </div> 
    <article id="restaurant-menu" class="restaurant-tab">
      <?php
      foreach ($dishes as $dish) {
        output_edit_dish($dish);
      }
      ?>
    </article>
<?php } ?>


<?php
function output_edit_dish(Dish $dish)
{ ?>
  <section class="meal">
    <div>
      <h3><?php echo $dish->name ?></h3>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price?>€</p>
    <a href="../pages/edit_dish.php?id=<?=$dish->idDish?>"><button name=edit class="edit_meal"><i class="material-icons">edit</i></button></a>
    <form action="" method="post">
        <button name=delete class="delete_meal"><i class="material-icons">delete</i></button>
    </form>
    
  </section>
<?php } ?>


<?php
  function output_edit_dish_form(PDO $db, Session $session, Dish $dish) {
?>
<article id="restaurant">
  <section class="dish">
    <div>
      <h3><?php echo $dish->name ?></h3>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <p><?php echo $dish->price?>€</p>
  </section>
    <?php } ?>
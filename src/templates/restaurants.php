<?php
declare(strict_types=1); ?>

<?php
  
  require_once('database/connection.db.php');
  require_once('database/user.class.php');

function output_restaurant_card_nano(Restaurant $restaurant)
{ ?>
  <a href="restaurant.php?id=<?=$restaurant->id?>" class="restaurant-nano">
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
  <a href="restaurant.php" class="restaurant-mini">
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
function output_meal(Dish $dish)
{ ?>
  <section class="meal">
    <div>
      <h3><?php echo $dish->name ?></h3>
      <h4><?php echo $dish->description ?></h4>
    </div>
    <form action="" method="post">
      <button class="add_to_cart">+</button>
    </form>
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
    </div>
    <p><?php echo $review->fullText ?></p>
    <a class="add-comment">Comment</a>
  </section>
<?php } ?>

<?php
function output_restaurant_card(Restaurant $restaurant, array $dishes, array $reviews)
{ ?>
  <article id="restaurant">
    <header>
      <img src="https://picsum.photos/500/300" alt="">
      <div class="restaurant-text">
        <h3><?php echo $restaurant->name ?></h3>
      </div>
    </header>
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
        output_meal($dish);
      }
      ?>
    </article>
    <article id="restaurant-reviews" class="restaurant-tab">
      <?php
      foreach ($reviews as $review) {
        output_review($review);
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
        Add the score card here.
      </div>
      <div id="user_photos">
        <img src="https://picsum.photos/200/300" alt="">
      </div>
    </section>
  </article>
<?php } ?>
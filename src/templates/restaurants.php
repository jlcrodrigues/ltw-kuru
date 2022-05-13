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
  <img src="https://picsum.photos/id/10>/300/300" alt="">
  <h3><?php echo $dish->name ?></h3>
  <h4><?php echo $dish->description ?></h4>
  <form action="" method="post">
    <button class="add_to_cart">+</button>
  </form>
<?php } ?>

<?php
function output_review(Review $review)
{ ?>
  <?php
    $db = getDataBaseConnection();
    $user = User::getUserById($db, $review->idUser);
  ?>
  <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
  <h4><?php echo $review->rating ?></h4>
  <p><?php echo $review->fullText ?></p>
  <form action="" method="post">
    <button class="add_comment">Comment</button>
  </form>
<?php } ?>

<?php
function output_restaurant_card(Restaurant $restaurant, array $dishes, array $reviews)
{ ?>
  <article class="restaurant">
    <header>
      <img src="https://picsum.photos/500/300" alt="">
      <div class="restaurant-text">
        <h3><?php echo $restaurant->name ?></h3>
      </div>
    </header>
    <form action="" method="post">
      <button class="restaurant_section">Menu</button>
      <button class="restaurant_section">Reviews</button>
      <button class="restaurant_section">About</button>
    </form>
    <section id="menu">
      <?php
      foreach ($dishes as $dish) {
        output_meal($dish);
      }
      ?>
    </section>
    <section id="reviews">
      <h1>Reviews</h1>
      <?php
      foreach ($reviews as $review) {
        output_review($review);
      }
      ?>
    </section>
    <section id="about">
      <h3>This is the about section</h3>
      <p>Location: <?php echo $restaurant->address ?></p>
      <p>Optional text by the owner</p>
    </section>
    <section id="promotion">
      <p>100% off today</p>
    </section>
    <section id="ratings">
      Add the score card here.
    </section>
    <section id="user_photos">
      <img src="https://picsum.photos/200/300" alt="">
    </section>
  </article>
<?php } ?>
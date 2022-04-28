<?php

declare(strict_types=1); ?>

<?php
function output_restaurant_card_nano(int $id)
{ ?>
  <a href="../pages/restaurant_page.php" id="restaurant">
    <img src="https://picsum.photos/id/10<?php echo $id ?>/300/300" alt="">
    <h3>Restaurant</h3>
    <h4>Location</h4>
  </a>
<?php }

function output_restaurant_slide()
{
?>
  <section id="slide">
    <?php
    for ($i = 0; $i < 5; $i++) {
      output_restaurant_card_nano($i);
    }
    ?>
  </section>
<?php
} ?>

<?php
function output_restaurant_card_mini(int $id)
{ ?>
  <a href="../pages/restaurant_page.php" id="restaurant">
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
      output_restaurant_card_mini($i);
    }
    ?>
  </section>
<?php } ?>

<?php
function output_meal($id)
{ ?>
  <img src="https://picsum.photos/id/10<?php echo $id ?>/300/300" alt="">
  <h3>Meal</h3>
  <h4>This is a meal</h4>
  <form action="" method="post">
    <button class="add_to_cart">+</button>
  </form>
<?php } ?>

<?php
function output_review($id)
{ ?>
  <h3>Username</h3>
  <h4>This is a review</h4>
  <p>This is still a review</p>
  <form action="" method="post">
    <button class="add_comment">Comment</button>
  </form>
<?php } ?>

<?php
function output_restaurant_card(int $id)
{ ?>
  <section id="restaurant">
    <header>
      <img src="https://picsum.photos/500/300" alt="">
      <h3>Restaurant</h3>
    </header>
    <form action="" method="post">
      <button class="restaurant_section">Menu</button>
      <button class="restaurant_section">Reviews</button>
      <button class="restaurant_section">About</button>
    </form>
    <section id="menu">
      <?php
      for ($i = 0; $i < 5; $i++) {
        output_meal($i);
      }
      ?>
    </section>
    <section id="reviews">
      <?php
      for ($i = 0; $i < 5; $i++) {
        output_review($i);
      }
      ?>
    </section>
    <section id="about">
      <h3>This is the about section</h3>
      <p>Address</p>
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
  </section>
<?php } ?>
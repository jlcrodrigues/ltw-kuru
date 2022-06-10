<?php

declare(strict_types=1);

require_once("restaurants.php");
?>

<?php
function output_favorites(array $restaurants, array $dishes, $session)
{ ?>
  <section id="favorites">
    <header>
      <h1>Favorites</h1>
      <div id=favorites-tabs>
        <button 
          id="favorite-button-tab"
          class="favorites-section-button" 
          onclick="openFavoritesTab(event, 'favorite-restaurants')">
          Restaurants
        </button>
        <button 
          class="favorites-section-button" 
          onclick="openFavoritesTab(event, 'favorite-meals')">
          Meals
        </button>
      </div>
    </header>

    <body>
      <article class="favorites-section" id="favorite-restaurants">
        <div>
          <?php 
          if (count($restaurants) == 0) { 
            output_empty_fav();
          }
          foreach ($restaurants as $restaurant) {
            output_restaurant_card_nano($restaurant);
          } ?>
        </div>
      </article>
      <article class="favorites-section" id="favorite-meals">
      <?php
        if (count($dishes) == 0) { 
          output_empty_fav();
        }
        foreach ($dishes as $dish) {
          output_favorite_dish($dish, $session);
        } ?>
      </article>
    </body>
  </section>

<?php } ?>

<?php
function output_empty_fav() { ?>
  <h3 class="empty">
    Nothing here. 
    <a href="search.php">Search </a>
    restaurants.
  </h3>
<?php } ?>

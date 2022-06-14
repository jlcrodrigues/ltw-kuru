<?php

declare(strict_types=1);

function output_search_bar($query = NULL)
{

  $isIndex = $_SERVER['REQUEST_URI'] === '/pages/index.php';
  ?>
  <form method="post" id="search-box" <?= $isIndex ? "action='search.php'" : '' ?>>
    <div>
      <input id="search-restaurant" type="text" name="search" placeholder="Search" value="<?= $query ?>">
      <button type="submit">
        <i class="material-icons icon-4x">search</i>
      </button>
    </div>
  </form>
<?php
}

function output_search_filter(PDO $db)
{ ?>
  <form id="search-filter" class="card" action="search.php" method="post">
    <label for="rating">Rating:<br></label>
    <label>
      <input class="filter-rating" type="checkbox" value="low-rating">
      2.5 or more
    </label><br>
    <label>
      <input class="filter-rating" type="checkbox" value="mid-rating">
      3.5 or more
    </label><br>
    <label>
      <input class="filter-rating" type="checkbox" value="high-rating">
      5.0 or more
    </label><br><br>
    <?php $categories = Restaurant::getCategories($db);?>
    <label for="category">Category:<br></label>
    <?php     foreach ($categories as $category){ ?>
      <label><input class="filter-category" type="checkbox" name='selected_categories[]' value=<?=$category?> >
      <?=$category?></label><br>

   <?php }
   ?></form>
<?php }?>
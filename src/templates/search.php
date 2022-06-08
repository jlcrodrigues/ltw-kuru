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

function output_search_filter()
{ ?>
  <form id="search-filter" class="card" action="search_filter.php" method="post">
    <label for="rating">Rating:<br></label>
    <label>
      <input type="number" name="number">
    </label>
    <br>
    <label for="category">Category:<br></label>
    <label>
      <input type="checkbox" name="category">

    </label>
    <label>
      <input type="checkbox" name="diet">
      Vegetarian
    </label>
  </form>
<?php } ?>
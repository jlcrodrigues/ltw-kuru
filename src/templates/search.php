<?php

declare(strict_types=1);

function output_search_bar()
{ ?>
  <form method="post" id="search-box">
    <input type="text" name="search" placeholder="Search">
    <button type="submit">
      <i class="material-icons icon-4x">search</i>
    </button>
  </form>
<?php
}

function output_search_filter()
{ ?>
  <form action="search_filter.php" method="post">
    <label for="price">Price range:<br></label>
    <label>
      <input type="checkbox" name="price">
      €
    </label>
    <label>
      <input type="checkbox" name="price">
      €€
    </label>
    <label>
      <input type="checkbox" name="price">
      €€€
    </label>
    <br>
    <label for="rating">Rating:<br></label>
    <label>
      <input type="checkbox" name="rating">
      5
    </label>
    <label>
      <input type="checkbox" name="rating">
      >= 4
    </label>
    <label>
      <input type="checkbox" name="rating">
      >= 3
    </label>
    <br>
    <label for="diet">Diet:<br></label>
    <label>
      <input type="checkbox" name="diet">
      Vegan
    </label>
    <label>
      <input type="checkbox" name="diet">
      Vegetarian
    </label>
  </form>
<?php } ?>
<?php
require_once("orders.php");
require_once("restaurants.php");
?>

<?php
function output_profile_info(User $user)
{ ?>
  <h2>Profile</h2>
  <button onclick="openProfileTab(event, 'profile-edit')">
    <i class="material-symbols-rounded">edit</i>
  </button>
  <hr>
  <i class="material-symbols-rounded">person</i>
  <p><?php echo $user->first_name . " " . $user->last_name ?></p>
  <br>
  <p>Name</p>
  <br>
  <i class="material-symbols-rounded">mail</i>
  <p><?php echo $user->email ?></p>
  <br>
  <p>Email</p>
  <br>
  <i class="material-symbols-rounded">call</i>
  <p><?php echo $user->phone ?></p>
  <br>
  <p>Phone Number</p>
  <br>
  <i class="material-symbols-rounded">home_pin</i>
  <p><?php echo $user->address ?></p>
  <br>
  <p>Address</p>
  <?php if ($user->city != null and $user->country != null) { ?>
    <br>
    <i class="material-symbols-rounded">map</i>
    <p><?= $user->city . ", " . $user->country; ?></p>
    <br>
    <p>City</p>
  <?php } ?>
  <br>
<?php } ?>

<?php
function output_profile_reviews()
{ ?>
  <h2>Reviews</h2>
  <hr>
<?php } ?>

<?php
function output_profile_orders(PDO $db, Session $session)
{
?>
  <h2>Orders</h2>
  <hr>
  <h3>Processing</h3>
  <hr>
  <?php
  $orders_id = User::getOrdersByState($db, $session->getId(), 'Processing');
  foreach ($orders_id as $id) {
    $dishes = Dish::getOrderDishes($db, $id);
    $restaurant = Restaurant::getOrderRestaurant($db, $id);
    output_order_past($id, $restaurant, $dishes);
  }
  ?>
  <h3>Completed</h3>
  <hr>
  <?php
  $orders_id = User::getOrdersByState($db, $session->getId(), 'Completed');
  foreach ($orders_id as $id) {
    $dishes = Dish::getOrderDishes($db, $id);
    $restaurant = Restaurant::getOrderRestaurant($db, $id);
    output_order_past($id, $restaurant, $dishes);
  }
  ?>
<?php } ?>

<?php
function output_profile_edit(User $user)
{ ?>
  <h2>Profile</h2>
  <button onclick="openProfileTab(event, 'profile-info')">
    <i class="material-symbols-rounded">edit</i>
  </button>
  <form action="../actions/action_edit_profile.php" method="post" class="profile">
    <hr>
    <label for="first_name">
      <i class="material-symbols-rounded">person</i>
    </label>
    <input id="first_name" type="text" name="first_name" value="<?= $user->first_name ?>">
    <br>
    <label for="first_name">Name</label>
    <br>

    <label for="last_name">
      <i class="material-symbols-rounded">person</i>
    </label>
    <input id="last_name" type="text" name="last_name" value="<?= $user->last_name ?>">
    <br>
    <label for="last_name">Last name</label>
    <br>

    <label for="email">
      <i class="material-symbols-rounded">mail</i>
    </label>
    <input id="email" type="email" name="email" value="<?= $user->email ?>">
    <br>
    <label for="email">Email</label>
    <br>

    <label for="phone">
      <i class="material-symbols-rounded">call</i>
    </label>
    <input id="phone" type="text" name="phone" value="<?= $user->phone ?>">
    <br>
    <label for="phone">Phone Number</label>
    <br>

    <label for="address">
      <i class="material-symbols-rounded">home_pin</i>
    </label>
    <input id="address" type="text" name="address" value="<?= $user->address ?>">
    <br>
    <label for="address">Address</label>
    <br>

    <label for="city">
      <i class="material-symbols-rounded">map</i>
    </label>
    <input id="city" type="text" name="city" value="<?= $user->city ?>">
    <br>
    <label for="city">City</label>
    <br>

    <label for="country">
      <i class="material-symbols-rounded">map</i>
    </label>
    <input id="country" type="text" name="country" value="<?= $user->country ?>">
    <br>
    <label for="country">Country</label>
    <br>

    <button type="submit">Save</button>
  </form>

<?php } ?>

<?php
function output_profile(Session $session)
{ ?>
  <?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once('restaurants.php');

  $db = getDataBaseConnection();
  $user = User::getUserById($db, $session->getId());
  ?>

  <section id="profile" class="card">
    <header>
      <img src="https://picsum.photos/200" alt="profile photo">
      <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
    </header>
    <div id="profile-tabs">
      <button id="profile-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-info')">
        Profile
      </button>
      <button id="reviews-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-reviews')">
        Reviews
      </button>
      <button id="orders-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-orders')">
        Orders
      </button>
      <?php if ($session->isOwner($session->getId())) { ?>
        <button id="owner-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-owner')">
          My restaurants
        </button>
      <?php } else { ?>
        <button id="not-owner-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-not-owner')">
          Become an Owner
        </button>
      <?php } ?>
      <button id="change_password-button" class="profile-section-button" onclick="openProfileTab(event, 'profile-change_password')">
        Change Password
      </button>
      <form action="../actions/action_logout.php" method="post">
        <button id="logout-button" class="profile-section-button">Logout</button>
      </form>
    </div>
    <section id="profile-info" class="profile-section">
      <?php output_profile_info($user); ?>
    </section>
    <article id="profile-reviews" class="profile-section">
      <?php output_profile_reviews(); ?>
    </article>
    <article id="profile-orders" class="profile-section">
      <?php output_profile_orders($db, $session); ?>
    </article>
    <section id="profile-change_password" class="profile-section">
      <p>Change Password</p>
    </section>
    <section id="profile-edit" class="profile-section">
      <?php output_profile_edit($user); ?>
    </section>
    <section id="profile-owner" class="profile-section">
      <h3>Restaurants <a href="../pages/register_restaurant.php"><button name=add class="add_restaurant"><i class="material-icons">add_circle</i></button></a></h3>
      <?php
      $restaurants = Restaurant::getOwnerRestaurants($db, $session->getId());

      foreach ($restaurants as $restaurant) {
        output_restaurant_card_nano($restaurant);
      }
      ?>
    </section>
    <section id="profile-not-owner" class="profile-section">
      <h3>Become a owner now!</h3>
      <?php output_register_restaurant_form($db, $session) ?>
    </section>
  </section>
<?php } ?>

<?php
function output_login()
{ ?>
  <div class="account">
    <form action="../actions/action_login.php" method="post">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="submit" class="login">Log In</button>
    </form>
    <hr>
    <a href="register.php">Create an account</a>
  </div>

<?php } ?>

<?php
function output_register()
{ ?>
  <div class="account">
    <form id="register" action="../actions/action_register.php" method="post">
      <input type="text" name="first_name" placeholder="First Name">
      <input type="text" name="last_name" placeholder="Last Name">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirm_password" placeholder="Confirm Password">
      <button type="submit" name="submit" class="login">Register</button>
    </form>
    <hr>
    <a href="login.php">I have an account</a>
  </div>
<?php
}

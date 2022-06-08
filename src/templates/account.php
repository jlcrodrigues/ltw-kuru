<?php 
require_once("orders.php");
require_once("restaurants.php");
?>
<?php
function output_profile_orders(PDO $db, Session $session) { 
  ?>
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
    <img src="https://picsum.photos/200" alt="profile photo">
    <div id="profile-tabs">
      <button 
        id="profile-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-info')">
        Profile
      </button>
      <button 
        id="reviews-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-reviews')">
        Reviews
      </button>
      <button 
        id="orders-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-orders')">
        Orders
      </button>
      <button 
        id="edit-profile-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-edit')">
        Edit Profile
      </button>
      <?php if($session->isOwner($session->getId())) { ?>
        <button 
        id="owner-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-owner')">
        My restaurants
      </button> 
      <?php } 
       else { ?>
        <button 
        id="not-owner-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-not-owner')">
        Become a Owner
      </button> 
      <?php } ?>
      <button 
        id="change_password-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-change_password')">
        Change Password
      </button>
      <form action="../actions/action_logout.php" method="post">
      <button id="logout-button" class="profile-section-button">Logout</button>
      </form>
    </div>
    <section id="profile-info" class="profile-section">
      <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
      <p><?php echo $user->email ?></p>
      <p><?php echo $user->phone ?></p>
      <p><?php echo $user->address ?></p>
      <p><?php if ($user->city != null and $user->country != null) {echo $user->city . ", " . $user->country;} 
               else {echo $user->city . $user->country;}?></p>
    </section>
    <article id="profile-reviews" class="profile-section">
      <p>Review</p>
    </article>
    <article id="profile-orders" class="profile-section">
      <h2>Orders</h2>
      <?php output_profile_orders($db, $session);?>
    </article>
    <section id="profile-change_password" class="profile-section">
      <p>Change Password</p>
    </section>
    <section id="profile-edit" class="profile-section">
      <p>Edit Profile</p>
    <form action="../actions/action_edit_profile.php" method="post" class="profile">
      <label for="first_name">First Name:</label>
      <input id="first_name" type="text" name="first_name" value="<?=$user->first_name?>">
      
      <label for="last_name">Last Name:</label>
      <input id="last_name" type="text" name="last_name" value="<?=$user->last_name?>">  

      <label for="email">Email:</label>
      <input id="email" type="email" name="email" value="<?=$user->email?>">  

      <label for="address">Address:</label>
      <input id="address" type="text" name="address" value="<?=$user->address?>">  

      <label for="city">City:</label>
      <input id="city" type="text" name="city" value="<?=$user->city?>">  
     
      <label for="country">Country:</label>
      <input id="country" type="text" name="country" value="<?=$user->country?>">  

      <label for="phone">Phone:</label>
      <input id="phone" type="text" name="phone" value="<?=$user->phone?>">  
      <button type="submit">Save</button>
    </form>
    </section>
    <section id="profile-owner" class="profile-section">
      <h3>Restaurants       <a href="../pages/register_restaurant.php"><button name=add class="add_restaurant"><i class="material-icons">add_circle</i></button></a></h3>
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
      <input type="email" name="email"  placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirm_password" placeholder="Confirm Password">
      <button type="submit" name="submit" class="login">Register</button>
    </form>
      <hr>
      <a href="login.php">I have an account</a>
  </div>
  <?php
  }


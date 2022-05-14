<?php
function output_profile(int $id)
{ ?>
  <?php
    require_once('database/connection.db.php');
    require_once('database/user.class.php');

    $db = getDataBaseConnection();
    $user = User::getUserById($db, $id);
  ?>

  <section id="profile">
    <img src="https://picsum.photos/200" alt="profile photo">
    <div id="tabs">
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
      <form action="action_logout.php" method="post">
      <button id="logout-button" class="profile-section-button">Logout</button>
      </form>
    </div>
    <section id="profile-info" class="profile-section">
      <h3><?php echo $user->first_name . " " . $user->last_name ?></h3>
      <p><?php echo $user->email ?></p>
      <p><?php echo $user->city . ", " . $user->country ?></p>
      <a href="">Change password</a>
    </section>
    <section id="profile-reviews" class="profile-section">
      <p>Review</p>
    </section>
    <section id="profile-orders" class="profile-section">
      <p>Order</p>
    </section>
  </section>

<?php } ?>

<?php
function output_login()
{ ?>
  <form action="action_login.php" method="post">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <button type="submit" name="submit" class="login">Login</button>
  </form>
  <a href="register.php">Register</a>

  <?php
    $fullUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if (strpos($fullUrl, "login=empty") == true) {
      echo "You have to fill in all fields.";
    }
    else if (strpos($fullUrl, "login=password") == true) {
      echo "Wrong email or password.";
    }
    else if (strpos($fullUrl, "login=register") == true) {
      echo "Sign up successful.";
    }
  ?>

<?php } ?>

<?php
function output_register()
{ ?>
  <form action="action_register.php" method="post">
    <input type="text" name="first_name" placeholder="First Name">
    <input type="text" name="last_name" placeholder="Last Name">
    <input type="email" name="email"  placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="password" name="confirm_password" placeholder="confirm password">
    <button type="submit" name="submit" class="login">Register</button>
  </form>
  <a href="login.php">Login</a>

  <?php
    $fullUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if (strpos($fullUrl, "register=empty") == true) {
      echo "You have to fill in all fields.";
    }
   else if (strpos($fullUrl, "register=email") == true) {
     echo "Email already in use.";
   }
   else if (strpos($fullUrl, "register=password") == true) {
     echo "Passwords don't match.";
   }
  ?>

<?php } ?>
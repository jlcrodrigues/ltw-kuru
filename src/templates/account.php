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
      <button 
        id="edit-profile-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-edit')">
        Edit Profile
      </button>
      <button 
        id="change_password-button" 
        class="profile-section-button" 
        onclick="openProfileTab(event, 'profile-change_password')">
        Change Password
      </button>
      <form action="action_logout.php" method="post">
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
    <section id="profile-reviews" class="profile-section">
      <p>Review</p>
    </section>
    <section id="profile-orders" class="profile-section">
      <p>Order</p>
    </section>
    <section id="profile-change_password" class="profile-section">
      <p>Change Password</p>
    </section>
    <section id="profile-edit" class="profile-section">
      <p>Edit Profile</p>

    <form action="action_edit_profile.php" method="post" class="profile">
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
    <?php
    if (!isset($_GET['profile'])) {
      exit();
    }
    else {
      $profileCheck = $_GET['profile'];

      if ($profileCheck == 'success') {
          echo "Successfully saved";
          exit();
      }
      else if ($profileCheck == 'failed') {
          echo "Edit Failed. Email or phone number already in use";
          exit();
      }
      else if ($profileCheck == 'failed_name') {
        echo "Edit Failed. Name can only contain letters and spaces";
        exit();
      }
      else if ($profileCheck == 'failed_empty') {
        echo "Edit Failed. Names and email must be filled";
        exit();
      }
    }
  ?>



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
    if (!isset($_GET['login'])) {
      exit();
    }
    else {
      $loginCheck = $_GET['login'];

      if ($loginCheck == 'empty') {
          echo "You have to fill in all fields.";
          exit();
      }
      else if ($loginCheck == 'failed') {
          echo "Wrong email or password.";
          exit();
      }
      else if ($loginCheck == 'register') {
          echo "Sign up successful."; 
          exit();
      }
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
   if (!isset($_GET['register'])) {
    exit();
  }
  else {
    $registerCheck = $_GET['register'];

    if ($registerCheck == 'empty') {
        echo "You have to fill in all fields.";
        exit();
    }
    else if ($registerCheck == 'email') {
        echo "Email already in use.";
        exit();
    }
    else if ($registerCheck == 'password') {
        echo "Passwords don't match."; 
        exit();
      }
    }
  }

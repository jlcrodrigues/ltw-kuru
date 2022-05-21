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

  <section id="profile">
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
      <h3>Restaurants</h3>

      <?php 
        $restaurants = Restaurant::getOwnerRestaurants($db, $session->getId());
        
        foreach ($restaurants as $restaurant) {
          output_restaurant_card_nano($restaurant);
        }
      ?>


    </section>
    <section id="profile-not-owner" class="profile-section">
      <h3>Become a owner now!</h3>
      <form action="../actions/action_register_restaurant.php?id=<?php echo $restaurant->idRestaurant?>" method="post" class="profile">
      <label for="name">Name:</label>
      <input id="name" type="text" name="name">
      
      <label for="opens">Opens:</label>
      <input id="opens" type="time" name="opens" min=00:00 max=23:59>  

      <label for="closes">Closes:</label>
      <input id="closes" type="time" name="closes" min=00:00 max=23:59>  
      
      <label for="category">Category:</label>
      <option value="" selected disabled hidden>Choose here</option>
      <select name="category" id="category">
      <option value="Super market">Super Market</option>
      <option value="grill">Grill</option>
      <option value="Fast Food">Fast Food</option>
      <option value="pretzels">Pretzels</option>
      <option value="Ice cream">Ice Creams</option>
      <option value="american">American</option>
      <option value="pizza">Pizza</option>
      <option value="Sea food">Sea Food</option>
      <option value="italian">Italian</option>
      <option value="donuts">Donuts</option>
      <option value="caffee">Caffee House</option>
      <option value="sandwiches">Sandwiches</option>
      <option value="juice">Juices</option>
      <option value="steakhouse">Steakhouse</option>
      <option value="Fast casual">Fast Casual</option>
      <option value="mexican">Mexican</option>
      <option value="bar">Bar</option>
      </select>

      <label for="address">Address:</label>
      <input id="address" type="text" name="address">  

      <button type="submit">Register restaurant</button>
    </form>
    </section>
  </section>
<?php } ?>

<?php
function output_login()
{ ?>
  <form action="../actions/action_login.php" method="post">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <button type="submit" name="submit" class="login">Login</button>
  </form>
  <a href="register.php">Register</a>

<?php } ?>

<?php
function output_register()
{ ?>
  <form action="../actions/action_register.php" method="post">
    <input type="text" name="first_name" placeholder="First Name">
    <input type="text" name="last_name" placeholder="Last Name">
    <input type="email" name="email"  placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="password" name="confirm_password" placeholder="confirm password">
    <button type="submit" name="submit" class="login">Register</button>
  </form>
  <a href="login.php">Login</a>
  <?php
  }

<?php
function output_profile(int $id)
{ ?>
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
      <button id="logout-button" class="profile-section-button">Logout</button>
    </div>
    <section id="profile-info" class="profile-section">
      <h3>Name</h3>
      <p>username</p>
      <p>Location</p>
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
  <form action="" method="post">
    <input type="text" placeholder="username">
    <input type="password" placeholder="password">
    <button class="login">Login</button>
  </form>
  <a href="register.php">Register</a>

<?php } ?>

<?php
function output_register()
{ ?>
  <form action="" method="post">
    <input type="text" placeholder="username">
    <input type="email" placeholder="email">
    <input type="password" placeholder="password">
    <button class="login">Register</button>
  </form>
  <a href="login.php">Login</a>

<?php } ?>
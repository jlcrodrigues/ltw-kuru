<?php
function output_profile(int $id)
{ ?>
  <section id="profile">
    <img src="https://picsum.photos/200" alt="profile photo">
    <form action="" method="post">
      <button class="profile_section_button">Profile</button>
      <button class="profile_section_button">Reviews</button>
      <button class="profile_section_button">Orders</button>
      <button class="profile_section_button">Logout</button>
    </form>
    <section id="profile_info" class="profile_section">
      <h3>Name</h3>
      <p>username</p>
      <p>Location</p>
      <a href="">Change password</a>
    </section>
    <section id="profile_reviews" class="profile_section">
      <p>Review</p>
    </section>
    <section id="profile_orders" class="profile_section">
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
  <a href="../pages/register.php">Register</a>

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
  <a href="../pages/login.php">Login</a>

<?php } ?>
<?php
session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
  $login_button = '<button class="button" onclick="location.href=\'logout.php\'">Logout</button>';
} else {
  $login_button = '<button class="button" onclick="location.href=\'login.php\'">Login</button>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="ktv_logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KTV Fam</title>
  <link rel="stylesheet" href="homepage.css">
</head>
<body>
  <!-- Header -->
  <header>
    <nav>
      <h1><img src="ktvlogo_name.png" alt="logoname"></h1>
      <button class="button" onclick="location.href='index.php'">Home</button>
      <button class="button" onclick="location.href='aboutus.php'">About Us</button>
      <button class="button" onclick="location.href='reservation.php'">Reservation</button>
      <?php echo $login_button;?>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-image">
      <div class="hero-text">
        <h2>Welcome to KTV Fam!</h2>
        <p>Experience the ultimate karaoke experience with your family and friends!</p>
        <button class="button" onclick="location.href='reservation.php'">Book a Room Now!</button>
      </div>
    </div>
  </section>

  <section class="features">
    <h2>Our Features</h2>
    <div class="container" style="width: 1000px;">
      <div class="row">
        <div class="col-md-4">
          <div class="feature">
            <img src="roomspic.jpeg" alt="Karaoke Rooms Image">
            <h3>Karaoke Rooms</h3>
            <p>Choose from our variety of karaoke rooms, ranging from small to large, to fit your party needs.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature">
            <img src="pooltable.jpeg" alt="Pool Tables Image">
            <h3>Pool Tables</h3>
            <p>Enjoy a game of pool with your friends and family while you take a break from singing.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature">
            <img src="fooddrinks.jpeg" alt="Food and Drinks Image">
            <h3>Food and Drinks</h3>
            <p>Order from our menu of delicious food and drinks to enjoy during your karaoke session.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rates Section -->
  <section class="rates">
    <h2>Rates</h2>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <table>
            <thead>
              <tr>
                <th>Room Size</th>
                <th>Rate (per hour)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Small (1-5 people)</td>
                <td>$20</td>
              </tr>
              <tr>
                <td>Medium (6-10 people)</td>
                <td>$30</td>
              </tr>
              <tr>
                <td>Large (11-15 people)</td>
                <td>$40</td>
              </tr>
            </tbody>
          </table>
          <p>Special promotions and deals available! Contact us for more information.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="cta">
    <h2>Ready to Book?</h2>
    <button class="button" onclick="location.href='reservation.php'">Book a Room Now!</button>
  </section>

  <footer>
    <div class="footer">
      <div class="col-md-4">
        <h4>Follow Us</h4>
        <a href="https://www.facebook.com/profile.php?id=100018819461127" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
        <a href="https://x.com/Xin_co25" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a>
        <a href="https://www.instagram.com/isaa.c173/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a>
        <a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i> LinkedIn</a>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p>&copy; 2024 KTV Fam. All rights reserved.</p>
        </div>
      </div>  
    </div>
  </footer>
</body>
</html>
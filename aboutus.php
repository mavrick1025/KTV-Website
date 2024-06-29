<?php
session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
  $login_button = '<button class="button" onclick="location.href=\'logout.php\'">Logout</button>';
} else {
  $login_button = '<button class="button" onclick="location.href=\'login.php\'">Login</button>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>About Us</title>
	<link rel="icon" type="image/png" href="ktv_logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="homepage.css"> <!-- assume you have a stylesheet -->
</head>
<body>
	<header>
    <nav>
    	<h1><img src="ktvlogo_name.png" alt="logoname"></h1>
      <button class="button" onclick="location.href='index.php'">Home</button>
      <button class="button" onclick="location.href='aboutus.php'">About Us</button>
      <button class="button" onclick="location.href='reservation.php'">Reservation</button>
      <?php echo $login_button;?>
    </nav>
  	</header>
	<div class="container" style="width: 1000px;">
		<h1>About Us</h1>
		<p>Welcome to FamilyKTV!</p>

		<p>At FamilyKTV, we believe that the best moments are those shared with loved ones. Founded in 2024, our mission is to create an enjoyable, inclusive, and memorable karaoke experience for families of all sizes and backgrounds. Our state-of-the-art facilities and wide selection of songs cater to every taste and age group, ensuring that everyone has a great time.</p>

		<h2>Our Story</h2>
		<p>The idea for FamilyKTV was born from a love for music and family gatherings. Our founders, Lord Isaac Panganiban, grew up in a household where music was a cornerstone of every celebration. They realized that while there were many KTV options, few truly catered to families. With a vision to fill this gap, they set out to create a place where families could come together, sing their hearts out, and create lasting memories.</p>

		<h2>What We Offer</h2>
		<ul>
			<li><strong>Private Rooms:</strong> Enjoy your karaoke session in the comfort of our private, family-friendly rooms. Each room is equipped with high-quality sound systems, large screens, and comfortable seating.</li>
			<li><strong>Extensive Song Library:</strong> From the latest hits to timeless classics, our song library spans multiple genres and languages, ensuring that everyone finds their favorite tune.</li>
			<li><strong>Food & Beverages:</strong> Our in-house kitchen offers a variety of snacks, meals, and beverages to keep your energy high and your spirits higher.</li>
			<li><strong>Special Events:</strong> Celebrate birthdays, anniversaries, and special occasions with our customizable event packages designed to make your day extra special.</li>
		</ul>

		<h2>Our Commitment</h2>
		<p>At FamilyKTV, we are dedicated to providing a safe, clean, and fun environment for all our guests. We prioritize customer satisfaction and continuously strive to improve our services based on your feedback. Our friendly staff is always ready to assist you and ensure your experience is nothing short of spectacular.</p>

		<h2>Join Us!</h2>
		<p>Whether you’re a seasoned singer or a first-timer, we invite you to join us for an unforgettable karaoke experience. Book your room today and let the music bring your family closer together at FamilyKTV!</p>
	</div>

</body>
</html>
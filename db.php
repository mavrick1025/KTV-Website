<?php
// config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sherwin');
define('DB_PASSWORD', 'sherwin1025');
define('DB_NAME', 'demo');

// Create a connection to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
<?php
// db_connect.php
$servername = "localhost"; // Your MySQL server hostname (e.g., localhost)
$username = "root";        // Your MySQL username (e.g., root for XAMPP/WAMP)
$password = "";            // Your MySQL password (empty for XAMPP/WAMP by default)
$dbname = "simple_blog_db"; // The database name we created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully to database!"; // Uncomment for testing connection
?>
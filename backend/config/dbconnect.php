<?php
// Database configuration
$host = 'localhost';       // Database host (can be an IP address or 'localhost')
$dbname = 'dbhotel'; // Database name
$username = 'sunrise'; // Database username
$password = ''; // Database password

try {
    // Create a PDO instance (this establishes the connection)
    $dsn = "mysql:host=$host;dbname=$dbname"; // Data Source Name
    $pdo = new PDO($dsn, $username, $password);

    // Set the PDO error mode to exception to handle errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully to the database!";
} catch (PDOException $e) {
    // If the connection fails, an exception will be thrown
    echo "Connection failed: " . $e->getMessage();
}
?>

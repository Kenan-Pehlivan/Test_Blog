<!-- Veränderungsdatum: 08.10.2024 
    Verbindung mit der Datenbank mit gegebenen Parametern
-->

<?php
// Docker-compatible database connection
// Check if running in Docker environment
$isDocker = getenv('DB_HOST') !== false;

if ($isDocker) {
    // Docker environment
    $servername = getenv('DB_HOST') ?: 'db';
    $username = getenv('DB_USER') ?: 'blog_user';
    $password = getenv('DB_PASSWORD') ?: 'blog_password_2024';
    $dbname = getenv('DB_NAME') ?: 'blog_db';
} else {
    // Local XAMPP environment  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog_db";
}

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Set charset to handle special characters properly
    $conn->set_charset("utf8mb4");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch(Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
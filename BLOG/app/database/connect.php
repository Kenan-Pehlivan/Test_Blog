<!-- Veränderungsdatum: 08.10.2024 
    Verbindung mit der Datenbank mit gegebenen Parametern
-->

<?php

$host = 'db';
$user = 'root';
$pass = '';
$db_name = 'blog';

// Verbindung mit der DB mit den gegebenen Parametern weiterer potenzieller Ansatz: $conn = new MYSQLi(...)

$conn = mysqli_connect($host, $user, $pass, $db_name);

// Passwort auf der DB nicht gesetzt. Daher wird keine Fehlermeldung ausgeworfen. Passwort muss noch in der DB gesetzt werden
if ($conn->connect_error) {
    die('Database connection error: '. $conn->connect_error);
} 

/*  Testung der Verbindung

    else {
    echo "DB connection sucessful";
    }
*/
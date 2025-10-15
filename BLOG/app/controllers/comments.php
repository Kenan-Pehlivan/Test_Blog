<!-- Veränderungsdatum: 08.10.2024 
    In dieser Datei werden Comments in der Datenbank eingefügt. 
    Die Comments sind zu jeweiligen Post und ggf. Parent commment verknüpft.
-->

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Versichere, dass diese felder geserzt sind
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $parent_id = $_POST['parent_id'] ?? null; // nehme die parent ID
    $post_id = $_POST['post_id']; // nehme die post ID
    
    // Wenn username und comment feld nicht leer ist, dann füge Comment  in DB ein
    if (!empty($username) && !empty($comment)) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO comments (username, comment, parent_id, post_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $username, $comment, $parent_id, $post_id);
        
        // Execute die statement
        if ($stmt->execute()) {
            // Verlinke zu den Post, wenn alles geklappt hat
            header("Location: single.php?id=" . $post_id); 
            exit;
        } else {
            //ansonsten zeige Error an
            echo "Error: " . $stmt->error; 
        }

        $stmt->close(); // Schließe den prepared statement
    } else {
        //ansonsten gebe aus, dass die Felder ausgefüllt werden müssen
        echo "Please fill in all fields.";
    }
}
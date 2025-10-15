<!-- Veränderungsdatum: 15.10.2024 
      Diese Datei beinhaltet die Logik für die Datenbank abfragen für das erstellen, verändern und löschen von Posts, Topics und Comments. 
-->

<?php

//Starte die Session, um auf Session-Variablen zugreifen zu können
session_start();

//Wenn die Letzte Aktivität mehr als vor 30 min war
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    //dann alle Session-Variablen entfernen und die Session zerstören und den User ausloggen
    session_unset();     
    session_destroy();   
    echo '<script>alert("Session abgelaufen. Die Seite wird neu geladen.")</script>';
    echo '<script>window.location.reload();</script>'; 
    exit();
}

// Aktualisiere den Timestamp der letzten Aktivität
$_SESSION['last_activity'] = time();

//Um zugriff auf die Datenbankverbindung zu ermöglichen
require('connect.php');

/*
function dd($value) //for Testing
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}


*/

//Führt eine SQL-Abfrage aus und bindet alle Parameter
function executeQuery($sql, $data)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}


//Holt alle Datensätze aus einer angegebenen Tabelle mit die gegebenen Vorrausstezungen
function selectAll($table, $conditions = [], $orderBy = '')
{
    global $conn;
    $sql = "SELECT * FROM $table";

    // Formulieren Voraussetzungen für die Query, falls angegeben
    if (!empty($conditions)) {
        $sql .= " WHERE ";
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i == 0) {
                $sql .= "$key=?";
            } else {
                $sql .= " AND $key=?";
            }
            $i++;
        }
    }

    // Füge ORDER BY hinzu, falls angegeben
    if (!empty($orderBy)) {
        $sql .= " ORDER BY $orderBy";
    }

    $stmt = $conn->prepare($sql);

    // binde Voraussetzungen hinzu, falls angegeben
    if (!empty($conditions)) {
        $values = array_values($conditions);
        $types = str_repeat('s', count($values)); // Angenommen, alle Werte sind Strings
        $stmt->bind_param($types, ...$values);
    }

    //Führt die Query aus und gebe den Ergebniss zurück
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


//Holt einzelne Datensätze aus einer angegebenen Tabelle mit die gegebenen Vorrausstezungen
function selectOne($table, $conditions = [], $orderBy = '')
{
    global $conn;
    $sql = "SELECT * FROM $table";

    // Formulieren Voraussetzungen für die Query, falls angegeben
    if (!empty($conditions)) {
        $sql .= " WHERE ";
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i == 0) {
                $sql .= "$key=?";
            } else {
                $sql .= " AND $key=?";
            }
            $i++;
        }
    }

    // Füge ORDER BY hinzu, falls angegeben
    if (!empty($orderBy)) {
        $sql .= " ORDER BY $orderBy";
    }

    //Limitiere den Datensatz auf eins und führe die Query aus und gebe den Ergebniss zurück
    $sql .= " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $record = $stmt->get_result()->fetch_assoc();
    return $record;
}


//Erstellt neuen Datensatz in der angebenen Tabelle
function create($table, $data)
{
   
    global $conn;
    
    $sql = "INSERT INTO $table SET ";
    $i = 0;

    //Fügt für den einzelnen Felder die Werte
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    //Führt die Query aus und speichert den Ergebniss und gibt die ID des Datensatz zurück
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

//Aktualisiert einen bestehenden Datensatz in der angegebenen Tabelle
function update($table, $id, $data)
{
    global $conn;
    // $sql = "UPDATE users SET username=?, admin=?, email=?, password=? WHERE id=?"
    $sql = "UPDATE $table SET ";

    $i = 0;

    //Fügt für den einzelnen Felder die Werte
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;

    //Führt die Query aus und gibt die Anzahl an betroffenen zeilen zurück
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}


//Löscht einen Datensatz anhand der ID und gibt die Anzahl an betroffenen zeilen zurück
function delete($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";
    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;

}

//Holt die veröffentlichte Posts aus der Datenbank und gibt sie zurück
function getPublishedPosts()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? ORDER BY p.created_at DESC";
    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

//Holt die Posts aus der Datenbank basierend auf der Themen-ID und gebe sie zurück
function getPostsByTopicId($topic_id)
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=? ORDER BY p.created_at DESC";
    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

//Sucht nach Posts basierend auf einem Suchbegriff und gibt sie zurück
function searchPosts($term)
{
    global $conn;

    //Der Suchbegriff kann in Titel oder Body und in irgend einer stelle sein.
    $match = '%' . $term . '%';
    $sql = "SELECT p.*, u.username 
                FROM posts AS p 
                JOIN users AS u 
                ON p.user_id=u.id 
                WHERE p.published=? AND (p.title LIKE ? OR p.body LIKE ?) 
                ORDER BY p.created_at DESC";
    $stmt = executeQuery($sql, ['published' => 1, $match, $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


//Holt die Comments aus der Datenbank anhand der Post-ID und gibt sie aus 
function display_comments($post_id, $parent_id = null, $indent = 0) {
    global $conn;
    
    // Erstellt die SQL query
    $sql = "SELECT c.* FROM comments AS c WHERE c.post_id = ?";

    // Data array für executeQuery
    $data = [$post_id];  // Beinhalte post_id immmer in data array

    // Wenn die parent_id nicht null ist
    if ($parent_id !== null) {
        //dann füge auch die parent_id in der Query und data
        $sql .= " AND c.parent_id = ?";  
        $data[] = $parent_id;  
    } 

    // Sortiere nach Erstellungsdatum
    $sql .= " ORDER BY c.created_at DESC";

    
    $stmt = executeQuery($sql, $data);

    // Überprüft ob es es vorbereiten oder bei ausführen der Query fehler gab
    if (!$stmt) {
        echo "Failed to prepare statement: " . $conn->error;
        return;
    }

    //Speichere die Ergebnisse in result
    $result = $stmt->get_result();
    
    // Wenn es Comments gibt zum anzeigen
    if ($result->num_rows > 0) {
        
        $child_comments = [];
        //Geht jeden Comment durch und speichert es als root comment oder verzweigeter comment
        while ($row = $result->fetch_assoc()) {
            if ($row['parent_id'] == 0) {
                $root_comments[] = $row; 
            } else {
                $child_comments[$row['parent_id']][] = $row; 
            }
        }
    
        // Zeigt die root comments und deren verzweigte comments
        foreach ($root_comments as $comment) {
            display_comment_item($comment, $child_comments, $indent);
        }
            
        
    } else {
        //ansonsten Anzeigen, dass es keine Kommentare gab.
        if ($parent_id === null) {
            echo "<div style='margin-left: " . ($indent * 20) . "px;'>Keine Kommentare vorhanden.</div>";
        }
    }

    $stmt->close(); // Schließe den prepared statement
}


//Zeigt die comments im Richtigen Format an
function display_comment_item($comment, $child_comments, $indent) {
    ?>
    <div class="comment-item" style="margin-left: <?php echo $indent * 20; ?>px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; background-color: #f9f9f9;">
    <div class="comment-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <div style="font-weight: bold; color: #333;">
            <?php echo htmlspecialchars($comment['username']); ?>
        </div>
        <div style="font-size: 0.85em; color: #777;">
            <?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?>
        </div>
    </div>
    <div class="comment-body" style="margin-bottom: 10px; color: #444; line-height: 1.6;">
        <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
    </div>
    <div class="comment-footer" style="margin-top: 10px;">
        <a href='#' class='reply-link' data-id='<?php echo $comment['id']; ?>' style="color: #007BFF; text-decoration: none;">Antworten</a>
    </div>
</div>
    <?php

    // Wenn der dieser comment einen child-comment hat, zeige diese als verzweigt an
    if (isset($child_comments[$comment['id']])) {
        foreach ($child_comments[$comment['id']] as $child_comment) {
            display_comment_item($child_comment, $child_comments, $indent + 2);
        }
    }
}
<!-- Veränderungsdatum: 08.10.2024 
    Datei zur Verwaltung und Hinzufügen von Posts. 
    If Abfragen die bei Fehlerfreiheit die Parameter der Datenbank übermitteln/hinzufügen und löschen.
    Fallunterscheidung Publish Admin und User
    Send Publish Email Funktion
-->

<?php

require(ROOT_PATH . "/app/database/db.php");
require(ROOT_PATH . "/app/helpers/middleware.php");
require(ROOT_PATH . "/app/helpers/validatePost.php");

//DB Tabelle für Post und Select All Post und Topics von DB
$table = 'posts';
$topics = selectAll('topics');
$posts = selectAll('posts', [], 'created_at DESC');

//Initialisiere Array mit Post Daten
$errors = array();
$id = "";
$title = "";
$body = "";
$topic_id = "";
$published = "";

//Überprüfung, ob ID für Post vergeben wurde und die Zuweisung der Variablen aus DB
if (isset($_GET['id'])) {
    $post = selectOne($table, ['id' => $_GET['id']]);
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
}

//Überprüfen ob ein Löschbefehl vorliegt, Posts aus der DB entfernen, Message und Weiterleitung 
if (isset($_GET['delete_id'])) {
    usersOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Post wurde erfolgreich gelöscht";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}

// Überprüfen ob der Veröffentlichungsstatus eines Posts geändert werden soll, DB übermitteln, Message & Weiterleitung
if (isset($_GET['published']) && isset($_GET['p_id'])) {
    adminOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['published' => $published]);
    $_SESSION['message'] = "Post published Status geändert!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}

//Überprüfen ob ein neuer Post hinzugefügt werden soll
if (isset($_POST['add-post'])) {
    usersOnly();
    $errors = validatePost($_POST);

    //Bild Hochladen
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        //Fehler --> Message/ Erfolgreich --> Bild hochladen
        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, 'Failed to upload image');
        }
    } else {
        array_push($errors, 'Post image required');
    }

    // Wenn kein Fehler vorhanden, erstelle Post, Fallunterscheidung User und Admin Button ( setze Body ID, Veröffentlichungsstatus)
    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['body'] = htmlentities($_POST['body']); //Text gegen XSS Angriffe zu sichern

        if ($_SESSION['admin']) {
            $_POST['published'] = isset($_POST['published']) ? 1 : 0; //Will der Benutzer den Post veröffentlichen
            $post_id = create($table, $_POST);
            $_SESSION['message'] = "Post created successfuly";

        } else {
            $_POST['AdminPublish'] = isset($_POST['AdminPublish']) ? 1 : 0;

            //   require(ROOT_PATH . "/app/helpers/test.php");
            Send_Publish_Email($_POST);
            unset($_POST['AdminPublish']);
            $_POST['published'] = 0;
            $post_id = create($table, $_POST);
            $_SESSION['message'] = "Post wurde zur Veröffentlichung versandt";

        }
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");
        exit();


    } else {
        // Bei Fehler setze bisherige Variablen für Post Formular zurück
        $title = $_POST['title'];
        $topic_id = $_POST['topic_id'];
        $body = $_POST['body'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}

//Überprüfe ob ein bestehender Post aktualisiert werden soll
if (isset($_POST['update-post'])) {
    usersOnly();
    $errors = validatePost($_POST);

    //Überprüfe ob Bild hochgeladen wurde--> Error Message
    if (!empty($_FILES['image']['name'])) {

        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
            $_POST['image'] = $image_name;

        } else {
            array_push($errors, "Fehler beim Upload des Bilds");
        }
    } else {
        array_push($errors, "Post Bild benötigt");
    }

    //Wenn keine Ffehler Aktualisierung des Posts mit DB Parametern
    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);

        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Post update erfolgreich";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");
        exit();

    } else {
        //Bei Fehler setze die Variablen im Formular zurück
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}

// Funktion zur Übersendung einer Email der Publish Funktion des Users mit Übermittlung von Post Titel und einer Hardcode Nachricht
function Send_Publish_Email($postinfo)
{
    if ($_POST['AdminPublish']) {
        // Die zu sendenden Daten als Array
        $information = [
            'Title' => $postinfo['title'],
            'nachricht' => 'Bitte veröffentlichen Sie diesen Post'
        ];
        require(ROOT_PATH . '/app/helpers/send-email.php');

        unset($information);
    }
}






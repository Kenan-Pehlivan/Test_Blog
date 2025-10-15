<!-- Veränderungsdatum: 08.10.2024 
    Datei zur Verwaltung und Hinzufügen von Topics. 
    If Abfragen die bei Fehlerfreiheit die Parameter der Datenbank übermitteln/hinzufügen und löschen.
-->

<?php

require(ROOT_PATH . "/app/database/db.php");
require(ROOT_PATH . "/app/helpers/middleware.php");
require(ROOT_PATH . "/app/helpers/validateTopic.php");

// DB-Tabelle für Topic anlegen
$table = 'topics';

//Anlegen eines Arrays mit leeren String Werten
$errors =array();
$id = '';
$name = '';
$description = '';

$topics = selectAll($table);

// Ausführung von Add Topic --> Topic hinzufüge in DB wenn keine Fehler, Message (Error/Erfolgreich ausgeben), Weiterleitung zur Homepage
if(isset($_POST['add-topic'])){
    adminOnly();
    $errors =validateTopic($_POST);

    if (count($errors) === 0) {

    unset($_POST['add-topic']);
    $topic_id = create('topics', $_POST);
    $_SESSION['message'] = 'Topic wurde erfolgreich erstellt';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}

// Topic Abfrage, Übergabe von Datenbank Paramtern, (Verwendung beim Editen)
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

//Löschen des Topics aus der DB, Message und Weiterleitung
if (isset($_GET['del_id'])){
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Topic wurde erfolgreich gelöscht';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
}

//Bearbeitung des Topics, Übergabe neuer Parameter wenn keine Fehler, Message und Weiterleitung
if (isset($_POST['update-topic'])){
    adminOnly();
    $errors =validateTopic($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-topic'], $_POST['id']);
        $topic_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Topic updated erfolgreich';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        //Bei Fehler setze die Variablen des Formulars zurück
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }     
}
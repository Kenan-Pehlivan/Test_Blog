<!-- Veränderungsdatum: 08.10.2024 
    Datei zur Verwaltung, update, Login und Register (Validierung) und Löschen des Users. 
    Funktionen und If Abfragen die bei Fehlerfreiheit die Parameter der Datenbank hinzufügen und löschen.
    Unterscheidung Admin Only und Users Only Funktion
-->

<?php

require(ROOT_PATH . "/app/database/db.php");
require(ROOT_PATH . "/app/helpers/middleware.php");
require(ROOT_PATH . "/app/helpers/validateUser.php");

//Definiere Tabelle für User und Select All von DB
$table = 'users';
$admin_users = selectAll($table);

//Initalisiere Arrays für Fehler und Variablen für Benutzerdaten
$errors = array();
$username   = '';
$id   = '';
$admin   = '';
$email   = '';
$password   = '';
$passwordConf   = '';



//Funktion zur Anmeldung eines Users
function loginUser($user) {
      //log user in with session
      $_SESSION['id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['admin'] = $user['admin'];
      // Message in CSS-Style
      $_SESSION['message'] = 'Du bist Eingeloggt';
      $_SESSION['type'] = 'success';
 
      //Admin User Login to Dashboard
      if ($_SESSION['admin']){
          header('location: ' . BASE_URL . '/admin/dashboard.php');
      } else {
          header('location: ' . BASE_URL . '/index.php');
      }
      exit();
    }
    // Falls Bot den unsichtbaren Honeypot im Register ausfüllt DIE
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['honeypot'])){
            die("Bot-Aktivität erkannt. Der Zugriff wurde verweigert.");
        }
    }



//Überprüfung, ob ein Benutzer registriert oder ein ADministrator erstellt werden soll
if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {
    $errors = validateUser($_POST);
    
    // Wenn keine Fehler vorhanden führe durch
    if (count($errors)===0){
        unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin'], $_POST['honeypot']);
    
        //Encryption password in DB
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Überprüfung ob Admin erstellt werden soll, Message und Weiterleitung 
        if (isset($_POST['admin'])) {
            $_POST ['admin'] = 1;
            $user_id = create('users', $_POST);
            $_SESSION['message'] = "Admin user erfolgreich erstellt";
            $_SESSION['type'] = "success";
            header('location: ' . BASE_URL . '/admin/users/index.php');
            exit();

        } else {

            

            // Setze Admin Flag auf 0, erstelle Benutzer in DB und Melde User an
            $_POST ['admin'] = 0;
            $user_id = create('users', $_POST);
            $user = selectOne('users', ['id' => $user_id]);
            //log user in with session
            loginUser($user);

        }
        } else {
        // Bei Fehlern behalte Variablen für Register Formular bei
        $username   = $_POST['username'];
        $admin   = isset($_POST['admin']) ? 1 : 0;
        $email   = $_POST['email'];
        $password   = $_POST['password'];
        $passwordConf   = $_POST['passwordConf'];
        }
    }

   
//Überprüfung ob User Aktualisiert werden soll von Admin
if (isset($_POST['update-user'])){
    adminOnly();
    $errors = validateUser($_POST);

    // Keine Fehler ? --> fahre fort und unset
    if (count($errors)===0){
        $id = $_POST['id'];
        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);
    
        //Encryption password, neue Admin Flag, Message und Weiterleitung
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $_POST ['admin'] = isset($_POST['admin']) ? 1 : 0;
        $count = update($table, $id, $_POST);
        $_SESSION['message'] = "Admin user erfoglreich erstellt";
        $_SESSION['type'] = "success";
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();

        } else {
        // Bei Fehler behalte Parameter des Formulars bei
        $username   = $_POST['username'];
        $admin   = isset($_POST['admin']) ? 1 : 0;
        $email   = $_POST['email'];
        $password   = $_POST['password'];
        $passwordConf   = $_POST['passwordConf'];
        }
}

//Wird Benutzer ID übergeben, wähle Benutzer und übermittle Parameter
if (isset($_GET['id'])){
    $user = selectOne($table, ['id' => $_GET['id']]);
    $id   = $user['id'];
    $username   = $user['username'];
    $admin   = ($user['admin']) == 1 ? 1 : 0;
    $email   = $user['email'];
    }


//Überprüfe ob ein User sich anmelden möchte
if (isset($_POST['login-btn'])){
    $errors = validateLogin($_POST);

    // Wenn keine Fehler fahre fort
    if (count($errors) === 0) {
        $user = selectOne($table, ['username'=> $_POST['username']]);

        if ($user && password_verify($_POST['password'], $user['password'])){
            // login, redirect
            loginUser($user);

        } else {
            array_push($errors, 'Falsche Eingaben');
        }
        }
        //Beibehaltung der Formulareingaben
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    //Löschbefehl für User der vom Admin ausgeführt wird, Message & Weiterleitung
    if (isset($_GET['delete_id'])){
        adminOnly();
        $count = delete($table, $_GET['delete_id']);
        $_SESSION['message'] = 'User wurde gelöscht';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    }



<!-- Veränderungsdatum: 08.10.2024 
    Die Middleware definiert verschiedene Funktionen die bspw. im Controller verwendet werden um Zugriffe der verschiedenen Nutzer zu sperren
-->

<?php
// Definierung einer Funktion dir nur ein eingeloggter User tätigen kann, ansosten Weiterleitung zur Homepage
function usersOnly($redirect = '/index.php')
{

    if (empty($_SESSION['id'])) {
        $_SESSION['message'] = 'Sie müssen sich zuerst einloggen';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

// Definierung einer Funktion die nur ein eingeloggter Admin tätigen kann, ansonsten Weiterleitung zur Homepage
function adminOnly($redirect = '/index.php')
{
    if (empty($_SESSION['id']) || empty($_SESSION['admin'])) {
        $_SESSION['message'] = 'Sie sind nicht authoriziert';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

// Definierung einer Funktion die nur ein Gast tätigen kann, ansonsten Weiterleitung zur Homepage
function guestsOnly($redirect = '/index.php')
{
    if (isset($_SESSION['id'])) {
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

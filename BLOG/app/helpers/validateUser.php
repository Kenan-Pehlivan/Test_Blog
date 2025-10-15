<!-- Veränderungsdatum: 08.10.2024 
    Helper in der Registrierung, Login und dem Dashboard um zu vermeiden dass ein User/Admin sich mit fehlerhaften Eingaben eingloggt/registriert.
    Error Ausgabe bei gleicher Email Adresse.
-->

<?php

// Bei Fehleingabe von dem Registrierungs-Formular --> Error ausgeben 
function validateUser($user)
{
    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Username ist erforderlich');
    }
    if (empty($user['email'])) {
        array_push($errors, 'Email ist erforderlich');
    }
    if (empty($user['password'])) {
        array_push($errors, 'Password ist erforderlich');
    }
    if (($user['passwordConf'] !== $user['password'])) {
        array_push($errors, 'Passwörter stimmen nicht überein ');
    }

    // Falls der User/Admin bereits mit der Email Adresse existiert--> Error bei der Registierierung, Update User und create Admin im Admin Dashboard
    $existingUser = selectOne('users', ['email' => $user['email']]);
    if ($existingUser) {

        if (isset($user['update-user']) && $existingUser['id'] != $user['id']) {
            array_push($errors, 'Email existiert bereits');
        }
        if (isset($user['create-admin'])) {
            array_push($errors, 'Email existiert bereits');
        }
        if (isset($user['register-btn'])) {
            array_push($errors, 'Email existiert bereits');
        }
    }
    return $errors;
}

// Bei Fehleingabe von dem Login-Formular --> Error ausgeben
function validateLogin($user)
{
    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Username ist erforderlich');
    }
    if (empty($user['password'])) {
        array_push($errors, 'Password ist erforderlich');
    }
    return $errors;
}


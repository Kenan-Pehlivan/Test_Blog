<!-- Veränderungsdatum: 08.10.2024 
    Helper beim Anlegen von Topics im Admin Dashboard. 
    Fehlerhafte Angaben beim Anlegen als auch wiederholende gleiche Topic Namen sollen verhindert werden.
-->

<?php

// Bei Fehleingabe beim Anlegen eines Topics --> Error ausgeben 
function validateTopic($topic)
{
    $errors = array();

    if (empty($topic['name'])) {
        array_push($errors, 'Name ist erforderlich');
    }
    // Bei wiederholter Eingabe von gleichen Topic Namen --> Error ausgeben
    $existingTopic = selectOne('topics', ['name' => $topic['name']]);
    if ($existingTopic) {

        if (isset($topic['update-topic']) && $existingTopic['id'] != $topic['id']) {
            array_push($errors, 'Name exisitert bereits');
        }

        if (isset($topic['add-topic'])) {
            array_push($errors, 'Name existiert bereits');
        }
    }
    return $errors;

}




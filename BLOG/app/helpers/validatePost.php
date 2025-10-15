<!-- Veränderungsdatum: 08.10.2024 
    Helper beim Anlegen von Posts im Admin und User Dashboard. 
    Fehlerhafte Angaben beim Anlegen als auch wiederholende gleiche Post Namen sollen verhindert werden.
-->

<?php

// Bei Fehleingabe/Auswahl beim Anlegen eines neuen Posts --> Error ausgeben
function validatePost($post)
{
    $errors = array();

    if (empty($post['title'])) {
        array_push($errors, 'Title ist erforderlich');
    }
    if (empty($post['body'])) {
        array_push($errors, 'Body ist erforderlich');
    }
    if (empty($post['topic_id'])) {
        array_push($errors, 'Bitte wähle ein Topic aus');
    }
    // Bei wiederholter Eingabe vom gleichen Post Namen --> Eror ausgeben
    $existingPost = selectOne('posts', ['title' => $post['title']]);
    if ($existingPost) {

        if (isset($post['update-post']) && $existingPost['id'] != $post['id']) {
            array_push($errors, 'Post mit diesem Titel exisitert bereits');
        }

        if (isset($post['add-post'])) {
            array_push($errors, 'Post mit diesem Titel existiert bereits');
        }
    }
    return $errors;

}
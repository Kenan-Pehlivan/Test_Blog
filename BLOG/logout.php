<!-- Veränderungsdatum: 08.10.2024 
      Der Logout erfolgt durch das leer setzen und zerstören der Session die mit dem Einloggen/Zugriff 
      auf den Controller und damit der DB startet.
-->

<?php

require("path.php");

session_start();

//Alle Variablen der Session löschen und die Session zerstören

unset ($_SESSION['id']);
unset ($_SESSION['username']);
unset ($_SESSION['admin']);
unset ($_SESSION['message']); 
unset ($_SESSION['type']);

session_destroy();

//Verlinkung auf Homepage nach Logout
header('location: ' . BASE_URL . '/index.php');
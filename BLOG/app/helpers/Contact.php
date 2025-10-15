<!-- Veränderungsdatum: 08.10.2024 
    In dieser Datei wird eine Mail abgesandt, wenn der User oder Admin das Kontakt Formular über alle Php Seiten mit einem Footer verwenden.
    Zur Absendung muss sowohl die Adresse als auch Body im Kontakt Formular vorhanden sein.
    Als SMTP Server werden Gmail Adresse verwendent. Alle Email gelangen zur sammelstelledhbwblog@gmail.com
    Zuletzt werden Session Messages abgesandt.
    Zur Nutzung wurde PHP Mailer über den Composer verwendet
-->

<?php

require("../../path.php");
require(ROOT_PATH . "/app/database/db.php");
require(ROOT_PATH . "/app/helpers/middleware.php");
?>


<?php

usersOnly();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';


if (!empty($_POST['message']) && !empty($_POST['Adresse'])) {

    $Adresse = $_POST["Adresse"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    //Server settings                    
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'contactusdhbwblog@gmail.com';            //SMTP username
    $mail->Password = 'ywsiyetgqcrxzgts';                     //SMTP password
    $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
    $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Email mit eingegebener Adresse schicken
    $mail->setFrom($Adresse);

    // Zieladresse
    $mail->addAddress('sammelstelledhbwblog@gmail.com');

    // Mail Inhalt
    $mail->Body = "Die folgende Email-Adresse: $Adresse\n\n hat ihnen über das Kontakt Formular mitgeteilt: \n\n $message";

    $mail->send();

    // Session Messages beim Absenden & Weiterleitung zur Homepage
    $_SESSION['message'] = "Ihre Nachricht wurde abgesandt";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/index.php");
    exit();
} else {

    header("location: " . BASE_URL . "/index.php");
    $_SESSION["message"] = "Sie haben nicht alle Felder ausgefüllt";
    $_SESSION["type"] = "error";

}
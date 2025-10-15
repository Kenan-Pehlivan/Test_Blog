<!-- Veränderungsdatum: 08.10.2024 
    In dieser Datei wird eine Mail abgesandt, wenn der User versucht ein Post zu publishen/zu senden.
    Als SMTP Server werden Gmail Adresse verwendent. Alle Email gelangen zur sammelstelledhbwblog@gmail.com
    Zuletzt werden Session Messages abgesandt.
    Zur Nutzung wurde PHP Mailer über den Composer verwendet
-->

<?php

usersOnly();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';


if (isset($information)) {

  $Title = $information["Title"];
  //$email = $_POST["email"];
  $nachricht = $information["nachricht"];

  $mail = new PHPMailer(true);

  //Server settings                    
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host = 'smtp.gmail.com';                       //Set the SMTP server to send through
  $mail->SMTPAuth = true;                                   //Enable SMTP authentication
  $mail->Username = 'publisheranfragedhbwblog@gmail.com';            //SMTP username
  $mail->Password = 'bqtfxsfdcvqnmhve';                     //SMTP password
  $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
  $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  // Zieladresse
  $mail->addAddress('sammelstelledhbwblog@gmail.com');

  // Mail Inhalt
  $mail->Body = "Der Titel zum Publishen lautet: $Title\n\n$nachricht";

  $mail->send();

  // Session Messages beim Absenden & Weiterleitung zur Homepage
  $_SESSION['message'] = "Ihre Nachricht wurde abgesandt";
  $_SESSION['type'] = "success";
} else {

  header("location: " . BASE_URL . "/users/dashboard.php");
  $_SESSION["message"] = "Data wurde nicht überliefert";
  $_SESSION["type"] = "error";

}















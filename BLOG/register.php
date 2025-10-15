<!-- Veränderungsdatum: 08.10.2024 
      In dieser Datei wird das Register-Formular in HTML mit Username, Email, Passwort und Wiederholter Passworteingabe
      in der Datenbank angelegt. Bei wiederholter Email Eingabe, falsche Password Eingabe oder das leer lassen des Formularfeldes erscheint ein Fehler.
      Trotz Fehler werden die Eingaben beibehalten.
      Anlegen des neuen Users im Controller/ DB. Header und Footer werden importet   
-->

<?php require("path.php") ?>
<?php require(ROOT_PATH . "/app/controllers/users.php"); 
//include(ROOT_PATH . "/app/helpers/middleware.php");
guestsOnly(); //Nur der Gast hat Zugriff auf die Register-Seite. 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- CSS Stil -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>Register</title>
</head>

<body>
    <!-- Navigationsleiste für Registrierung aus includes header-->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <div class="auth-content">

    <form action="register.php" method="post">
      
    <h2 class="form-title">Register</h2>

      <!-- Um Fehler anzuzeigen -->
      <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

     <!-- Nicht im Sichtbereich des Users: honeypot Field -->
     <input type="text" id="honeypot" name="honeypot" value="" style="position:absolute; left:-9999px;" /> 

     <!-- Formular Feld -->
      <div>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>" class="text-input">
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
      </div>
      <div>
        <label>Password Confirmation</label>
        <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
      </div>
      <div>
        <button type="submit" name="register-btn" class="btn btn-big">Register</button>
      </div>
      <p>Or <a href="<?php echo BASE_URL . '/login.php' ?>">Login</a></p>
    </form>

  </div>

  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- JS Skript -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>
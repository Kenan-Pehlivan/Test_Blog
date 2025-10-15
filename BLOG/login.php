<!-- Veränderungsdatum: 08.10.2024 
      In dieser Datei wird das Login-Formular in HTML mit Username und Passwort mittels der Datenbank abgeglichen.
      Der Abgleich findet im Controller statt. Header und Footer werden importet   
-->

<?php require("path.php") ?>
<?php require(ROOT_PATH . "/app/controllers/users.php"); 

guestsOnly(); // Nur der ausgeloggte User kann sich wieder einloggen
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

  <!-- CSS Datei für den Stil -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>Login</title>
</head>

<body>
    <!-- Navigationsbar für Login Seite aus includes Header-->
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <div class="auth-content">

    <form action="login.php" method="post">
      <h2 class="form-title">Login</h2>

      <!-- Um Fehler anzuzeigen -->
      <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
      
      <div>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
      </div>
      <div>
        <button type="submit" name="login-btn" class="btn btn-big">Login</button>
      </div>
      <p>Or <a href="<?php echo BASE_URL . '/register.php' ?>">Sign Up</a></p>
    </form>

  </div>

  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- JS Skript -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>
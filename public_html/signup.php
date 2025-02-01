<?php
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

  $next = sanitize_input_string(INPUT_GET, 'next');
  if (!$next) {
    $next = 'index.php';
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(is_user_logged()) {
      logout();
    }
  
    $user = sanitize_input_string(INPUT_POST, 'username');
    if ($user && strlen($user) > 256) {
      $user = null;
    }
    $pw = sanitize_input_string(INPUT_POST, 'password');
    $cognome = sanitize_input_string(INPUT_POST, 'cognome');
    if ($cognome && strlen($cognome) > 64) {
      $cognome = null;
    }
    $nome = sanitize_input_string(INPUT_POST, 'nome');
    if ($nome && strlen($nome) > 64) {
      $nome = null;
    }
    $mail = validate_input_mail(INPUT_POST, 'mail');
    if ($mail && strlen($mail) > 256) {
      $mail = null;
    }
    $nascita = sanitize_input_date(INPUT_POST, 'nascita', ['max' => date('Y-m-d')]);
  
    if ($user && user_exists($user)) {
      $user_already_exists = TRUE;
    }
    if (!$mail) {
      $invalid_mail = TRUE;
    }
    if (!$nascita) {
      $invalid_nascita = TRUE;
    }
    if ($user && !isset($user_already_exists) && $pw && $cognome && $nome && $mail && $nascita) {
      if (signup($user, $pw, $cognome, $nome, $mail, $nascita)) {
        login($user, $pw);
        closeConn();
        header('Location: '.$next);
        exit();
      }
      closeConn();
    }
  }
?>

<!DOCTYPE html>
<html lang="it">
<head>    
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <script src="js/index.js"></script>
    <title>Registrati - SuperBroom</title>
</head>

<body onload="initSignUp()">
  <a href="#signup" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
  <?php echoHeader() ?>

  <nav class="breadcrumb">
        <div class="container">
            <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Area riservata &gt; Registrati</p>
        </div>
    </nav>

  <div class="container">
    <form  class="user-data-form" id="signup" action="signup.php?next=<?php echo $next; ?>" method="post">
      <h1> Registrati </h1>
      <div class="input-row">
          <label for="sign-up-username"> <span xml:lang="en" lang="en">Username</span></label>
          <input type="text" name="username" id="sign-up-username"><br/>
          <div class="error">
              <?php if(isset($user_already_exists)) echo("Username già utilizzato<br/>"); ?>
          </div>
      </div>
      <div class="input-row">
          <label for="sign-up-nome">Nome</label>
          <input type="text" name="nome" id="sign-up-nome"><br/>
          <div class="error"></div>
      </div>
      <div class="input-row">
          <label for="sign-up-cognome">Cognome</label>
          <input type="text" name="cognome" id="sign-up-cognome"><br/>
          <div class="error"></div>
      </div>
      <div class="input-row">
          <label for="sign-up-mail">E-Mail</label>
          <input type="email" name="mail" id="sign-up-mail"><br/>
          <div class="error">
              <?php if(isset($invalid_mail)) echo("Mail non valida<br/>"); ?>
          </div>
      </div>
      <div class="input-row">
          <label for="sign-up-nascita">Data di nascita</label>
          <input type="date" name="nascita" id="sign-up-nascita"><br/>
          <div class="error">
              <?php if(isset($invalid_nascita)) echo("Data non valida."); ?>
          </div>
      </div>
      <div class="input-row">
          <label for="sign-up-password">Password</label>
          <input type="password" name="password" id="sign-up-password"><br/>
          <div class="error"></div>
      </div>
      <button class="button" type="submit">Registrati</button>
    </form>
  </div>

  <a id="torna-su" class="button" href="#">Torna su</a>
    
  <?php echoFooter() ?>
</body>
</html>
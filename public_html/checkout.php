<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

$modello = null;
$pista = null;
$data = null;
$ora_inizio = null;
$ora_fine = null;
$numero_giri = null;
$nome = "";
$cognome = "";
$mail = "";
$nascita = "";
$anagrafica_id = null;

if (is_user_logged()) {
  $nome = getCurrentUser()['anagrafica']['nome'];
  $cognome = getCurrentUser()['anagrafica']['cognome'];
  $mail = getCurrentUser()['anagrafica']['mail'];
  $nascita = getCurrentUser()['anagrafica']['data_nascita'];
}

startSession();
$lastAction = "";
if (isset($_SESSION['flow']['last_action'])) {
  $lastAction = $_SESSION['flow']['last_action'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $modello = sanitize_input_string(INPUT_POST, 'modello');
  $pista = sanitize_input_string(INPUT_POST, 'pista');

  $turno = sanitize_input_set(INPUT_POST, 'turno', ['mattina', 'pomeriggio']);
  if ($turno === 'mattina') {
    $ora_inizio = '08:30';
    $ora_fine = '12:30';
  } elseif ($turno === 'pomeriggio') {
    $ora_inizio = '14:00';
    $ora_fine = '18:00';
  }
  $data = sanitize_input_date(INPUT_POST, 'data', ['min' => date('Y-m-d')]);
  $numero_giri = sanitize_input_int(INPUT_POST, 'numero_giri');
  if ($numero_giri < 4 || $numero_giri > 10) {
    $numero_giri = null;
  }

  $_SESSION['flow'] = [
    'last_action' => 'checkout',
    'modello' => $modello,
    'pista' => $pista,
    'data' => $data,
    'ora_inizio' => $ora_inizio,
    'ora_fine' => $ora_fine,
    'numero_giri' => $numero_giri
  ];
} elseif ($lastAction === 'addprenotazione') {
  $modello = $_SESSION['flow']['modello'];
  $pista = $_SESSION['flow']['pista'];
  $data = $_SESSION['flow']['data'];
  $ora_inizio = $_SESSION['flow']['ora_inizio'];
  $ora_fine = $_SESSION['flow']['ora_fine'];
  $numero_giri = $_SESSION['flow']['numero_giri'];
  $nome = $_SESSION['flow']['nome'];
  $cognome = $_SESSION['flow']['cognome'];
  $mail = $_SESSION['flow']['mail'];
  $nascita = $_SESSION['flow']['nascita'];
  $anagrafica_id = $_SESSION['flow']['anagrafica_id'];
}

$modello = getModelloByNome($modello);
$pista = getPistaByNome($pista);

if (
  !$modello || !$pista || !$data || !$ora_inizio || !$ora_fine ||
  strtotime($ora_inizio) > strtotime($ora_fine) || $numero_giri === null
) {
  header('Location: recap.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />

  <script src="js/index.js"></script>

  <title lang="en">Checkout</title>
</head>

<body onload="initPage()">
  <a href="#checkout" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
  <?php echoHeader() ?>

  <nav class="breadcrumb">
    <div class="container">
      <p>
        Ti trovi in: <span lang="en"><a href="index.php">Home</a></span> &gt; Checkout
      </p>
    </div>
  </nav>

  <div class="container">
    <?php if (!is_user_logged()) : ?>
      <div id="checkout" class="checkout-text">
        <h1><span xml:lang="en" lang="en">Checkout</span></h1>
        <p>Attenzione!</p>
        <p>È possibile procedere all'ordine anche senza registrarsi. Tuttavia, non sarà possibile visualizzare la propria prenotazione nell'area riservata. Perciò consigliamo di <a href="login.php">fare il login</a> (o <a href="signup.php">registrarsi</a>).</p>
      </div>
    <?php endif; ?>

    <div id="checkout" class="checkout">
      <div class="checkout-details">
        <h2>Riepilogo dell'ordine</h2>
        <h3>Macchina: <?php echo ($modello['nome']); ?></h3>
        <h3>Circuito: <?php echo ($pista['nome']); ?></h3>
        <h3>Data: <?php echo (date("d/m/Y", strtotime($data))); ?></h3>
        <h3>Ora: <?php echo (date("H:i", strtotime($ora_inizio)) . ' - ' . date("H:i", strtotime($ora_fine))); ?></h3>
        <h3>Numero di giri: <?php echo ($numero_giri); ?></h3>
        <h3>Prezzo:
          <?php echo (strval($pista['costo_fisso'] + $numero_giri * $modello['costo_km'] * $pista['lunghezza'])) ?>
          €</h3>
      </div>
      <form class="user-data-form" action="add_prenotazione.php" method="post">
        <h2>Inserisci i dati della prenotazione</h2>
        <?php if ($lastAction === 'addprenotazione' && !$anagrafica_id && $nome && $cognome && $mail && $nascita) {
          echo ("<div class='error-message'>Impossibile inserire l'anagrafica. Controllare che tutti i campi siano inseriti correttamente.</div>");
        }
        ?>
        <input type="hidden" name="modello" value="<?php echo ($modello['nome']); ?>" />
        <input type="hidden" name="pista" value="<?php echo ($pista['nome']); ?>" />
        <input type="hidden" name="data" value="<?php echo ($data); ?>" />
        <input type="hidden" name="ora_inizio" value="<?php echo ($ora_inizio); ?>" />
        <input type="hidden" name="ora_fine" value="<?php echo ($ora_fine); ?>" />
        <input type="hidden" name="numero_giri" value="<?php echo ($numero_giri); ?>" />

        <div class="input-row">
          <label for="nome">Nome</label>
          <input type="text" name="nome" id="nome" <?php if ($nome) echo ('value="' . $nome . '"'); ?> />
          <div class="error"><?php if ($lastAction === 'addprenotazione' && !$nome) echo ("Nome obbligatorio."); ?></div>
        </div>
        <div class="input-row">
          <label for="cognome">Cognome</label>
          <input type="text" name="cognome" id="cognome" <?php if ($cognome) echo ('value="' . $cognome . '"'); ?> />
          <div class="error"><?php if ($lastAction === 'addprenotazione' && !$cognome) echo ("Cognome obbligatorio."); ?></div>
        </div>
        <div class="input-row">
          <label for="mail">E-Mail</label>
          <input type="email" name="mail" id="mail" <?php if ($mail) echo ('value="' . $mail . '"'); ?> />
          <div class="error"><?php if ($lastAction === 'addprenotazione' && !$mail) echo ("Email obbligatoria."); ?></div>
        </div>
        <div class="input-row">
          <label for="nascita">Data di nascita</label>
          <input type="date" name="nascita" id="nascita" <?php if ($nascita) echo ('value="' . $nascita . '"'); ?> />
          <div class="error"><?php if ($lastAction === 'addprenotazione' && !$nascita) echo ("Nascita obbligatoria."); ?></div>
        </div>
        <button class="button" type="submit">Conferma</button>
      </form>
    </div>
  </div>

  <a id="torna-su" class="button" href="#">Torna su</a>

  <?php echoFooter() ?>
</body>

</html>
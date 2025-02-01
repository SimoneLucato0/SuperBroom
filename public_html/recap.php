<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

$modello = null;
$pista = null;
$data = '';
$num_giri = 4;

startSession();
$lastAction = "";
if (isset($_SESSION['flow']['last_action']))
  $lastAction = $_SESSION['flow']['last_action'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $modello = sanitize_input_string(INPUT_POST, 'modello');
  $pista = sanitize_input_string(INPUT_POST, 'pista');
} elseif ($lastAction === 'checkout') {
  $modello = $_SESSION['flow']['modello'];
  $pista = $_SESSION['flow']['pista'];
  $data = $_SESSION['flow']['data'];
  $ora_inizio = $_SESSION['flow']['ora_inizio'];
  $ora_fine = $_SESSION['flow']['ora_fine'];
  $num_giri = $_SESSION['flow']['numero_giri'];
  unset($_SESSION['flow']);
}

$modello = getModelloByNome($modello);
$pista = getPistaByNome($pista);

if (!$modello || !$pista) {
  header('Location: index.php');
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

  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
  <link rel="stylesheet" type="text/css" media="print" href="css/print.css">

  <script src="js/index.js"></script>

  <title>Dettagli dell'ordine</title>
</head>

<body onload="initRecap()">
  <a href="#recap" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
  <?php echoHeader() ?>

  <nav class="breadcrumb">
    <div class="container">
      <p>
        Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt;
        Carrello
      </p>
    </div>
  </nav>

  <form method="POST" action="checkout.php" onsubmit="return validateRecap()">
    <input type="hidden" name="modello" value="<?php echo ($modello['nome']); ?>" />
    <input type="hidden" name="pista" value="<?php echo ($pista['nome']); ?>" />
    <div class="recap container">
      <h1>Dettagli dell'ordine</h1>
      <div id="recap" class="recap-details">
        <div>
          <h2>Macchina: <?php echo ($modello['nome']) ?></h2>
          <h2>Circuito: <?php echo ($pista['nome']) ?></h2>
          <div id="date-choice" class="date-choice">
            <fieldset>
              <h3>Seleziona la data</h3>
              <label for="date-selected">Seleziona la data</label>
              <input type="date" name="data" id="date-selected" onchange="updateDate()" value="<?php echo ($data); ?>" />
              <div class="error-message <?php if ($lastAction !== 'checkout' || $data) echo ("hidden"); ?>"><?php if ($lastAction === 'checkout' && !$data) echo ("Data obbligatoria."); ?></div>
              <h3>Seleziona il turno</h3>
              <div class="turn-choice">
                <input type="radio" name="turno" id="turno-mattina" value="mattina" data-value="08:30-12:30" onchange="setTurno()" required="required" />
                <label for="turno-mattina"><span class="sr">Seleziona il turno</span>Mattina: 8:30 - 12:30</label>
              </div>
              <div class="turn-choice">
                <input type="radio" name="turno" id="turno-pomeriggio" value="pomeriggio" data-value="14:00-18:00" onchange="setTurno()" required="required" />
                <label for="turno-pomeriggio"><span class="sr">Seleziona il turno</span>Pomeriggio: 14:00 - 18:00</label>
              </div>
              <div class="error-message <?php if ($lastAction !== 'checkout' || $ora_inizio) echo ("hidden"); ?>"><?php if ($lastAction === 'checkout' && !$ora_inizio) echo ("Scelta del turno obbligatoria."); ?></div>
            </fieldset>
          </div>
        </div>
        <img src="<?php echo ($modello['img']['path']) ?>" alt="<?php echo ($modello['img']['alt']) ?>" />
      </div>


      <div class="select-lap">
        <label for="lap-number">
          Seleziona quanti giri fare (4-10)
        </label>
        <div class="select-lap-number">
          <button class="button" type="button" onclick="stepDown()" aria-label="Diminuisci il numero di giri (minimo 4)">-</button>
          <input id="lap-number" name="numero_giri" type="number" min="4" max="10" value="4" onchange="updatePrice(
            <?php echo ($modello['costo_km'] . ', ' . $pista['costo_fisso'] . ', ' . $pista['lunghezza']); ?>
          );" required="required" />
          <button class="button" type="button" onclick="stepUp()" aria-label="Aumenta il numero di giri (massimo 10)">+</button>
        </div>
        <div class="error-message <?php if ($lastAction !== 'checkout' || $num_giri) echo ("hidden"); ?>"><?php if ($lastAction === 'checkout' && !$num_giri) echo ("Numero di giri non valido."); ?></div>
      </div>
    </div>

    <div id="booking-details-container" class="booking-details-container container" aria-live="polite" aria-atomic="true">
      <p>Riepilogo dell'ordine</p>
      <div class="booking-details">
        <div id="booking-info">
          <p>Macchina: <?php echo ($modello['nome']) ?></p>
          <p>Circuito: <?php echo ($pista['nome']) ?></p>
          <p>Data: da scegliere</p>
          <p>Fascia oraria: da scegliere</p>
          <p>Numero di giri: 4</p>
        </div>
        <div id="booking-price">
          <p>Prezzo</p>
          <p><?php echo (number_format($pista['costo_fisso'] + 4 * $modello['costo_km'] * $pista['lunghezza'], 2)) ?>€</p>
        </div>
      </div>
      <button class="button buy-button">Acquista ora</button>
    </div>
  </form>

  <a id="torna-su" class="button" href="#">Torna su</a>

  <?php echoFooter() ?>
</body>

</html>
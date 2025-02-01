<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  header('Location: index.php');
  exit();
}

$modello = sanitize_input_string(INPUT_POST, 'modello');
$pista = sanitize_input_string(INPUT_POST, 'pista');

$ora_inizio = sanitize_input_time(INPUT_POST, 'ora_inizio');
$ora_fine = sanitize_input_time(INPUT_POST, 'ora_fine');
$data = sanitize_input_date(INPUT_POST, 'data', ['min' => date('Y-m-d')]);
$numero_giri = sanitize_input_int(INPUT_POST, 'numero_giri');
if ($numero_giri !== null && ($numero_giri < 4 || $numero_giri > 10)) {
  $numero_giri = null;
}
$nome = sanitize_input_string(INPUT_POST, 'nome');
if ($nome && strlen($nome) > 64) {
  $nome = null;
}
$cognome = sanitize_input_string(INPUT_POST, 'cognome');
if ($cognome && strlen($cognome) > 64) {
  $cognome = null;
}
$mail = validate_input_mail(INPUT_POST, 'mail');
if ($mail && strlen($mail) > 256) {
  $mail = null;
}
$nascita = sanitize_input_date(INPUT_POST, 'nascita', ['max' => date('Y-m-d')]);
$anagrafica_id = null;

startSession();
$_SESSION['flow'] = [
  'last_action' => 'addprenotazione',
  'modello' => $modello,
  'pista' => $pista,
  'data' => $data,
  'ora_inizio' => $ora_inizio,
  'ora_fine' => $ora_fine,
  'numero_giri' => $numero_giri,
  'nome' => $nome,
  'cognome' => $cognome,
  'mail' => $mail,
  'nascita' => $nascita,
  'anagrafica_id' => $anagrafica_id
];
$modello = getModelloByNome($modello);
$pista = getPistaByNome($pista);

if (
  $modello && $pista && $data && $ora_inizio && $ora_fine &&
  $nome && $cognome && $mail && $nascita &&
  strtotime($ora_inizio) < strtotime($ora_fine) &&
  $numero_giri >= 4 && $numero_giri <= 10
) {
  $utente_id = null;
  $costo = $pista['costo_fisso'] + $pista['lunghezza'] * $modello['costo_km'] * $numero_giri;

  if (is_user_logged()) {
    $user = getCurrentUser();
    $utente_id = $user['id'];
    if (
      $user && $nome === $user['anagrafica']['nome'] && $cognome === $user['anagrafica']['cognome'] &&
      $mail === $user['anagrafica']['mail'] && $nascita === $user['anagrafica']['data_nascita']
    ) {
      $anagrafica_id = $utente_id;
    }
  }

  $conn = connectDB();
  $conn->begin_transaction();

  if ($anagrafica_id === null) {
    $anagrafica_id = saveAnagrafica($nome, $cognome, $mail, $nascita);
  }

  if ($anagrafica_id !== null && savePrenotazione($utente_id, date('Y-m-d H:i:s'), $modello['nome'], $pista['nome'], "$data $ora_inizio", "$data $ora_fine", $numero_giri, $costo, $anagrafica_id)) {
    $conn->commit();
    unset($_SESSION['flow']);
    header('Location: grazie.php');
    exit();
  } else {
    $conn->rollback();
  }
  closeConn();
}
$_SESSION['flow']['anagrafica_id'] = $anagrafica_id;

header('Location: checkout.php');

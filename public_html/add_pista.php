<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !is_user_admin()) {
  header('Location: index.php');
  exit();
}

$nome = sanitize_input_string(INPUT_POST, 'nome');
if ($nome && strlen($nome) > 64) {
  $nome = null;
}
$provincia = sanitize_input_string(INPUT_POST, 'provincia');
if ($provincia && strlen($provincia) != 2) {
  $provincia = null;
}
$descrizione = sanitize_input_string(INPUT_POST, 'descrizione');
$costo_fisso = sanitize_input_float(INPUT_POST, 'costo_fisso');
if ($costo_fisso && $costo_fisso < 0) {
  $costo_fisso = null;
}
$lunghezza = sanitize_input_float(INPUT_POST, 'lunghezza');
if ($lunghezza && $lunghezza <= 0) {
  $lunghezza = null;
}
$larghezza = sanitize_input_float(INPUT_POST, 'larghezza');
if ($larghezza && $larghezza <= 0) {
  $costo_fisso = null;
}
$n_curve = sanitize_input_int(INPUT_POST, 'n_curve');
if ($n_curve && $n_curve <= 0) {
  $costo_fisso = null;
}
$dislivello = sanitize_input_float(INPUT_POST, 'dislivello');
if ($dislivello && $dislivello < 0) {
  $costo_fisso = null;
}
$rettilineo = sanitize_input_float(INPUT_POST, 'rettilineo');
if ($rettilineo && $rettilineo < 0) {
  $costo_fisso = null;
}

$img = null;
$img_alt = sanitize_input_string(INPUT_POST, 'img_alt');
if (
  $img_alt !== null && strlen($img_alt) <= 256 && isset($_FILES['img']) &&
  $_FILES['img']['error'] === UPLOAD_ERR_OK &&
  explode('/', $_FILES['img']['type'])[0] == 'image'
) {
  $img = $_FILES['img'];
}

$galleria = [];
$galleria_alt = [];
if (
  isset($_FILES['galleria']) && gettype($_FILES['galleria']['error']) == 'array' &&
  isset($_POST['galleria_alt']) && gettype($_POST['galleria_alt'] == 'array') &&
  count($_FILES['galleria']['error']) == count($_POST['galleria_alt'])
) {
  foreach ($_FILES['galleria']['error'] as $key => $err) {
    $alt = sanitize_string($_POST['galleria_alt'][$key]);
    if ($err == UPLOAD_ERR_OK && explode('/', $_FILES['galleria']['type'][$key])[0] == 'image' && $alt !== null && strlen($alt) <= 256) {
      $galleria[] = [
        'name' => $_FILES['galleria']['name'][$key],
        'type' => $_FILES['galleria']['type'][$key],
        'tmp_name' => $_FILES['galleria']['tmp_name'][$key],
        'error' => $_FILES['galleria']['error'][$key],
        'size' => $_FILES['galleria']['size'][$key]
      ];
      $galleria_alt[] = $alt;
    }
  }
}

$success = FALSE;
if (
  $nome && $provincia && $descrizione && $costo_fisso != null && $lunghezza && $larghezza && $n_curve && $dislivello !== null && $rettilineo != null && $img
) {
  $conn = connectDB();
  if ($conn) {
    if($conn->begin_transaction()) {
      if (savePista($nome, $provincia, $descrizione, $costo_fisso, $lunghezza, $larghezza, $n_curve, $dislivello, $rettilineo,
        $img, $img_alt, $galleria, $galleria_alt)) {
        $conn->commit();
        $success = TRUE;
      } else {
        $conn->rollback();
      }
    }
    closeConn();
  }
}

startSession();
$_SESSION['flow'] = [
  'last_action' => 'addpista',
  'success' => $success,
  'nome' => $nome,
  'provincia' => $provincia,
  'descrizione' => $descrizione,
  'costo_fisso' => $costo_fisso,
  'lunghezza' => $lunghezza,
  'larghezza' => $larghezza,
  'n_curve' => $n_curve,
  'dislivello' => $dislivello,
  'rettilineo' => $rettilineo,
  'img' => $img
];

header('Location: area_riservata.php?section=pista');

<?php
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";
  
  if ($_SERVER['REQUEST_METHOD'] != 'POST' || !is_user_admin()) {
    header('Location: index.php');
    exit();
  }
  
  $nome = sanitize_input_string(INPUT_POST, 'nome');
  if ($nome && strlen($nome) > 64)  {
    $nome = null;
  }
  $costo_km = sanitize_input_float(INPUT_POST, 'costo_km');
  $categoria = sanitize_input_string(INPUT_POST, 'categoria');
  if ($categoria && strlen($categoria) > 64)  {
    $categoria = null;
  }
  $descrizione = sanitize_input_string(INPUT_POST, 'descrizione');

  $img = null;
  $img_alt = sanitize_input_string(INPUT_POST, 'img_alt');
  if ($img_alt !== null && strlen($img_alt) <= 256 && isset($_FILES['img']) &&
      $_FILES['img']['error'] === UPLOAD_ERR_OK &&
      explode('/', $_FILES['img']['type'])[0] == 'image') {
    $img = $_FILES['img'];
  }

  $specifiche = null;
  if (isset($_POST['specifica_nome']) && gettype($_POST['specifica_nome']) == 'array' &&
      isset($_POST['specifica_valore']) && gettype($_POST['specifica_valore'] == 'array') &&
      count($_POST['specifica_nome']) == count($_POST['specifica_valore'])) {
    $specifiche = [];
    foreach ($_POST['specifica_nome'] as $k => $n) {
      $n = sanitize_string($_POST['specifica_nome'][$k]);
      $v = sanitize_string($_POST['specifica_valore'][$k]);
      if ($n && $v && strlen($n) <= 256 && strlen($v) <= 256) {
        $specifiche[$n] = $v;
      }
    }
  }

  $galleria = [];
  $galleria_alt = [];
  if (isset($_FILES['galleria']) && gettype($_FILES['galleria']['error']) == 'array' &&
      isset($_POST['galleria_alt']) && gettype($_POST['galleria_alt'] == 'array') &&
      count($_FILES['galleria']['error']) == count($_POST['galleria_alt'])) {
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
  if ($nome && $costo_km && $categoria && $descrizione && $img && $specifiche) {
    if (saveModello($nome, $costo_km, $categoria, $descrizione, $specifiche, $img, $img_alt, $galleria, $galleria_alt))
      $success = TRUE;
  }
  
startSession();
$_SESSION['flow'] = [
  'last_action' => 'addmodello',
  'success' => $success,
  'nome' => $nome,
  'costo_km' => $costo_km,
  'categoria' => $categoria,
  'descrizione' => $descrizione,
  'img' => $img,
  'specifiche' => $specifiche
];

header('Location: area_riservata.php?section=modello');

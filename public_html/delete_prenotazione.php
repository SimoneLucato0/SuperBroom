<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_user_logged()) {
  $id = sanitize_input_int(INPUT_POST, 'id');
  $p = getPrenotazioneById($id);
  $success = false;
  
  if ($id !== null && (is_user_admin() || $p['utente']['id'] === getCurrentUser()['id']) && deletePrenotazione($id)) {
    $success = true;
  }
  startSession();
  $_SESSION['flow'] = [
    'last_action' => 'deleteprenotazione',
    'id' => $id,
    'success' => $success
  ];
  header('Location: area_riservata.php?section=prenotazioni');
} else {
  header('Location: index.php');
}

<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_user_logged()) {

  $username = sanitize_input_string(INPUT_POST, 'username');
  if ($username && strlen($username) > 256) {
    $username = null;
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
  if ($nome && strlen($nome) > 256) {
    $nome = null;
  }
  $nascita = sanitize_input_date(INPUT_POST, 'nascita', ['max' => date('Y-m-d')]);

  $ok = [false, false, false];
  startSession();
  if (getCurrentUser()['username'] == $username) {
    if ($pw && $cognome && $nome && $mail && $nascita) {
      $ok = update_user($username, $pw, $cognome, $nome, $mail, $nascita);
      if ($ok[0] || $ok[1]) {
        refresh_logged_user();
      }
    }
  }
  $_SESSION['flow'] = [
    'last_action' => 'anagrafica',
    'success' => $ok[0],
    'pw_success' => $pw && $ok[1],
    'anagrafica_success' => $ok[0] && $ok[2],
    'username' => $username,
    'pw' => $pw,
    'cognome' => $cognome,
    'nome' => $nome,
    'mail' => $mail,
    'nascita' => $nascita
  ];
  header('Location: area_riservata.php?section=anagrafica');
} else {
  header('Location: index.php');
}
exit();

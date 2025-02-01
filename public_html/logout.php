<?php
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

  logout();
  $next = sanitize_input_string(INPUT_GET, 'next');
  if (!$next) {
      $next = 'index.php';
  }
  header('Location: '.$next);
  exit();
?>
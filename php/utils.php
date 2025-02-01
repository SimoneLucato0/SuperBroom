<?php
  function echoHeader() {
    include "components/header.php";
  }

  function echoFooter() {
    include "components/footer.php";
  }

  function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }
?>
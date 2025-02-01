<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";
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

  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
  <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
  <script src="js/index.js"></script>

  <title>Grazie - SuperBroom</title>
</head>
<body>
  <a href="#grazie" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
    <?php echoHeader() ?>
    <section id="grazie" class="grazie-section container">
        <h1>Grazie!</h1>
        <h2>Abbiamo ricevuto la tua prenotazione. Riceverai a breve una <span xml:lang="en" lang="en"> mail di conferma. </span> </h2>
        <div class="easter-egg" title="No, non è vero,inutile che aspetti, non riceverai nessuna email..è solo un progetto didattico, lol"> </div>
      </section>
    <?php echoFooter() ?>
</body>

</html>
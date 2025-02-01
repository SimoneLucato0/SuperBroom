<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

$modello = sanitize_input_string(INPUT_GET, 'modello');
$modello = getModelloByNome($modello);
if (!$modello) {
  header("Location: 404.php");
  exit();
}
$piste = getPistaList();
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="keywords" content="supercar,auto, automobile, auto, macchina, motore, potenza, velocità, Ferrari, Stelvio, Lamborghini, pista, noleggio, Superbroom"/>
  <meta name="description" content="Progetto di Tecnologie Web, Scheda tecnica dell'auto"/>
  <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
  <link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
  <script src="js/index.js"></script>

  <title><?php echo ("{$modello['nome']} - SuperBroom"); ?></title>
</head>

<body onload="initCarousel()">
  <a href="#carousel" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>

  <?php echoHeader() ?>

  <nav class="breadcrumb">
    <div class="container">
      <p>
        Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt;
        <a href="automobili.php"> Automobili</a> &gt; <?php echo ($modello['nome']) ?>
      </p>
    </div>
  </nav>

  <div class="carousel container">
    <a href="#specifics" class="sr" aria-label="Vai alle specifiche">Salta il carosello</a>
    <section id="carousel"  aria-label="Carosello di immagini di <?php echo ($modello['nome']) ?>" aria-live="polite" aria-atomic="true">
      <ul id="carousel-image-list">
        <li class="slide" data-slide="0"  aria-label="Slide 1 di <?php echo (count($modello['galleria']) + 1); ?>">
          <img src="<?php echo ($modello['img']['path']); ?>" alt="<?php echo ($modello['img']['alt']); ?>"/>
        </li>
        <?php foreach ($modello['galleria'] as $n => $img) : ?>
          <li class="slide hidden" data-slide="<?php echo ($n + 1); ?>" tabindex="-1"  aria-label="Slide <?php echo ($n + 1)?> di <?php echo (count($modello['galleria']) + 1); ?>">
            <img src="<?php echo ($img['path']); ?>" alt="<?php echo ($img['alt']); ?>"/>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="carousel-actions" >
        <button id="previous-carousel" class="button previous" onclick="prevSlide()">
          Slide precedente
        </button>
        <button id="next-carousel" class="button next" onclick="nextSlide()">
          Slide successiva
        </button>
      </div>
    </section>

    <ul id="carousel-buttons">
      <li><button data-slide="0" class="carousel-single-button current" aria-current="true" aria-label="Slide 1 di <?php echo (count($modello['galleria'])+1)?>">1</button></li>
      <?php foreach ($modello['galleria'] as $n => $img) : ?>
        <li><button data-slide="<?php echo ($n); ?>" class="carousel-single-button" aria-label="Slide <?php echo ($n + 2); ?> di <?php echo (count($modello['galleria'])+1)?>"><?php echo ($n + 2); ?></button></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div id="specifics" class="specifics container">
    <div class="card">
      <h1><?php echo ("{$modello['nome']} - {$modello['categoria']}"); ?></h1>
      <p><?php echo ($modello['descrizione']); ?></p>
    </div>
    <div class="card">
      <h2>Specifiche tecniche</h2>
      <ul>
        <?php foreach ($modello['specifiche'] as $k => $v) : ?>
          <li><?php echo ("$k: $v"); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <form method="POST" action="recap.php" onsubmit="return validateChoice()">
    <input type="hidden" name="modello" value="<?php echo ($modello['nome']); ?>" />
    <div class="error-message hidden"></div>
    <div id="choice-container" class="choose-circuit container">
      <fieldset>
        <legend>Scegli la pista</legend>
        <ul id="choice-gallery" class="gallery">
          <?php foreach ($piste as $k => $p) : ?>
            <li class="gallery-item" data-slide="<?php echo ($k); ?>" tabindex="0">
              <input class="sr" type="radio" tabindex="<?php echo ($k) ?>" name="pista" id="radio-pista-<?php echo ($k) ?>" value="<?php echo ($p['nome']) ?>" onclick="setChoice(event)" required="required" />
              <label for="radio-pista-<?php echo ($k) ?>" aria-label="<?php echo ($p['nome']) ?>">
                <img src="<?php echo ($p['img']['path']) ?>" alt="<?php echo ($p['img']['alt']) ?>"/>
                <span><?php echo ($p['nome']) ?></span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    </div>

    <div class="choice-recap container" aria-live="polite" aria-atomic="true">
      <div id="choice-display">
        Scegli un circuito
      </div>
      <div id="button-container">
        <button class="button" type="submit">Visualizza le date disponibili</button>
      </div>
    </div>
  </form>

  <a id="torna-su" class="button" title="Torna all'inizio della pagina" aria-label="Torna su" href="#">Torna su</a>

  <?php echoFooter() ?>
</body>

</html>
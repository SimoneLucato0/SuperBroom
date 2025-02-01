<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

$pista = sanitize_input_string(INPUT_GET, 'pista');
$pista = getPistaByNome($pista);
if (!$pista) {
  header("Location: 404.php");
  exit();
}
$modelli = getModelloList();
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="keywords" content="Superbroom, autodromo, pista, lunghezza, circuito, curve, rettilineo, "/>
        <meta name="description" content="Progetto di Tecnologie Web, Scheda tecnica della pista"/>
        <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
  <link rel="stylesheet" type="text/css" media="print" href="css/print.css" />

  <script src="js/index.js"></script>

  <title><?php echo ("{$pista['nome']} - SuperBroom"); ?></title>
</head>

<body onload="initCarousel()">
  <a href="#carousel" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
  <?php echoHeader() ?>

  <nav class="breadcrumb">
    <div class="container">
      <p>
        Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt;
        <a href="piste.php">Tutte le piste</a> &gt; <?php echo ($pista['nome']) ?>
      </p>
    </div>
  </nav>

  <div class="carousel container">
    <a href="#specifics" class="sr" aria-label="Vai alle specifiche">Salta il carosello</a>
    <section id="carousel" aria-label="Carosello di immagini di <?php echo ($pista['nome']) ?>">
      <ul id="carousel-image-list">
        <li class="slide" data-slide="0" aria-label="Slide 1 di <?php echo (count($pista['galleria']) + 1); ?>">
          <img src="<?php echo ($pista['img']['path']); ?>" alt="<?php echo ($pista['img']['alt']); ?>"/>
        </li>
        <?php foreach ($pista['galleria'] as $n => $img) : ?>
          <li class="slide hidden" data-slide="<?php echo ($n + 1); ?>" tabindex="-1"  aria-label="Slide <?php echo ($n + 1); ?> di <?php echo (count($pista['galleria']) + 1); ?>">
            <img src="<?php echo ($img['path']); ?>" alt="<?php echo ($img['alt']); ?>"/>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="carousel-actions">
        <button id="previous-carousel" class="button previous" onclick="prevSlide()">
          Slide precedente
        </button>
        <button id="next-carousel" class="button next" onclick="nextSlide()">
          Slide successiva
        </button>
      </div>
    </section>

    <ul id="carousel-buttons">
      <li><button data-slide="0" class="carousel-single-button current" aria-current="true">1</button></li>
      <?php foreach ($pista['galleria'] as $n => $img) : ?>
        <li><button data-slide="<?php echo ($n); ?>" class="carousel-single-button"><?php echo ($n + 1); ?></button></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div id="specifics" class="specifics container">
    <div class="card">
      <h1><?php echo ("{$pista['nome']} - {$pista['provincia']}"); ?></h1>
      <p><?php echo ($pista['descrizione']); ?></p>
    </div>
    <div class="card">
      <h2>Specifiche tecniche</h2>
      <ul>
        <li>Lunghezza circuito: <?php echo ($pista['lunghezza']); ?> <abbr title="chilometri">km</abbr></li>
        <li>Larghezza pista: <?php echo ($pista['larghezza']); ?> <abbr title="metri">m</abbr></li>
        <li>Numero di curve: <?php echo ($pista['n_curve']); ?></li>
        <li>Dislivello: <?php echo ($pista['dislivello']); ?> <abbr title="metri">m</abbr></li>
        <li>Lunghezza rettilineo: <?php echo ($pista['rettilineo']); ?> <abbr title="chilometri">km</abbr></li>
      </ul>
    </div>
  </div>

  <form method="POST" action="recap.php" onsubmit="return validateChoice()">
    <input type="hidden" name="pista" value="<?php echo ($pista['nome']); ?>" />
    <div class="error-message hidden"></div>
    <div id="choice-container" class="choose-circuit container">
      <fieldset>
        <legend>Scegli la macchina</legend>
        <ul id="choice-gallery" class="gallery">
          <?php foreach ($modelli as $k => $m) : ?>
            <li class="gallery-item" data-slide="<?php echo ($k); ?>">
              <input class="sr" type="radio" name="modello" id="radio-modello-<?php echo ($k) ?>" value="<?php echo ($m['nome']) ?>" onclick="setChoice()" required="required" />
              <label for="radio-modello-<?php echo ($k) ?>">
                <img src="<?php echo ($m['img']['path']) ?>" alt="<?php echo ($m['img']['alt']) ?>"/>
                <span><?php echo ($m['nome']) ?></span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    </div>

    <div class="choice-recap container" aria-live="polite" aria-atomic="true">
      <div id="choice-display">
        Scegli una macchina
      </div>
      <div id="button-container">
        <button class="button" type="submit">Visualizza le date disponibili</button>
      </div>
    </div>
  </form>


  <a id="torna-su" class="button" href="#">Torna su</a>

  <?php echoFooter() ?>
</body>

</html>
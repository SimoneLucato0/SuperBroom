<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";

$modelli = getModelloList();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="supercar,auto, automobile, macchina, Alfa Romeo, Ferrari, Lamborghini, Huracan, Portofino, Quadrifoglio, SF90, pista, noleggio, Superbroom"/>
    <meta name="description" content="Progetto di Tecnologie Web, Automobili del sito"/>
    <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <script src="js/index.js"></script>

    <title>Automobili - SuperBroom</title>
</head>

<body onload="initPage()">
    <a href="#le-auto" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>

    <?php echoHeader() ?>

    <nav class="breadcrumb">
        <div class="container">
            <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Automobili</p>
        </div>
    </nav>

    <section id="le-auto" class="container le-auto">
        <h1> Tutte le nostre vetture</h1>
        <div class="gallery">
            <?php foreach ($modelli as $m) : ?>
                <div class="gallery-item">
                    <img src="<?php echo ($m['img']['path']); ?>" alt="<?php echo ($m['img']['alt']); ?>">
                    <p><?php echo ($m['nome']); ?></p>
                    <a class="button" title="Scheda tecnica di <?php echo ($m['nome']); ?>" href="<?php echo ("auto.php?modello={$m['nome']}"); ?>">Scheda tecnica</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <a id="torna-su" class="button" href="#">Torna su</a>

    <?php echoFooter() ?>
</body>

</html>
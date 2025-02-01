<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";

$piste = getPistaList();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="pista, autodromo, noleggio, Mugello, Paletti, Simoncelli, Superbroom, Imola, Monza"/>
    <meta name="description" content="Progetto di Tecnologie Web, Piste del sito"/>
    <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <script src="js/index.js"></script>
    <title>Piste - SuperBroom</title>
</head>

<body onload="initPage()">
    <a href="#le-piste" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>

    <?php echoHeader() ?>

    <nav class="breadcrumb">
        <div class="container">
            <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Tutte le piste</p>
        </div>
    </nav>

    <section id="le-piste" class="container le-piste">
        <h1> Tutte le piste</h1>
        <div class="gallery">
            <?php foreach ($piste as $p) : ?>
                <div class="gallery-item">
                    <img src="<?php echo ($p['img']['path']); ?>" alt="<?php echo ($p['img']['alt']); ?>">
                    <p><?php echo ($p['nome']); ?></p>
                    <a class="button" title="Scheda tecnica di <?php echo ($p['nome']); ?>" href="<?php echo ("pista.php?pista={$p['nome']}"); ?>">Scheda tecnica</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <a id="torna-su" class="button" href="#">Torna su</a>
    <?php echoFooter() ?>

</body>


</html>
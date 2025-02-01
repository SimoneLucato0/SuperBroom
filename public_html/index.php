<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";

$modelli = array_slice(getModelloList(), 0, 3);
$piste = array_slice(getPistaList(), 0, 3);
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="supercar,auto, automobile, pista, noleggio, Superbroom"/>
        <meta name="description" content="Progetto di Tecnologie Web, Home del sito"/>
        <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>

    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
        <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
        <script  src="js/index.js"></script>
        <title>Home - Super Broom</title>
    </head>

    <body onload="initPage()">
        <a href="#main" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>

        <?php echoHeader() ?>
        <div class="index">
            <nav class="breadcrumb">
                <div class="container">
                 <p> Ti trovi in: <span xml:lang="en" lang="en">Home</span>
                    </p>
                </div>
            </nav>
        </div>
        <section id="main" class="welcome">
            <div class="container welcome-content">
                <h1>Goditi un'esperienza in pista indimenticabile</h1>
                <a class="button" href="automobili.php">Scopri tutte le auto</a>
            </div>
        </section>

        <div class="intro container">
            <p>Se vuoi guidare l'auto dei tuoi sogni nei migliori circuiti in Italia e all'estero sei nel posto giusto! <p>
            <p>Con noi di SuperBroom puoi <strong>noleggiare le migliori supercar</strong> in commercio per vivere un'<strong>esperienza in pista</strong> indimenticabile!</p>
</div>

        <div class="content-automobili container">
            <h2>Scopri le nostre auto</h2>
            <ul class="gallery">
                <?php foreach ($modelli as $m) : ?>
                <li class="gallery-item">
                    <a class="black" href="<?php echo ("auto.php?modello={$m['nome']}"); ?>">
                        <img src="<?php echo ($m['img']['path']); ?>" alt="<?php echo ($m['img']['alt']); ?>">
                        <p><?php echo ($m['nome']); ?></p>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <a class="button"  href="automobili.php">Tutte le auto</a>
                </div>

        <section class="content-piste container">
            <h2>Scopri le nostre piste</h2>
            <ul class="gallery">
                <?php foreach ($piste as $p) : ?>
                    <li class="gallery-item">
                        <a class="black" href="<?php echo ("pista.php?pista={$p['nome']}"); ?>"><img src="<?php echo ($p['img']['path']); ?>" alt="<?php echo ($p['img']['alt']); ?>">
                            <p><?php echo ($p['nome']); ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="button"  href="piste.php">Tutte le piste</a>
        </section>

        <a id="torna-su" class="button" href="#">Torna su</a>

        <?php echoFooter() ?>

    </body>
</html>

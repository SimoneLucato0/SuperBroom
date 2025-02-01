<?php
    include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <script src="js/index.js"></script>
    <title>404 - Super Broom</title>
</head>
<body>
    <a href="#container-404" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
    <?php echoHeader() ?>
    <section id="container-404" class="container container-404">
        <h2>Ci dispiace, il contenuto che stai cercando non è disponibile.<br>
            Mentre Cricchetto lavora per sistemare il problema, puoi tornare alla pagina principale.
        </h2>
        <div class="button-img">
            <a class="button" href="index.php">Torna alla <span lang="en">home page</span></a>
            <img src="images/404.png" alt="Disegno di un personaggio a forma di carro attrezzi di un famoso cartone animato per bambini sulle automobili. Di colore marrone e sorridente">
        </div>
        
    </section>
    <?php echoFooter() ?>
</body>
</html>
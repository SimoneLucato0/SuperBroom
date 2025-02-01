<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = sanitize_input_string(INPUT_POST, 'nome');
    $cognome = sanitize_input_string(INPUT_POST, 'cognome');
    $mail = validate_input_mail(INPUT_POST, 'mail');
    $messaggio = sanitize_input_string(INPUT_POST, 'messaggio');

    $sent = false;
    if ($nome && $cognome && $mail && $messaggio) {
        $testo = "Nome utente: $nome\n" .
            "Cognome utente: $cognome\n" .
            "Mail utente: $mail\n" .
            "Messaggio:\n$messaggio";
        // non avendo a disposizione un server mail, assumiamo che le mail vengano sempre inviate correttamente
        $sent = true || mail('admin@superbroom.it', 'Richiesta di contatto da Superbroom', $testo);
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Superbroom, contattaci, mail, socials, instagram, facebook"/>
    <meta name="description" content="Progetto di Tecnologie Web, Contattaci"/>
    <meta name="author" content="Greggio, Lucato, Scandaletti, Zorzet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css">
    <script src="js/index.js"></script>

    <title>Contattaci - SuperBroom</title>
</head>

<body onload="initContattaci()">
    <a href="#contacts" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>

    <?php echoHeader() ?>

    <nav class="breadcrumb">
        <div class="container">
            <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Contattaci</p>
        </div>
    </nav>

    <section id="contacts" class="contacts-container container">
        <h1> Compila il form e verrai ricontattato al più presto </h1>
        <div class="contact-us">
            <div class="superbroom-info">
                <div class="superbroom-address">
                    <p>SuperBroom S.r.l</p>
                    <p>Via Trieste 63</p>
                    <p>35121 Padova PD</p>
                    <h2>Indicazioni per raggiungerci</h2>
                    <p>Dalla stazione di Padova, prendere il 6 o il 14 e scendere dopo due fermate. Attraversate la strada al semaforo poco dopo la fermata. Procedere dritto per 5 minuti. All'altezza di un ponte di ferro sulla destra, proseguire sulla discesa alla vostra sinistra, attraversate la strada e sarà il primo edificio di fronte a voi, leggermente spostato a sinistra.
                </div>
                <iframe title="Mappa per raggiungere SuperBroom s.r.l." src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2800.9180210320415!2d11.885364615212303!3d45.4109926791003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477eda5c6e97de91%3A0x84377cee1c8c8598!2sTorre%20Archimede!5e0!3m2!1sit!2sit!4v1640704866492!5m2!1sit!2sit" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <form class="contact-us-form" id="form-contacts" action="contatti.php" method="post">
                <?php if (isset($sent) && $sent) : ?>
                    <div class="success">
                        Il messaggio è stato inviato con successo!
                    </div>
                <?php elseif (isset($sent)) : ?>
                    <div class="error">
                        Il messaggio non è stato inviato correttamente. Puoi provare a rimandare il messaggio o contattarci al <a href="tel:+12 34567890">+12 34567890</a>
                    </div>
                <?php endif; ?>
                <div class="input-row">
                    <label for="contact-us-nome">Nome</label>
                    <input type="text" id="contact-us-nome" name="nome" placeholder="Nome.." <?php if (isset($sent) && !$sent && $nome) echo (" value=\"$nome\""); ?>/>
                    <div class="error">
                        <?php if (isset($sent) && !$sent && !$nome) : ?>
                            Il nome non può essere vuoto.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="input-row">
                    <label for="contact-us-cognome">Cognome</label>
                    <input type="text" id="contact-us-cognome" name="cognome" placeholder="Cognome.." <?php if (isset($sent) && !$sent && $cognome) echo (" value=\"$cognome\""); ?> />
                    <div class="error">
                        <?php if (isset($sent) && !$sent && !$cognome) : ?>
                            Il cognome non può essere vuoto.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="input-row">
                    <label for="contact-us-email">Email</label>
                    <input type="email" id="contact-us-email" name="mail" placeholder="indirizzo email.." <?php if (isset($sent) && !$sent && $mail) echo (" value=\"$mail\""); ?> />
                    <div class="error">
                        <?php if (isset($sent) && !$sent && !$mail) : ?>
                            L'email inserita non è valida.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="input-row">
                    <label for="contact-us-message">Messaggio</label>
                    <textarea id="contact-us-message" name="messaggio" placeholder="Scrivi il tuo messaggio..."><?php if (isset($sent) && !$sent && $messaggio) echo ($messaggio); ?></textarea>
                    <div class="error">
                        <?php if (isset($sent) && !$sent && !$messaggio) : ?>
                            Il messaggio inserito non può essere vuoto.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="button">Invia</button>
                </div>
            </form>
        </div>
    </section>

    <a id="torna-su" class="button" title="Torna all'inizio della pagina" aria-label="Torna su" href="#">Torna su</a>

    <?php echoFooter() ?>
</body>

</html>
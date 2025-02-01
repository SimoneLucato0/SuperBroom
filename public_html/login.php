<?php
    include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
    include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
    include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

    $next = sanitize_input_string(INPUT_GET, 'next');
    if (!$next) {
        $next = 'index.php';
    }

    $username = sanitize_input_string(INPUT_POST, 'username');
    $password = sanitize_input_string(INPUT_POST, 'password');
    $success = false;

    if ($username && $password) {
        $success = login($username, $password);
    }
    if (is_user_logged()) {
        header('Location: '.$next);
        exit();
    }
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
    <title>Accedi - SuperBroom</title>
</head>

<body onload="initLogin()">
    <a href="#login" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
    <?php echoHeader() ?>

    <nav class="breadcrumb">
        <div class="container">
            <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Area riservata</p>
        </div>
    </nav>

    <div class="container">
        <form class="user-data-form" id="login" action="login.php?next=<?php echo $next; ?>" method="post">
            <h1>Accedi</h1>
            <div class="input-row">
                <label for="username"> <span xml:lang="en" lang="en">Username</span></label>
                <input id="username" name="username" type="text">
                <div class="error"></div>
            </div>
            <div class="input-row <?php if (!$success && $username) echo("error");?>">
                <label for="password"><span xml:lang="en" lang="en">Password</span></label>
                <input id="password" name="password" type="password">
                <div class="error"><?php if (!$success && $username) echo("Password errata");?></div>
            </div>
            <button class="button" type="submit"><span xml:lang="en" lang="en">Login</span></button>
            <h2>Oppure <a href="signup.php">crea un nuovo account</a></h2>
        </form>
    </div>

    <a id="torna-su" class="button" href="#">Torna su</a>
    
    <?php echoFooter() ?>
</body>
</html>
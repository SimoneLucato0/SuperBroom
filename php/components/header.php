
<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
?>
<header class="header">
    <div class="container">
        <nav class="nav-bar">
            <a class="header-logo" <?php
            if(strpos(explode("?",$_SERVER['REQUEST_URI'])[0], "index.php") === FALSE) {
                echo('href="index.php"');
            }
            ?>>SuperBroom</a>
            <ul class="nav-menu">
                <?php
                $links = array();
                $links["automobili.php"] = "Automobili";
                $links["piste.php"] = "Piste";
                $links["contatti.php"] = "Contattaci";
                $links["area_riservata.php"] = "Area riservata";
                if(is_user_logged()) {
                    $links["logout.php?next=".$_SERVER['REQUEST_URI']] = "Esci";
                } else {
                    $links["login.php?next=".$_SERVER['REQUEST_URI']] = "Accedi";
                }
                foreach ($links as $uri => $titolo) {
                    if(strpos(explode("?", $_SERVER['REQUEST_URI'])[0], $uri) === FALSE) {
                        echo('<li class="header-link"><a href="'.$uri.'">'.$titolo.'</a></li>');
                    } else {
                        echo('<li class="header-item">'.$titolo.'</li>');
                    }
                }
                ?>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </div>
</header>
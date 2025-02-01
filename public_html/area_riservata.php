<?php
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/auth.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";
include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/validate.php";

requires_user_logged();
$user = getCurrentUser();

startSession();
$lastAction = null;

if (isset($_SESSION['flow']['last_action'])) {
  $lastAction = $_SESSION['flow']['last_action'];
}

if ($lastAction === 'addmodello') {
  $success = $_SESSION['flow']['success'];
  $nome = $_SESSION['flow']['nome'];
  $costo_km = $_SESSION['flow']['costo_km'];
  $categoria = $_SESSION['flow']['categoria'];
  $descrizione = $_SESSION['flow']['descrizione'];
  $img = $_SESSION['flow']['img'];
  $specifiche = $_SESSION['flow']['specifiche'];
  unset($_SESSION['flow']);
} elseif ($lastAction === 'addpista') {
  $success = $_SESSION['flow']['success'];
  $nome = $_SESSION['flow']['nome'];
  $provincia = $_SESSION['flow']['provincia'];
  $descrizione = $_SESSION['flow']['descrizione'];
  $costo_fisso = $_SESSION['flow']['costo_fisso'];
  $lunghezza = $_SESSION['flow']['lunghezza'];
  $larghezza = $_SESSION['flow']['larghezza'];
  $n_curve = $_SESSION['flow']['n_curve'];
  $dislivello = $_SESSION['flow']['dislivello'];
  $rettilineo = $_SESSION['flow']['rettilineo'];
  $img = $_SESSION['flow']['img'];
  unset($_SESSION['flow']);
} elseif ($lastAction === 'anagrafica') {
  $success = $_SESSION['flow']['success'];
  $okp = $_SESSION['flow']['pw_success'];
  $oka = $_SESSION['flow']['anagrafica_success'];
  $username = $_SESSION['flow']['username'];
  $pw = $_SESSION['flow']['pw'];
  $cognome   = $_SESSION['flow']['cognome'];
  $nome = $_SESSION['flow']['nome'];
  $mail = $_SESSION['flow']['mail'];
  $nascita = $_SESSION['flow']['nascita'];
  unset($_SESSION['flow']);
} elseif ($lastAction === 'deleteprenotazione') {
  $id = $_SESSION['flow']['id'];
  $success = $_SESSION['flow']['success'];
  unset($_SESSION['flow']);
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
  <title>Area riservata - SuperBroom</title>
</head>

<body onload="initReservedArea()">
  <a href="#action-selector" class="sr" aria-label="Vai al contenuto">Salta la navigazione</a>
  <?php echoHeader(); ?>
  <div class="areariservata">
    <nav class="breadcrumb">
      <div class="container">
        <p>Ti trovi in: <span xml:lang="en" lang="en"><a href="index.php">Home</a></span> &gt; Area Riservata</p>
      </div>
    </nav>
  </div>
  <div id="action-selector" class="action-selector">
    <nav class="container">
      <ul id="area-riservata-menu" class="nav-menu" role="tablist">
        <li class="header-item" role="tab" aria-selected="true" aria-posinset="1" aria-controls="anagrafica">
          <button id="anagrafica-button" class="header-button" onclick="showSection('anagrafica')" disabled>Anagrafica</button>
        </li>
        <?php if (is_user_admin()) : ?>
          <li class="header-item" role="tab" aria-selected="false" aria-posinset="2" aria-controls="add-modello-container">
            <button id="add-modello-container-button" class="header-button" onclick="showSection('add-modello-container')">Aggiungi modello</button>
          </li>
          <li class="header-item" role="tab" aria-selected="false" aria-posinset="3" aria-controls="add-pista-container">
            <button id="add-pista-container-button" class="header-button" onclick="showSection('add-pista-container')">Aggiungi pista</button>
          </li>
          <li class="header-item" role="tab" aria-selected="false" aria-posinset="4" aria-controls="lista-prenotazioni">
            <button id="lista-prenotazioni-button" class="header-button" onclick="showSection('lista-prenotazioni')">Visualizza tutte le prenotazioni</button>
          </li>
        <?php else : ?>
          <li class="header-item" role="tab" aria-selected="false" aria-posinset="2" aria-controls="lista-prenotazioni">
            <button id="lista-prenotazioni-button" class="header-button" onclick="showSection('lista-prenotazioni')">Le tue prenotazioni</button>
          </li>
        <?php endif; #is_user_admin()   
        ?>
      </ul>
    </nav>
  </div>

  <div id="area-riservata-container">
    <div id="anagrafica" class="container" role="tabpanel" aria-hidden="false" aria-expanded="true" aria-labelledby="anagrafica-button">
      <form id="anagrafica-form" action="anagrafica.php" method="post" onsubmit="return validateAnagraficaInput()">
        <h1>Anagrafica</h1>
        <?php
        if ($lastAction === 'anagrafica') {
          if ($username != getCurrentUser()['username']) {
            echo ("<div class='error-message'>Non è possibile modificare il proprio nome utente.</div>");
          } elseif ($oka || $okp) {
            if ($oka) {
              echo ("<div class='success-message'>Anagrafica aggiornata con successo.</div>");
            }
            if ($okp) {
              echo ("<div class='success-message'>Password aggiornata con successo.</div>");
            }
          } elseif ($pw && $cognome && $nome && $mail && $nascita) {
            echo ("<div class='error-message'>Non è stato possibile aggiornare l'anagrafica.</div>");
          }
        }
        ?>
        <div class="grid-container">
          <div class="grid-item">
            <label for="anagrafica-username"><span xml:lang="en" lang="en">Username</span></label>
          </div>
          <div class="grid-item">
            <div class="input-row">
              <input type="text" name="username" id="anagrafica-username" value="<?php echo ($user['username']); ?>" readonly aria-disabled="true" />
            </div>
          </div>

          <div class="grid-item">
            <label for="anagrafica-nome">Nome</label>
          </div>
          <div class="grid-item">
            <div class="input-row <?php if ($lastAction === 'anagrafica' && !$nome) echo ("error"); ?>">
              <input type="text" name="nome" id="anagrafica-nome" value="<?php echo ($user['anagrafica']['nome']); ?>" />
              <div class="error <?php if ($lastAction !== 'anagrafica' || $nome) echo ("hidden"); ?>"><?php if ($lastAction === 'anagrafica' && !$nome) echo ("Nome obbligatorio."); ?></div>
            </div>
          </div>

          <div class="grid-item">
            <label for="anagrafica-cognome">Cognome</label>
          </div>
          <div class="grid-item">
            <div class="input-row <?php if ($lastAction === 'anagrafica' && !$cognome) echo ("error"); ?>">
              <input type="text" name="cognome" id="anagrafica-cognome" value="<?php echo ($user['anagrafica']['cognome']); ?>" />
              <div class="error <?php if ($lastAction !== 'anagrafica' || $cognome) echo ("hidden"); ?>"><?php if ($lastAction === 'anagrafica' && !$cognome) echo ("Cognome obbligatorio."); ?></div>
            </div>
          </div>

          <div class="grid-item">
            <label for="anagrafica-mail">E-mail</label>
          </div>
          <div class="grid-item">
            <div class="input-row <?php if ($lastAction === 'anagrafica' && !$mail) echo ("error"); ?>">
              <input type="email" name="mail" id="anagrafica-mail" value="<?php echo ($user['anagrafica']['mail']); ?>" />
              <div class="error <?php if ($lastAction !== 'anagrafica' || $mail) echo ("hidden"); ?>"><?php if ($lastAction === 'anagrafica' && !$mail) echo ("Email obbligatoria."); ?></div>
            </div>
          </div>

          <div class="grid-item">
            <label for="anagrafica-nascita">Data di nascita</label>
          </div>
          <div class="grid-item">
            <div class="input-row <?php if ($lastAction === 'anagrafica' && !$nascita) echo ("error"); ?>">
              <input type="date" name="nascita" id="anagrafica-nascita" value="<?php echo ($user['anagrafica']['data_nascita']); ?>" />
              <div class="error <?php if ($lastAction !== 'anagrafica' || $nascita) echo ("hidden"); ?>"><?php if ($lastAction === 'anagrafica' && !$nascita) echo ("Data di nascita obbligatoria."); ?></div>
            </div>
          </div>

          <div class="grid-item">
            <label for="anagrafica-pw">Cambia password</label>
          </div>
          <div class="grid-item">
            <div class="input-row">
              <input type="password" name="password" id="anagrafica-pw" />
              <div class="error hidden"></div>
            </div>
          </div>
          <button class="button" type="submit" value="submit">Aggiorna</button>
        </div>
      </form>
    </div>

    <?php if (is_user_admin()) : ?>
      <div id="add-modello-container" class="container" role="tabpanel" aria-hidden="true" aria-expanded="false" aria-labelledby="add-modello-container-button">
        <!--AGGIUNGE MODELLO-->
        <form id="add-modello-form" action="add_modello.php" method="post" enctype="multipart/form-data" onsubmit="return validateAddModelInput()">
          <h1>Aggiungi modello</h1>

          <?php if ($lastAction === 'addmodello') {
            if ($success) {
              echo ("<div class='success-message'>Modello aggiunto correttamente</div>");
            } elseif ($nome && $costo_km && $categoria && $descrizione && $img && $specifiche) {
              echo ("<div class='error-message'>Impossibile inserire il modello. Esiste già una modello con lo stesso nome</div>");
            }
          }
          ?>
          <div id="aggiungi-macchina-container" class="grid-container">
            <div class="grid-item">
              <label for="modello-nome">Nome (<abbr title="massimo">max</abbr> 64 caratteri)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$nome) echo ("error"); ?>">
                <input type="text" name="nome" id="modello-nome" maxlength="64" />
                <div class="error <?php if ($lastAction !== 'addmodello' || $nome) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$nome) echo ("Nome obbligatorio"); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="modello-categoria">Categoria (<abbr title="massimo">max</abbr> 64 caratteri)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$categoria) echo ("error"); ?>">
                <input type="text" name="categoria" id="modello-categoria" maxlength="64" />
                <div class="error <?php if ($lastAction !== 'addmodello' || $categoria) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$categoria) echo ("Categoria obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="modello-descrizione">Descrizione</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$descrizione) echo ("error"); ?>">
                <textarea name="descrizione" id="modello-descrizione"></textarea>
                <div class="error <?php if ($lastAction !== 'addmodello' || $descrizione) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$descrizione) echo ("Descrizione obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="modello-costo_km">Costo al <abbr title="chilometro">km</abbr> (€)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$costo_km) echo ("error"); ?>">
                <input type="number" step="0.01" name="costo_km" id="modello-costo_km" />
                <div class="error <?php if ($lastAction !== 'addmodello' || $costo_km) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$costo_km) echo ("Costo al chilometro obbligatorio."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="modello-specifica-nome">Nome specifica (<abbr title="massimo">max</abbr> 64 caratteri)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$specifiche) echo ("error"); ?>">
                <input type="text" name="specifica_nome[]" id="modello-specifica-nome" maxlength="64" />
                <div class="error <?php if ($lastAction !== 'addmodello' || $specifiche) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$specifiche) echo ("Almeno una specifica deve essere inserita."); ?></div>
              </div>
            </div>
            <div class="grid-item">
              <label for="modello-specifica-valore">Valore</label>
            </div>
            <div class="grid-item">
              <div class="input-row">
                <input type="text" name="specifica_valore[]" id="modello-specifica-valore" />
                <div class="error hidden"></div>
              </div>
            </div>
            <span></span>
            <button type="button" class="button grid-item" onclick="addSpecs()">Aggiungi specifica</button>

            <div class="grid-item">
              <label for="modello-immagine">Immagine di copertina</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addmodello' && !$img) echo ("error"); ?>">
                <input type="file" name="img" id="modello-immagine" />
                <div class="error <?php if ($lastAction !== 'addmodello' || $img) echo ("hidden"); ?>"><?php if ($lastAction === 'addmodello' && !$img) echo ("Immagine di copertina obbligatoria."); ?></div>
              </div>
            </div>
            <div class="grid-item">
              <label for="modello-immagine-alt">Testo alternativo all'immagine di copertina</label>
            </div>
            <div class="grid-item">
              <div class="input-row">
                <input type="text" name="img_alt" id="modello-immagine-alt" />
                <div class="error hidden"></div>
              </div>
            </div>
            <span></span>
            <button id="add-modello-image" type="button" class="button grid-item" onclick="addImageToModel()">Inserisci immagine nella galleria</button>
          </div>
          <button class="button" type="submit" value="submit">Aggiungi modello</button>
        </form>
      </div>

      <div id="add-pista-container" class="container" role="tabpanel" aria-hidden="true" aria-expanded="false" aria-labelledby="add-pista-container-button">
        <!--AGGIUNGE PISTA-->
        <form id="add-pista-form" action="add_pista.php" method="post" enctype="multipart/form-data" onsubmit="return validateAddCircuitInput()">
          <h1>Aggiungi pista</h1>

          <?php if ($lastAction === 'addpista') {
            if ($succ) {
              echo ("<div class='success-message'> Pista aggiunta correttamente</div>");
            } elseif ($nome && $provincia && $descrizione && $costo_fisso != null && $lunghezza && $larghezza && $n_curve && $dislivello !== null && $rettilineo != null && $img) {
              echo ("<div class='error-message'>Impossibile inserire la pista. Esiste già una pista con lo stesso nome</div>");
            }
          }
          ?>
          <div id="aggiungi-pista-container" class="grid-container">
            <div class="grid-item">
              <label for="pista-nome">Nome (<abbr title="massimo">max</abbr> 64 caratteri)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$nome) echo ("error"); ?>">
                <input type="text" name="nome" id="pista-nome" maxlength="64" />
                <div class="error <?php if ($lastAction !== 'addpista' || $nome) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$nome) echo ("Nome pista obbligatorio."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-provincia">Provincia (2 caratteri)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$provincia) echo ("error"); ?>">
                <input type="text" name="provincia" id="pista-provincia" maxlength="2" />
                <div class="error <?php if ($lastAction !== 'addpista' || $provincia) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$provincia) echo ("Provincia obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-descrizione">Descrizione</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$descrizione) echo ("error"); ?>">
                <textarea name="descrizione" id="pista-descrizione"></textarea>
                <div class="error <?php if ($lastAction !== 'addpista' || $descrizione) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$descrizione) echo ("Descrizione obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-costo_fisso">Costo Fisso (€)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && $costo_fisso === null) echo ("error"); ?>">
                <input type="number" step="0.01" name="costo_fisso" id="pista-costo_fisso" />
                <div class="error <?php if ($lastAction !== 'addpista' || $costo_fisso !== null) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && $costo_fisso === null) echo ("Immagine di copertina obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-lunghezza">Lunghezza pista (<abbr title="chilometri">km</abbr>)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$lunghezza) echo ("error"); ?>">
                <input type="number" step="0.001" name="lunghezza" id="pista-lunghezza" />
                <div class="error <?php if ($lastAction !== 'addpista' || $lunghezza) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$lunghezza) echo ("Lunghezza obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-larghezza">Larghezza pista (<abbr title="metri">m</abbr>)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$larghezza) echo ("error"); ?>">
                <input type="number" step="0.1" name="larghezza" id="pista-larghezza" />
                <div class="error <?php if ($lastAction !== 'addpista' || $larghezza) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$larghezza) echo ("Larghezza obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-n-curve">Numero di curve</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$n_curve) echo ("error"); ?>">
                <input type="number" step="1" name="n_curve" id="pista-n-curve" />
                <div class="error <?php if ($lastAction !== 'addpista' || $n_curve) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$n_curve) echo ("Numero curve obbligatorio."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-dislivello">Dislivello (<abbr title="metri">m</abbr>)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && $dislivello === null) echo ("error"); ?>">
                <input type="number" step="0.1" name="dislivello" id="pista-dislivello" />
                <div class="error <?php if ($lastAction !== 'addpista' || $dislivello !== null) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && $dislivello === null) echo ("Dislivello obbligatorio."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-rettilineo">Lunghezza rettilineo (<abbr title="chilometri">km</abbr>)</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$rettilineo === null) echo ("error"); ?>">
                <input type="number" step="0.001" name="rettilineo" id="pista-rettilineo" />
                <div class="error <?php if ($lastAction !== 'addpista' || $rettilineo !== null) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && $rettilineo === null) echo ("Immagine di copertina obbligatoria."); ?></div>
              </div>
            </div>

            <div class="grid-item">
              <label for="pista-immagine">Mappa della pista</label>
            </div>
            <div class="grid-item">
              <div class="input-row <?php if ($lastAction === 'addpista' && !$img) echo ("error"); ?>">
                <input type="file" name="img" id="pista-immagine" />
                <div class="error <?php if ($lastAction !== 'addpista' || $img) echo ("hidden"); ?>"><?php if ($lastAction === 'addpista' && !$img) echo ("Immagine di copertina obbligatoria."); ?></div>
              </div>
            </div>
            <div class="grid-item">
              <label for="pista-immagine-alt">Testo alternativo all'immagine</label>
            </div>
            <div class="grid-item">
              <div class="input-row">
                <input type="text" name="img_alt" id="pista-immagine-alt" />
                <div class="error hidden"></div>
              </div>
            </div>

            <span></span>
            <button id="add-pista-image" type="button" class="button grid-item" onclick="addImageToCircuit()">Aggiungi immagine</button>
          </div>
          <button class="button" type="submit" value="submit">Aggiungi</button>
        </form>
      </div>

      <div id="lista-prenotazioni" role="tabpanel" aria-hidden="true" aria-expanded="false" aria-labelledby="lista-prenotazioni-button">
        <div class="container">
          <h1>Elenco prenotazioni</h1>
          <?php if ($lastAction === 'deleteprenotazione') {
            if ($success) {
              echo ("<div class='success-message'>Prenotazione cancellata con successo.</div>");
            } else {
              echo ("<div class='error-message'>Impossibile cancellare la prenotazione #${id}.</div>");
            }
          } ?>
          <ul class="bookings-list">
            <?php foreach (getPrenotazioneList() as $p) : ?>
              <li class="card">
                <p>Prenotazione #<?php echo ($p['id']); ?></p>
                <p><?php echo ("{$p['destinatario']['nome']} {$p['destinatario']['cognome']}"); ?></p>
                <p><?php echo ($p['modello']); ?></p>
                <p><?php echo ($p['pista']); ?></p>
                <p><?php echo (date('d/m/Y', strtotime($p['ora_inizio']))); ?></p>
                <p><?php echo (date('H:i', strtotime($p['ora_inizio'])) . ' - ' . date('H:i', strtotime($p['ora_fine']))); ?></p>
                <form action="delete_prenotazione.php" method="post">
                  <input type="hidden" name="id" value="<?php echo ($p['id']); ?>" />
                  <button type="submit" class="button" onclick='return conferma(<?php echo (json_encode($p)) ?>)'>Elimina</button>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

    <?php else : # !is_user_admin() 
    ?>

      <div id="lista-prenotazioni" role="tabpanel" aria-hidden="true" aria-expanded="false" aria-labelledby="lista-prenotazioni-button">
        <div class="container">
          <h2>Elenco prenotazioni</h2>
          <?php if ($lastAction === 'deleteprenotazione') {
            if ($success) {
              echo ("<div class='success-message'>Prenotazione cancellata con successo.</div>");
            } else {
              echo ("<div class='error-message'>Impossibile cancellare la prenotazione #${id}.</div>");
            }
          } ?>
          <ul class="bookings-list">
            <?php foreach (getPrenotazioneByUtente($user['id']) as $p) : ?>
              <li class="card">
                <p>Prenotazione #<?php echo ($p['id']); ?></p>
                <p><?php echo ("{$p['destinatario']['nome']} {$p['destinatario']['cognome']}"); ?></p>
                <p><?php echo ($p['modello']); ?></p>
                <p><?php echo ($p['pista']); ?></p>
                <p><?php echo (date('d/m/Y', strtotime($p['ora_inizio']))); ?></p>
                <p><?php echo (date('H:i', strtotime($p['ora_inizio'])) . ' - ' . date('H:i', strtotime($p['ora_fine']))); ?></p>
                <form action="delete_prenotazione.php" method="post">
                  <input type="hidden" name="id" value="<?php echo ($p['id']); ?>" />
                  <button type="submit" class="button" onclick='return conferma(<?php echo (json_encode($p)) ?>)'>Elimina</button>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; #is_user_admin()
    ?>
  </div>

  <a id="torna-su" class="button" title="Torna all'inizio della pagina" aria-label="Torna su" href="#">Torna su</a>

  <?php echoFooter(); ?>
</body>

</html>
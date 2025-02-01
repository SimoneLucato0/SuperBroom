<?php
  $_user = null;
  $_pw = null;
  $_conn = null;

  function getDBUser() {
    global $_user;
    if ($_user) return $_user;
    $u = null;
    try {
      $u = trim(file_get_contents("../tweb2021-22.sh"));
      $u = trim(explode("\n", $u)[1]);
      $u = trim(explode("#", $u)[1]);
    } catch (Exception $th) {
      return null;
    }
    $_user = $u;
    return $_user;
  }

  function getDBPw() {
    global $_pw;
    if ($_pw) return $_pw;
    $p = null;
    try {
      $p = trim(file_get_contents("../pwd_db_2021-22.txt"));
    } catch (Exception $e) {
      return null;
    }
    $_pw = $p;
    return $_pw;
  }


  function connectDB() {
    global $_conn;
    if($_conn === null) {
      $user = getDBUser();
      $pw = getDBPw();
      $db = $user;
      $_conn = new mysqli("localhost", $user, $pw, $db);
      if ($_conn->connect_errno) {
        $_conn = null;
      }
    }
    return $_conn;
  }

  function closeConn() {
    global $_conn;
    if($_conn)
      $_conn->close();
    $_conn = null;
  }

  function rm_dir_rec($dir) {
    $list = scandir($dir);
    if ($list === FALSE) return;
    foreach ($list as $f) {
      if (is_dir($f)) {
        rm_dir_rec($f);
      } else {
        unlink($f);
      }
    }
    rmdir($dir);
  }

  function saveImg($tmp, $path, $alt, $trans = false) {
    $conn = connectDB();
    $publicdir = '/home/' . getDBUser() . '/public_html/';
    $imgdir = 'images/';
    $path = $imgdir . $path;
    $fullpath = $publicdir . $path;
    $dir = dirname($fullpath);

    if (file_exists($dir)) {
      if (!is_dir($dir)) {
        unlink($dir);
        if (file_exists($fullpath)) {
          if (is_dir($fullpath)) {
            rm_dir_rec($fullpath);
          } else {
            unlink($fullpath);
          }
        }
      }
    } else {
      mkdir($dir, 0777, true);
    }

    $success = false;
    if($conn && (!$trans || $conn->begin_transaction())) {
      $stmt = $conn->prepare("INSERT INTO `Immagine` (`path`, `alt`) VALUES (?, ?)");
      $stmt->bind_param('ss', $path, $alt);
      $res = $stmt->execute();
      if ($res && is_uploaded_file($tmp) && move_uploaded_file($tmp, $fullpath)) {
        $success = true;
      }
      $stmt->free_result();
      $stmt->close();
    }
    if ($success && (!$trans || $conn->commit())) {
      return $path;
    }
    $conn->rollback();
    return null;
  }

  function saveSpecificheModello($modello, $specifiche) {
    $conn = connectDB();
    if ($conn) {
      $stmt = $conn->prepare("INSERT INTO `Specifica` (`modello`, `nome`, `valore`) VALUES (?, ?, ?)");
      $nome = ""; $valore = "";
      $stmt->bind_param('sss', $modello, $nome, $valore);
      foreach ($specifiche as $nome => $valore) {
        $stmt->execute();
      }
      $stmt->free_result();
      $stmt->close();
    }
  }

  function saveGalleriaModello($modello, $galleria, $galleria_alt) {
    $conn = connectDB();
    if ($conn) {
      $stmt = $conn->prepare("INSERT INTO `GalleriaModello` (`modello`, `img`) VALUES (?, ?)");
      $img = "";
      $stmt->bind_param('ss', $modello, $img);
      foreach ($galleria as $k => $g) {
        $ext = explode('/', $g['type'])[1];
        if ($img = saveImg($g['tmp_name'], "auto/{$modello}/galleria-{$k}.{$ext}", $galleria_alt[$k])) {
          $stmt->execute();
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
  }

  function saveModello($nome, $costo_km, $categoria, $descrizione, $specifiche, $img, $img_alt, $galleria, $galleria_alt) {
    $conn = connectDB();
    $success = FALSE;
    $img_ext = explode('/', $img['type'])[1];
    
    if (
      $conn && $conn->begin_transaction() &&
      $saveimg = saveImg($img['tmp_name'], "auto/{$nome}/{$nome}.{$img_ext}", $img_alt)
    ) {
      $stmt = $conn->prepare("INSERT INTO `Modello` (`nome`, `costo_km`, `categoria`, `descrizione`, `img`) VALUES (?, ?, ?, ?, ?);");
      $stmt->bind_param('sdsss', $nome, $costo_km, $categoria, $descrizione, $saveimg);
      $success = $stmt->execute();
      $stmt->free_result();
      $stmt->close();
      if ($success) {
        saveSpecificheModello($nome, $specifiche);
      }
      if ($success) {
        saveGalleriaModello($nome, $galleria, $galleria_alt);
      }
      if ($success) {
        $conn->commit();
      } else {
        $conn->rollback();
      }
    }
    closeConn();
    return $success;
  }

function saveGalleriaPista($pista, $galleria, $galleria_alt) {
  $conn = connectDB();
  if ($conn) {
    $stmt = $conn->prepare("INSERT INTO `GalleriaPista` (`pista`, `img`) VALUES (?, ?)");
    $img = "";
    $stmt->bind_param('ss', $pista, $img);
    foreach ($galleria as $k => $g) {
      $ext = explode('/', $g['type'])[1];
      if ($img = saveImg($g['tmp_name'], "pista/{$pista}/galleria-{$k}.{$ext}", $galleria_alt[$k])) {
        $stmt->execute();
      }
    }
    $stmt->free_result();
    $stmt->close();
  }
}

function savePista(
  $nome,
  $provincia,
  $descrizione,
  $costo_fisso,
  $lunghezza,
  $larghezza,
  $n_curve,
  $dislivello,
  $rettilineo,
  $img,
  $img_alt,
  $galleria,
  $galleria_alt
) {
  $conn = connectDB();
  $success = FALSE;
  $img_ext = explode('/', $img['type'])[1];

  if ($conn && $saveimg = saveImg($img['tmp_name'], "pista/{$nome}/{$nome}.{$img_ext}", $img_alt)) {
    $stmt = $conn->prepare("INSERT INTO `Pista` (`nome`, `provincia`, `descrizione`, `costo_fisso`, `lunghezza`, `larghezza`, `n_curve`, `dislivello`, `rettilineo`, `img`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param('sssdddidds', $nome, $provincia, $descrizione, $costo_fisso, $lunghezza, $larghezza, $n_curve, $dislivello, $rettilineo, $saveimg);
    $success = $stmt->execute();
    $stmt->free_result();
    $stmt->close();
    if ($success) {
      saveGalleriaPista($nome, $galleria, $galleria_alt);
    }
  }
  return $success;
}

  function saveAnagrafica($nome, $cognome, $mail, $data_nascita) {
    $conn = connectDB();
    $id = null;
    if ($conn) {
      $stmt = $conn->prepare("INSERT INTO `Anagrafica` (`cognome`, `nome`, `mail`, `data_nascita`) VALUES (?, ?, ?, ?);");
      $stmt->bind_param('ssss', $cognome, $nome, $mail, $data_nascita);      
      if ($stmt->execute()) {
        $id = $conn->insert_id;
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $id;
  }

  function savePrenotazione($utente_id, $ora, $modello, $pista, $ora_inizio, $ora_fine, $num_giri, $costo, $anagrafica_id) {
    $conn = connectDB();
    $id = null;
    if ($conn) {
    $stmt = $conn->prepare("INSERT INTO `Prenotazione` (`utente`, `data_ora`, `modello`, `pista`, `ora_inizio`, `ora_fine`, `num_giri`, `costo`, `destinatario`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
      $stmt->bind_param('isssssidi', $utente_id, $ora, $modello, $pista, $ora_inizio, $ora_fine, $num_giri, $costo, $anagrafica_id);
      if ($stmt->execute()) {
        $id = $conn->insert_id;
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $id;
  }

  function getImmagineByPath($path) {
    $conn = connectDB();
    $immagine = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Immagine` WHERE path = ?;");
      $stmt->bind_param('s', $path);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $immagine = $row;
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $immagine;
  }

  function getModelloList() {
    $conn = connectDB();
    $modelli = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Modello`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        foreach ($all as $m) {
          $m['img'] = getImmagineByPath($m['img']);
          $modelli[] = $m;
        }
        $res->free_result();
      }
    }
    return $modelli;
  }
  
  function getSpecificaListByModello($modello) {
    $conn = connectDB();
    $specifiche = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Specifica` WHERE modello = ?;");
      $stmt->bind_param('s', $modello);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
          foreach ($all as $s) {
            $specifiche[$s['nome']] = $s['valore'];
          }
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $specifiche;
  }

  function getGalleriaByModello($modello) {
    $conn = connectDB();
    $galleria = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `GalleriaModello` WHERE modello = ?;");
      $stmt->bind_param('s', $modello);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
          foreach ($all as $g) {
            $galleria[] = getImmagineByPath($g['img']);
          }
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $galleria;
  }

  function getModelloByNome($nome) {
    $conn = connectDB();
    $modello = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Modello` WHERE nome = ?;");
      $stmt->bind_param('s', $nome);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $modello = $row;
          $modello['img'] = getImmagineByPath($modello['img']);
          $modello['specifiche'] = getSpecificaListByModello($nome);
          $modello['galleria'] = getGalleriaByModello($nome);
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $modello;
  }

  function getPistaList() {
    $conn = connectDB();
    $piste = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Pista`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        foreach ($all as $p) {
          $p['img'] = getImmagineByPath($p['img']);
          $piste[] = $p;
        }
        $res->free_result();
      }
    }
    return $piste;
  }

  function getGalleriaByPista($pista) {
    $conn = connectDB();
    $galleria = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `GalleriaPista` WHERE pista = ?;");
      $stmt->bind_param('s', $pista);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
          foreach ($all as $g) {
            $galleria[] = getImmagineByPath($g['img']);
          }
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $galleria;
  }

  function getPistaByNome($nome) {
    $conn = connectDB();
    $pista = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Pista` WHERE nome = ?;");
      $stmt->bind_param('s', $nome);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $pista = $row;
          $pista['img'] = getImmagineByPath($pista['img']);
          $pista['galleria'] = getGalleriaByPista($nome);
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $pista;
  }

  function getPresenzaList() {
    $conn = connectDB();
    $presenze = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Presenza`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        $presenze = $all;
        $res->free_result();
      }
    }
    return $presenze;
  }

  function getAnagraficaList() {
    $conn = connectDB();
    $anagrafiche = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Anagrafica`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        $anagrafiche = $all;
        $res->free_result();
      }
    }
    return $anagrafiche;
  }

  function getAnagraficaById($id) {
    $conn = connectDB();
    $anagrafica = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Anagrafica` WHERE id = ?;");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $anagrafica = $row;
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $anagrafica;
  }

  function getUtenteList() {
    $conn = connectDB();
    $utenti = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Utente`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        foreach ($all as $u) {
          $u['anagrafica'] = getAnagraficaById($u['id']);
          unset($u['pw']);
          $utenti[] = $u;
        }
        $res->free_result();
      }
    }
    return $utenti;
  }

  function getUtenteById($id) {
    $conn = connectDB();
    $utente = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Utente` WHERE id = ?;");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $utente = $row;
          $utente['anagrafica'] = getAnagraficaById($id);
          $utente['pw'] = null;
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $utente;
  }

  function getUtenteByUsername($username) {
    $conn = connectDB();
    $utente = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Utente` WHERE username = ?;");
      $stmt->bind_param('s', $username);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $utente = $row;
          $utente['anagrafica'] = getAnagraficaById($utente['id']);
          $utente['pw'] = null;
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $utente;
  }

  function getPrenotazioneById($id) {
    $conn = connectDB();
    $prenotazione = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Prenotazione` WHERE id = ?;");
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
          $prenotazione = $row;
          $prenotazione['utente'] = getUtenteById($prenotazione['utente']);
          $prenotazione['destinatario'] = getAnagraficaById($prenotazione['destinatario']);
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $prenotazione;
  }

  function getPrenotazioneList() {
    $conn = connectDB();
    $prenotazioni = [];
    if ($conn) {
      $res = $conn->query("SELECT * FROM `Prenotazione`");
      if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
        foreach ($all as $p) {
          $p['destinatario'] = getAnagraficaById($p['destinatario']);
          $prenotazioni[] = $p;
        }
        $res->free_result();
      }
    }
    return $prenotazioni;
  }

  function getPrenotazioneByUtente($utente) {
    $conn = connectDB();
    $prenotazione = [];
    if ($conn) {
      $stmt = $conn->prepare("SELECT * FROM `Prenotazione` WHERE utente = ?;");
      $stmt->bind_param('i', $utente);
      if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $all = $res->fetch_all(MYSQLI_ASSOC)) {
          foreach ($all as $p) {
            $p['destinatario'] = getAnagraficaById($p['destinatario']);
            $prenotazione[] = $p;
          }
        }
      }
      $stmt->free_result();
      $stmt->close();
    }
    return $prenotazione;
  }

  function deletePrenotazione($id) {
    $conn = connectDB();
    $success = false;
    if ($conn) {
      $stmt = $conn->prepare("DELETE FROM `Prenotazione` WHERE `id` = ?");
      $stmt->bind_param('i', $id);
      $success = $stmt->execute();
      $stmt->free_result();
      $stmt->close();
    }
    return $success;
  }
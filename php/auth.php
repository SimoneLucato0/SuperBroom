<?php
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/db.php";
  include_once $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../php/utils.php";

  startSession();

  function is_user_logged() {
    return isset($_SESSION['user']);
  }

  function is_user_admin() {
    return is_user_logged() && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
  }

  function user_exists($user) {
    $exists = FALSE;
    if($user) {
      $conn = connectDB();
      if($conn) {
        $stmt = $conn->prepare("SELECT * FROM `Utente` WHERE username=?;");
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $res = $stmt->get_result();
        $exists = boolval($res && $res->num_rows > 0);
        $stmt->free_result();
        $stmt->close();
      }
    }
    return $exists;
  }

  function check_pw($user, $pw) {
    $ret = array(
      'good' => FALSE,
      'isAdmin' => FALSE
    );
    if($user && $pw) {
      $conn = connectDB();
      if($conn) {
        $pwStmt = $conn->prepare("SELECT `pw` FROM `Utente` WHERE username=?;");
        $pwStmt->bind_param('s', $user);
        $pwSuccess = $pwStmt->execute();
        if ($pwSuccess) {
          $pwRes = $pwStmt->get_result();
          if ($pwRes->num_rows > 0) {
            $pwHash = $pwRes->fetch_array(MYSQLI_ASSOC)['pw'];
            if(password_verify($pw, $pwHash)) {
              $ret['good'] = TRUE;
              $adminStmt = $conn->prepare("SELECT * FROM `Utente` JOIN `Amministratore` ON `Utente`.`id` = `Amministratore`.`id` WHERE username = ?;");
              $adminStmt->bind_param('s', $user);
              $adminSuccess = $adminStmt->execute();
              if ($adminSuccess) {
                $adminRes = $adminStmt->get_result();
                $ret['isAdmin'] = boolval($adminSuccess && $adminRes->num_rows > 0);
              }
              $adminStmt->free_result();
              $adminStmt->close();
            }
          }
        }
        $pwStmt->free_result();
        $pwStmt->close();
      }
    }
    return $ret;
  }

  function login($user, $pw) {
    $check = check_pw($user, $pw);
    if($check['good']) {
      $_SESSION['user'] = getUtenteByUsername($user);
      $_SESSION['isAdmin'] = $check['isAdmin'];
    }
    closeConn();
    return is_user_logged();
  }

  function refresh_logged_user() {
    if(is_user_logged()) {
      $_SESSION['user'] = getUtenteByUsername($_SESSION['user']['username']);
    }
  }

  function getCurrentUser() {
    return $_SESSION['user'];
  }

  function logout() {
    unset($_SESSION['isAdmin']);
    unset($_SESSION['user']);
  }

  function signup($user, $pw, $cognome, $nome, $mail, $nascita) {
    $conn = connectDB();
    if ($conn) {
      $conn->begin_transaction();
      $astmt = $conn->prepare("INSERT INTO `Anagrafica` (`cognome`, `nome`, `mail`, `data_nascita`) VALUES (?, ?, ?, ?);");
      $astmt->bind_param('ssss', $cognome, $nome, $mail, $nascita);
      $asuccess = $astmt->execute();
      
      if ($asuccess) {
        $id = $conn->insert_id;
        $ustmt = $conn->prepare("INSERT INTO `Utente` (`id`, `username`, `pw`) VALUES (?, ?, ?);");
        $pw_hash = password_hash($pw, PASSWORD_DEFAULT);
        $ustmt->bind_param('iss', $id, $user, $pw_hash);
        $usuccess = $ustmt->execute();

        if($usuccess) {
          $conn->commit();
        } else {
          $conn->rollback();
        }
        $ustmt->free_result();
        $ustmt->close();
      } else {
        $conn->rollback();
      }
      $astmt->free_result();
      $astmt->close();
      closeConn();
    }
    return isset($usuccess) && $usuccess;
  }

  function update_user($username, $pw, $cognome, $nome, $mail, $nascita) {
    $user = getUtenteByUsername($username);
    $oka = FALSE;
    $okp = FALSE;
    $oku = FALSE;
    if($user) {
      if ($conn = connectDB()) {
        $trans = $conn->begin_transaction();
      }
      if($conn && $trans) {

        if ($trans) {
          $astmt = $conn->prepare("UPDATE `Anagrafica` SET `cognome` = ?, `nome` = ?, `mail` = ?, `data_nascita` = ? WHERE `id` = ?;");
          $astmt->bind_param('ssssi', $cognome, $nome, $mail, $nascita, $user['id']);
          $oka = $astmt->execute();
          $oku = $astmt->affected_rows > 0;
          $astmt->close();
        }

        if ($trans && $pw) {
          $ustmt = $conn->prepare("UPDATE `Utente` SET `pw` = ? WHERE `id` = ?;");
          $pw_hash = password_hash($pw, PASSWORD_DEFAULT);
          $ustmt->bind_param('si', $pw_hash, $user['id']);
          $okp = $ustmt->execute() && $ustmt->affected_rows > 0;
          $ustmt->close();
        }

        if($oka || $okp) {
          $conn->commit();
        } else {
          $conn->rollback();
        }
      }
      closeConn();
    }
    // $oka: anagrafica update ok
    // $okp: password update ok
    // $oku: anagrafica update affected row
    return [$oka, $okp, $oku];
  }

  function requires_user_logged() {
    if(!is_user_logged()) {
      header('Location: login.php?next='.$_SERVER['REQUEST_URI']);
      exit();
    }
  }

?>
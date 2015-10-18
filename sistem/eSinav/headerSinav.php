<?php
  require_once('class/session.php');
  $Session = new Session(30); 

  if ($Session->isRegistered() && isset($_SESSION["ogrenci"])) {
    if ($Session->isExpired()) {
        $Session->end();
        header('location: cikis');
        exit;
    } 
    else {
      $Session->renew();
    }
  }
  else {
    header('location: index');
    exit;
  }
?>
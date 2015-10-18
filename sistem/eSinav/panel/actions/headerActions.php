<?php
  ini_set('display_errors',0);
  require_once('../class/session.php');
  $Session = new Session(30); 

  if ($Session->isRegistered()) {
    if ($Session->isExpired()) {
        $Session->end();
        header('location: index.php');
        exit;
    } 
    else {
      $Session->renew();
    }
  }
  else {
    header('location: ../index.php');
    exit;
  }
?>
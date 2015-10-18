<?php 
  require_once('class/session.php');
  $Session = new Session();
  $Session->end();
  header('location: index.php');
  exit;
?>
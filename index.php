<?php
include 'data/vars.php';
session_start();
  if (isset($_SESSION["id_u"]) ) {
    header('location: competences.php');
  }
  else {
    header('location: connection.php');
  }

?>

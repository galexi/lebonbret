<?php
session_start();

if (isset($_SESSION['id_u'])) {
  //Suppression des variables de session
  $_SESSION = array();
  session_destroy();
  //Redirection vers la page de connexion
  header('location: connection.php');
}
?>

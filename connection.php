<?php
include 'data/vars.php';
session_start();

if (isset($_SESSION["id_u"])) {
  header('location: competences.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill - log in</title>
        <link rel="stylesheet" href="main_style.css" />
    </head>
    <body>
      <div id="only-content">
        <img src="img/logo.png" />
        <h4>lebonskill.fr</h4>
        <br/>
        <form id="form-cnx" method="post" action="proc_authentication.php">
          <input type="text" name="mail" placeholder="Identifiant">
          <input type="password" name="mdp" placeholder="Mot de passe">
          <br/>
          <a style="font-size: 'OpenSans-light'; color: blue;">Problème de connexion ?</a>
          <br/>
          <input type="submit" class="btn btn-success" value="Connexion">
        </form>
      </div>
    </body>
</html>

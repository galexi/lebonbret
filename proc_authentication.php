<?php
include 'data/vars.php';
session_start();

//recuperation des champs du formulaire
$identifiant=$_POST["mail"];
$password=$_POST["mdp"];

//Connexion à la base MySQL
if($bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
  {
      $req_prep = mysqli_prepare($bdd, 'SELECT id_u, prenom FROM utilisateur WHERE mail = ? AND mdp = ?');

  }
  else {
    echo "[Erreur] : connexion à la base échouée !";
  }

  mysqli_stmt_bind_param($req_prep, "ss", $identifiant, $password);
  mysqli_stmt_execute($req_prep);
  mysqli_stmt_bind_result($req_prep, $data['id_u'], $data['prenom']);
  mysqli_stmt_store_result($req_prep);
  $count = mysqli_stmt_num_rows($req_prep);
//Vérification de l'existance du password et de l'identifiant sinon on pose un cookie et on renvoie sur la page de connexion
if ($count == 0){
  setcookie("auth_error",1,time()+4, '/');
  header('location: connection.php');
}
else{   // creation des variables de session
mysqli_stmt_fetch($req_prep);

  $_SESSION["id_u"] = $data['id_u'];
  $_SESSION["prenom"] = $data['prenom'];
  header('location: competences.php');
}
?>

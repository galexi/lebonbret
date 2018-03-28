<?php
include 'data/vars.php';
session_start();

//valeur fictives
$id_u1=1;
$id_u2=2;
$horaire="2018-05-04 16:15:00";
$titre="Faire des gaufres";
$id_l="1";


//Connexion à la base MySQL
if($bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
  {

  }
  else {
    echo "[Erreur] : connexion à la base échouée !";
  }

//creation du rdv
$req_prep = mysqli_prepare($bdd, "INSERT INTO rdv (horaire, titre, etat, id_l) VALUES ('". $horaire ."', '". $titre ."', '0', '". $id_l ."')");
//mysqli_stmt_bind_param($req_prep, "ss", $identifiant, $password);
mysqli_stmt_execute($req_prep);
//mysqli_stmt_bind_result($req_prep, $data['id_r']);

if(mysqli_stmt_execute($req_prep) == FALSE){
  echo "Error execute: " . mysqli_error($bdd);
}

$last_id = mysqli_insert_id($bdd);


//creation premiere prise
$req_prep = mysqli_prepare($bdd, "INSERT INTO prendre (id_u, id_r) VALUES ('". $id_u1 ."', '". $last_id ."')");
//mysqli_stmt_bind_param($req_prep, "ss", $identifiant, $password);
mysqli_stmt_execute($req_prep);

//creation premiere prise
$req_prep = mysqli_prepare($bdd, "INSERT INTO prendre (id_u, id_r) VALUES ('". $id_u2."', '". $last_id ."')");
//mysqli_stmt_bind_param($req_prep, "ss", $identifiant, $password);
mysqli_stmt_execute($req_prep);

header('location: rendezvous.php');
?>

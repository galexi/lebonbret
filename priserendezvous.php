<?php
include 'data/vars.php';
session_start();

//valeur fictives
$id_u1=$_GET['id_u1'];
$id_u2=$_GET['id_u2'];
$horaire=$_GET['date_heure'];
$titre=$_GET['titre'];
$id_l=$_GET['id_l'];
$etat=0;

echo $id_u1 ."<br>";
echo $id_u2 ."<br>";
echo $_GET['date_heure'] ."<br>";
echo $titre ."<br>";
echo $id_l ."<br>";

//Connexion à la base MySQL
if($bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
  {

  }
  else {
    echo "[Erreur] : connexion à la base échouée !";
  }

//creation du rdv
$req_prep = mysqli_prepare($bdd, "INSERT INTO rdv (horaire, titre,etat, id_l) VALUES (?,?,?,?)");
mysqli_stmt_bind_param($req_prep, "ssii", $horaire, $titre,$etat,$id_l);

if(mysqli_stmt_execute($req_prep) == FALSE){
  echo "Error execute: " . mysqli_error($bdd);
}
echo "<br>OK1<br>";
$last_id = mysqli_insert_id($bdd);
echo $last_id;

//creation premiere prise
$req_prep = mysqli_prepare($bdd, "INSERT INTO prendre (id_u, id_r) VALUES (?,?),(?,?)");
mysqli_stmt_bind_param($req_prep, "iiii", $id_u1,$last_id, $id_u2,$last_id);
if(mysqli_stmt_execute($req_prep) == FALSE){
  echo "Error execute: " . mysqli_error($bdd);
}

header('location: chat.php?o='. $id_u2);
echo "<br>END";
?>

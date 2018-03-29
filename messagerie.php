<?php
include 'data/vars.php';
session_start();
if (isset($_SESSION["id_u"]) == FALSE){
  header('location: connection.php');
}

//Connexion à la base MySQL
if($bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
  {

  }
  else {
    echo "[Erreur] : connexion à la base échouée !";
  }

$idconnected_user = $_SESSION["id_u"];

//Préparation de la requete
$req_prep = mysqli_prepare($bdd, 'SELECT P.id_u, U.nom, U.prenom FROM participer AS P, utilisateur AS U WHERE P.id_u = U.id_u AND P.id_u <> 1 AND id_conv IN (SELECT id_conv FROM participer WHERE id_u = ?)');
mysqli_stmt_bind_param($req_prep, "i", $idconnected_user);
mysqli_stmt_execute($req_prep);
mysqli_stmt_bind_result($req_prep, $data['id_u'], $data['nom'], $data['prenom']);
mysqli_stmt_store_result($req_prep);

//On compte le nombre de résultat retourné par la requete
$nbresult = mysqli_stmt_num_rows($req_prep);
$i = 0;
//Stockage des résultats dans un tableau
while (mysqli_stmt_fetch($req_prep)) {
  $id_u[$i] = $data['id_u'];
  $nom[$i] = $data['nom'];
  $prenom[$i] = $data['prenom'];
  $i++;
}
$taille = $i;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
    </head>

    <body>
      <div id="top-bar">
          <div id="top-bar_wl">
          <a href="competences.php" ><img src="img/logo.png"/></a>
          </div>
          <div id="top-bar_wc">
              <h1>lebonskill.fr</h1>
          </div>
          <div id="top-bar_wr">
              <p>Bienvenue <?php echo $_SESSION["prenom"]; ?> !</p>
          </div>
      </div>
      <div id="left-menu">
        <a href="profile.php"><h2 class="menu_on">Mon profil</h2></a>
        <a href="rendezvous.php"><h2 class="menu_off">RDV à venir</h2></a>
        <a href="messagerie.php"><h2 class="menu_off">Messagerie</h2></a>
        <a href="proc_logout.php"><h2 class="menu_off">Déconnexion</h2></a>
      </div>
      <div id="main-content">
        <?php
          for ($i=0; $i < $taille; $i++) {
            echo '<div class="brick">';
            echo "<h1> Conversation avec : " . $nom[$i] . " " . $prenom[$i] . "</h1></br>";
            if ($idconnected_user != $id_u[$i]) {
              echo '<button onclick="location.href = \'/chat.php?id=' . $idconnected_user . '&o=' . $id_u[$i] . '\';">Contacter</button>';
            }
            echo '</div>';
          }
        ?>
      </div>
    </body>
</html>

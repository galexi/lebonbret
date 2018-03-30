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

if(isset($_GET["id"])){
    $idprofile = $_GET['id'];

} else {
    $idprofile = $_SESSION["id_u"];
    $falg=1;
}

//Préparation de la requete 1
$req_prep = mysqli_prepare($bdd, 'SELECT nom, prenom, d_naiss, photo, bio FROM utilisateur WHERE id_u = ?');
mysqli_stmt_bind_param($req_prep, "i", $idprofile);
mysqli_stmt_execute($req_prep);
mysqli_stmt_bind_result($req_prep, $profile['nom'], $profile['prenom'], $profile['d_naiss'], $profile['photo'], $profile['bio']);
mysqli_stmt_fetch($req_prep);

//calcul de l'age
$age = (time() - strtotime($profile['d_naiss'])) / 3600 / 24 /365;
$user_age = strstr($age,'.', true);


/* tentative d'accès à la BDD */
if(!$bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
    echo "[Erreur] : connexion à la base échouée !";

//Préparation de la requete 2
$req_prep = mysqli_prepare($bdd, 'SELECT titre, categorie, description, dispo_jour, dispo_heure FROM competence AS C, posseder AS P, utilisateur AS U WHERE U.id_u = P.id_u AND C.id_c = P.id_c AND U.id_u = ?');
mysqli_stmt_bind_param($req_prep, "i", $idprofile);
mysqli_stmt_execute($req_prep);
mysqli_stmt_bind_result($req_prep, $comp['titre'], $comp['categorie'], $comp['description'], $comp['dispo_jour'], $comp['dispo_heure']);
$i = 0;
//Stockage des résultats dans un tableau
while (mysqli_stmt_fetch($req_prep)) {
  $titre[$i] = $comp['titre'];
  $categorie[$i] = $comp['categorie'];
  $description[$i] = $comp['description'];
  $disp_d[$i] = $comp['dispo_jour'];
  $disp_t[$i] = $comp['dispo_heure'];
  $i++;
}
$taille = $i;
?>

<!-- Debut HTML -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
        <link rel="stylesheet" href="profile.css" />
    </head>

    <body>
      <div id="top-bar">
          <div id="top-bar_wl">
          <a href="competences.php" ><img src="img/logo.png"/></a>
          </div>
          <div id="top-bar_wc">
              <h1><a href="competences.php">lebonskill.fr</a></h1>
          </div>
          <div id="top-bar_wr">
              <p>Bienvenue <?php echo $_SESSION["prenom"]; ?> !</p>
          </div>
      </div>
      <div id="left-menu">
        <h2 class="menu_on"><a href="profile.php">Mon profil</a></h2>
        <h2 class="menu_off"><a href="rendezvous.php">RDV à venir</a></h2>
        <h2 class="menu_off"><a href="messagerie.php">Messagerie</a></h2>
        <h2 class="menu_off"><a href="proc_logout.php">Déconnexion</a></h2>
      </div>
      <div id="main-content">
        <div id="profile-header">
          <div class="round-image">
            <?php echo "<img id=\"profilpic\" src=\"".$profile["photo"]."\"/>\n"; ?>
          </div>
          <div id="id-card">
            <p><?php
            echo "Nom : " . $profile['nom'] . "</br> Prénom : " . $profile['prenom'] . "</br> Age : " . $user_age . " ans </br> Bio : " . $profile['bio'];
            ?>
            </p>
          </div>
          <div id="contacter">
            <?php
            if (isset($_GET['id'])) {
              echo '<button onclick="location.href = \'chat.php?o=' . $idprofile . '\';">Contacter</button>';
            }
            ?>
          </div>
        </div>
        <div id="competence">
          <p><?php
            for ($i=0; $i < $taille; $i++) {
              echo '<div class="brick">';
              echo "<h1>" . $titre[$i] . "</h1></br> Catégorie : " . $categorie[$i] . "</br> Description : " . $description[$i] .  "</br> Disponibilité : " . $disp_d[$i] . " à " . $disp_t[$i] . "</br>";
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </body>
</html>

<?php
//Connexion à la base MySQL
if($bdd = mysqli_connect('localhost', 'said', 'stri', 'lebonskill'))
  {

  }
  else {
    echo "[Erreur] : connexion à la base échouée !";
  }

$idconnected_user = 2;
$idprofile = 1;

//Préparation de la requete 1
$req_prep = mysqli_prepare($bdd, 'SELECT nom, prenom, d_naiss, photo, bio FROM utilisateur WHERE id_u = ?');
mysqli_stmt_bind_param($req_prep, "i", $idprofile);
mysqli_stmt_execute($req_prep);
mysqli_stmt_bind_result($req_prep, $profile['nom'], $profile['prenom'], $profile['d_naiss'], $profile['photo'], $profile['bio']);
mysqli_stmt_fetch($req_prep);

//calcul de l'age
$age = (time() - strtotime($profile['d_naiss'])) / 3600 / 24 /365;
$user_age = strstr($age,'.', true);

//Préparation de la requete 2
$bdd = mysqli_connect('localhost', 'said', 'stri', 'lebonskill');
$req_prep2 = mysqli_prepare($bdd, 'SELECT C.titre, C.categorie, P.desc, P.dispo_jour, P.dispo_heure FROM competence AS C, posseder AS P, utilisateur AS U WHERE U.id_u = P.id_u AND C.id_c = P.id_c AND U.id_u = ?');
if(mysqli_stmt_bind_param($req_prep2, "i", $idprofile) == FALSE) {
  echo ("Erreur bind param : " . mysqli_error($bdd));
}
if(mysqli_stmt_execute($req_prep2) == FALSE) {
  echo ("Erreur execute : " . mysqli_error($bdd));
}
if(mysqli_stmt_bind_result($req_prep2, $comp['titre'], $comp['categorie'], $comp['desc'], $comp['dispo_jour'], $comp['dispo_heure']) == FALSE){
  echo ("Erreur bind result : " . mysqli_error($bdd));
}
if(mysqli_stmt_store_result($req_prep2) == FALSE) {
  echo ("Erreur store result : " . mysqli_error($bdd));
}
$nbresult = mysqli_stmt_num_rows($req_prep2);
$i = 0;
while (mysqli_stmt_fetch($req_prep2)) {
  $titre[$i] = $comp['titre'];
  $categorie[$i] = $comp['categorie'];
  $description[$i] = $comp['desc'];
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
          <img style="height: 70%; width: auto; margin: 5%;" src="img/logo.png"/>
        </div>
        <div id="top-bar_wc">
          <h1>lebonskill.fr</h1>
        </div>
        <div id="top-bar_wr">
          <input style="float: left; height: 30%; width: 70%;" type="text" placeholder="Recherche">
          <img style="height: 30%; width: auto; float: left; margin: 1%;" src="img/search_img.png"/>
        </div>
      </div>
      <div id="left-menu">
        <h2 class="menu_on">TITRE 1</h2>
        <h2 class="menu_off">TITRE 2</h2>
        <h2 class="menu_off">TITRE 3</h2>
        <h2 class="menu_off">TITRE 4</h2>
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
          <p style="text-align: center">
            <?php
            if ($idconnected_user != $idprofile) {
              echo "<input type=\"button\" value=\"Contacter\">";
            }
            ?>
          </p>
        </div>
        <div id="competence">
          <p><?php
            for ($i=0; $i < $taille; $i++) {
              echo "Titre : " . $titre[$i] . "</br> Catégorie : " . $categorie[$i] . "</br> Description : " . $description[$i] .  "</br> Disponibilité : " . $disp_d[$i] . " à " . $disp_t[$i] . "</br>";
            }
          ?>
        </div>
      </div>
    </body>
</html>

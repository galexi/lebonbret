<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
    </head>
    <?php
      include 'data/vars.php';
      session_start();

      /* tentative d'accès à la BDD */
      if(!$bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
          echo "[Erreur] : connexion à la base échouée !";
    ?>
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
        <a href="profile.php"><h2 class="menu_off">Mon profil</h2></a>
        <a href="rendezvous.php"><h2 class="menu_on">RDV à venir</h2></a>
        <h2 class="menu_off">Messagerie</h2>
        <a href="proc_logout.php"><h2 class="menu_off">Déconnexion</h2></a>
      </div>
      <div id="main-content">
        <?php
          /* display des rendez-vous par tuiles contenant le titre du rdv, le lieu, la date et la personne qui est présente */
          /* avec fake utilisateur courant */
          $id_current = $_SESSION["id_u"];

          //$reponse = $bdd->query('SELECT * FROM rdv r, utilisateur u, prendre p where p.id_u = u.id_u and p.id_r = r.id_r and p.id_u = ' . $id_current);
          //$reponse = $bdd->query('SELECT r.titre, r.horaire, u.nom, u.prenom, u.photo, u.id_l FROM rdv r, prendre p, utilisateur u where r.id_r = p.id_r and p.id_u = u.id_u and p.id_u != '. $id_current .' and p.id_r IN (SELECT p.id_r FROM prendre p WHERE p.id_u = '. $id_current .')');

          $req = mysqli_prepare($bdd,'SELECT r.titre, r.horaire, u.nom, u.prenom, u.photo, u.id_l FROM rdv r, prendre p, utilisateur u where r.id_r = p.id_r and p.id_u = u.id_u and p.id_u != '. $id_current .' and p.id_r IN (SELECT p.id_r FROM prendre p WHERE p.id_u = '. $id_current .')');
          mysqli_stmt_execute($req);
          mysqli_stmt_bind_result($req, $donnees['titre'], $donnees['horaire'], $donnees['nom'], $donnees['prenom'], $donnees['photo'], $donnees['id_l']);

          while(mysqli_stmt_fetch($req)){
            /* la classe brick désigne les éléments prenant toutes la largueur de l'élément parent. */
            echo '<div class="tile">';
            echo '<h1>' . $donnees['titre'] . '</h1>'; //le titre de la competence
            echo '<h2> Lieu : </h2>'; //le lieu est manquant dans la db ?
            echo '<h2> Date : ' . $donnees['horaire'] . '</h2>';
            echo '<h2> Avec ' . $donnees['prenom'] . ' ' . $donnees['nom'] . '</h2>'; //le prenom et le nom de l'utilisateur
            echo '<img src="' . $donnees['photo'] . '"/>'; //affiche l'image
            echo '</div>';
          }
        ?>
      </div>

    </body>
</html>

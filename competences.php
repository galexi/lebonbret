<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
    </head>
    <?php
      /* tentative d'accès à la BDD */
      try{
        $bdd = new PDO('mysql:host=localhost;dbname=skills_detector;charset=utf8', 'root', '');
      }
      catch (Exception $e)
      {
            die('Erreur : ' . $e->getMessage());
      }
    ?>
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
        <h2 class="menu_off">Mon profil</h2>
        <a href="rendezvous.php"><h2 class="menu_off">RDV à venir</h2></a>
        <h2 class="menu_off">Messagerie</h2>
        <h2 class="menu_off">Déconnexion</h2>
      </div>
      <div id="main-content">
        <?php
          $reponse = $bdd->query('SELECT * FROM posseder p, utilisateur u, competence c where p.id_u = u.id_u and p.id_c = c.id_c');

          while($donnees = $reponse->fetch()){
            /* la classe brick désigne les éléments prenant toutes la largueur de l'élément parent. */
            echo '<div class="brick">';
            echo '<img src="' . $donnees['photo'] . '"/>'; //affiche l'image
            echo '<h1>' . $donnees['titre'] . '</h1>'; //le titre de la competence
            echo '<h2>' . $donnees['prenom'] . ' ' . $donnees['nom'] . '</h2>'; //le prenom et le nom de l'utilisateur
            echo '<p>' . $donnees['desc'] . '</p>'; //la description de la competence
            echo '</div>';
          }
        ?>
      </div>

    </body>
</html>
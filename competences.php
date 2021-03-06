<?php
include 'data/vars.php';
session_start();
  if (!isset($_SESSION["id_u"]) ) {
    header('location: connection.php');
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
    </head>
    <?php
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
        <h2 class="menu_off"><a href="profile.php">Mon profil</a></h2>
        <h2 class="menu_off"><a href="rendezvous.php">RDV à venir</a></h2>
        <h2 class="menu_off"><a href="messagerie.php">Messagerie</a></h2>
        <h2 class="menu_off"><a href="proc_logout.php">Déconnexion</a></h2>
      </div>
      <div id="main-content">
        <!-- barre de filtres -->
        <div class="brick">
          <?php
            /* afficher les différentes catégories possibles : */
            echo '<div class="underbrick"><h2>Catégorie :</h2>';
            echo '<select id="categorie_select" name="categorie">';
            echo '<option selected value="lieu">Choisir une catégorie</option>';

            $req = mysqli_prepare($bdd,'SELECT DISTINCT categorie FROM competence');
            mysqli_stmt_execute($req);
            mysqli_stmt_bind_result($req, $data['categorie']);
            mysqli_stmt_fetch($req);

            while(mysqli_stmt_fetch($req)){
              echo '<option value="'.  $data['categorie'] .'">'.$data['categorie'].'</option>';
            }
            echo '</select></div>';

            // afficher les différents lieux possibles :
            echo '<div class="underbrick"><h2>Lieu :</h2>';
            echo '<select id="lieu_select" name="lieu">';
            echo '<option selected value="lieu">Choisir un lieu</option>';
            $req = mysqli_prepare($bdd,'SELECT DISTINCT nom FROM lieu');
            mysqli_stmt_execute($req);
            mysqli_stmt_bind_result($req, $data['nom']);

            while(mysqli_stmt_fetch($req)){
              echo '<option value="'.  $data['nom'] .'">'.$data['nom'].'</option>';
            }
            echo '</select></div>';

            /* la distance avec le rang */
            echo '<div class="underbrick"><h2>Distance :</h2>';
            echo '<input id="dist_input" type="range" value="15" max="200" min="0" step="10" onchange="updateKm()">';
            echo '<h3 id="dist_display">0 km</h3>';
            echo '</div>';
            echo '<br/>';
            echo '<button onclick="applyFilter()">Filtrer ></button>';
            echo '<button onclick="resetFilter()">Réinitialiser ></button>';
          ?>
        </div>

        <?php
          /* tentative d'accès à la BDD */
          if(!$bdd = mysqli_connect(DB_SERVER, DB_USER, PW_USER, DB_NAME))
              echo "[Erreur] : connexion à la base échouée !";
          //fake id for current user
          $id_current = $_SESSION["id_u"];


          $req = mysqli_prepare($bdd,'SELECT u.id_u, photo, titre, categorie, prenom, u.nom AS unom, l.nom AS lnom, `desc`, dist  FROM posseder p, utilisateur u, competence c, lieu l WHERE p.id_u = u.id_u AND p.id_c = c.id_c AND u.id_l = l.id_l AND u.id_u <> ?');
          if(mysqli_stmt_bind_param($req, 'i', $id_current) == FALSE){
              echo("Error bind param ".mysqli_error($bdd));
          }
          if(mysqli_stmt_execute($req) == FALSE){
              echo("Error bind param ".mysqli_error($bdd));
          }
          if(mysqli_stmt_bind_result($req, $data['id'], $data['photo'], $data['titre'], $data['categorie'], $data['prenom'], $data['unom'], $data['lnom'], $data['desc'], $data['dist']) == FALSE){
              echo("Error bind param ".mysqli_error($bdd));

          }

          while(mysqli_stmt_fetch($req)){
            /* la classe brick désigne les éléments prenant toutes la largueur de l'élément parent. */
            echo '<div class="brick">';
            echo '<img src="' . $data['photo'] . '"/>'; //affiche l'image
            echo '<h1>' . $data['titre'] . '</h1>'; //le titre de la competence
            echo '<h3>' . $data['categorie'] . '</h3><h3> ' . $data['lnom'] . '</h3>'; //le titre de la competence
            echo '<h2><a href="profile.php?id=' . $data['id'] . '">' . $data['prenom'] . ' ' . $data['unom'] . '</a></h2>'; //le prenom et le nom de l'utilisateur
            echo '<p>' . $data['desc'] . '</p>'; //la description de la competence
            echo '<h3 style="display: none">' . $data['dist'] . '</h3>';
            if ($id_current != $data['id']) {
              echo '<button onclick="location.href = \'chat.php?o=' . $data['id'] . '\';">Contacter</button>';//bouton permetant de contacter la personne designée
            }
            echo '</div>';
          }
        ?>
      </div>
      <script>
        /* utilisé pour mettre à jour la valeur des kilometres sur la barre de distance */
        function updateKm(){
          document.getElementById("dist_display").innerText = document.getElementById("dist_input").value + " km";
        }

        function resetFilter(){
          var listElement = document.getElementsByClassName("brick");

          //prendre toutes les briques à part la première (filtre)
          for(i = 1; i < listElement.length; i++){
            listElement[i].style.display = "block";
          }
        }

        /* utlisé lorsqu'on appuie sur le bouton filtrer dans les filtres */
        function applyFilter(){
          resetFilter();
          //récupérer les filtres, e variable temp qui permet de raccourci les instructions :
          //categorie :
          var e = document.getElementById("categorie_select");
          var categorie = e.options[e.selectedIndex].text;

          //lieu
          var e = document.getElementById("lieu_select");
          var lieu = e.options[e.selectedIndex].text;

          var dist = document.getElementById("dist_input").value;

          //parcourir les élements affichés
          var listElement = document.getElementsByClassName("brick");

          //prendre toutes les briques à part la première (filtre)
          for(i = 1; i < listElement.length; i++){
            //comparer les elements en h3, soit la categorie et le lieu
            var currentElement = listElement[i].getElementsByTagName("h3");
            if((currentElement[0].innerText != categorie && categorie != "Choisir une catégorie") || (currentElement[1].innerText != lieu && lieu != "Choisir un lieu") || Number(currentElement[2].innerText) > Number(dist))
              listElement[i].style.display = "none";
          }
        }

        updateKm();
      </script>
    </body>
</html>

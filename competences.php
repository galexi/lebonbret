<?php
session_start();
  if (isset($_SESSION["id_u"]) ) {
    header('location: competences.php');
  }
  else {
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
          <img src="img/logo.png"/>
          </div>
          <div id="top-bar_wc">
              <h1>lebonskill.fr</h1>
          </div>
          <div id="top-bar_wr">
              <p>Bienvenue <?php $current_user_firstname = "Géraldine";
              echo $current_user_firstname; ?> !</p>
          </div>
      </div>
      <div id="left-menu">
        <h2 class="menu_off">Mon profil</h2>
        <a href="rendezvous.php"><h2 class="menu_off">RDV à venir</h2></a>
        <h2 class="menu_off">Messagerie</h2>
        <h2 class="menu_off">Déconnexion</h2>
      </div>
      <div id="main-content">
        <!-- barre de filtres -->
        <div class="brick">
          <?php
            /* afficher les différentes catégorie possible : */
            $reponse = $bdd->query('SELECT DISTINCT categorie FROM competence');
            echo '<div class="underbrick"><h2>Catégorie :</h2>';
            echo '<select id="categorie_select" name="categorie">';
            echo '<option selected value="lieu">Choisir une catégorie</option>';
            while($donnees = $reponse->fetch()){
              echo '<option value="'.  $donnees['categorie'] .'">'.$donnees['categorie'].'</option>';
            }
            echo '</select></div>';

            /* afficher les différentes lieux possible : */
            $reponse = $bdd->query('SELECT DISTINCT nom FROM lieu');
            echo '<div class="underbrick"><h2>Lieu :</h2>';
            echo '<select id="lieu_select" name="lieu">';
            echo '<option selected value="lieu">Choisir un lieu</option>';
            while($donnees = $reponse->fetch()){
              echo '<option value="'.  $donnees['nom'] .'">'.$donnees['nom'].'</option>';
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
          //fake id for current user
          $id_current = 2;

          /* <!> Ajouter le lien sur le nom des utilisateurs */
          /* Ajouter bouton chat, passer en paramètre GET l'id de l'utilisateur courant et l'id sur la personne ciblée */
          /* supprimer les annonces de l'utilsateur courant */
          $reponse = $bdd->query('SELECT *, u.nom as unom, l.nom as lnom FROM posseder p, utilisateur u, competence c, lieu l where p.id_u = u.id_u and p.id_c = c.id_c and u.id_l = l.id_l and u.id_u != '. $id_current);

          while($donnees = $reponse->fetch()){
            /* la classe brick désigne les éléments prenant toutes la largueur de l'élément parent. */
            echo '<div class="brick">';
            echo '<img src="' . $donnees['photo'] . '"/>'; //affiche l'image
            echo '<h1>' . $donnees['titre'] . '</h1>'; //le titre de la competence
            echo '<h3>' . $donnees['categorie'] . '</h3><h3> ' . $donnees['lnom'] . '</h3>'; //le titre de la competence
            echo '<h2>' . $donnees['prenom'] . ' ' . $donnees['unom'] . '</h2>'; //le prenom et le nom de l'utilisateur
            echo '<p>' . $donnees['desc'] . '</p>'; //la description de la competence
            echo '<h3 style="display: none">' . $donnees['dist'] . '</h3>';
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

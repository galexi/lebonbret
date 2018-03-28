<?php
/*VARIABLES*/
include 'data/vars.php';

if ($_GET['id'] == 1) {
  $current_user_firstname = "Patrice";
} else if ($_GET['id'] == 3){
  $current_user_firstname = "Géraldine";
}
else if($_GET['id'] == 2)
{
    $current_user_firstname = "Emilie";
}

$current_user_id = $_GET['id'];
//$current_chat = $_GET['c'];

//$state = $_GET['s'];
$other_user_id = $_GET['o'];

//récupération des données sur le destinataire
if($bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME))
{
    $req = mysqli_prepare($bdd,'SELECT nom, prenom FROM utilisateur WHERE id_u=?');
    mysqli_stmt_bind_param($req,'i',$other_user_id);
    mysqli_stmt_execute($req);
    mysqli_stmt_bind_result($req, $data['nom'],$data['prenom']);
    mysqli_stmt_fetch($req);
    $prenom_dest = $data['nom'];
    $nom_dest = $data['prenom'];
}
else
{
    $this->say("ERREUR BDD");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lebonskill</title>
        <link rel="stylesheet" href="main_style.css" />
        <link rel="stylesheet" href="chat.css">
    </head>
    <body>
        <div id="top-bar">
            <div id="top-bar_wl">
            <img src="img/logo.png"/>
            </div>
            <div id="top-bar_wc">
                <h1>lebonskill.fr</h1>
            </div>
            <div id="top-bar_wr">
                <p>Bienvenue <?php echo $current_user_firstname; ?> !</p>
            </div>
        </div>

        <div id="left-menu">
            <h2 class="menu_off">Mon profil</h2>
            <h2 class="menu_on"><a href="rendezvous.php">RDV à venir</a></h2>
            <h2 class="menu_off">Messagerie</h2>
            <h2 class="menu_off">Déconnexion</h2>
        </div>
        <div id="main-content">
          <div id="user_id" style="display:none"><?php echo $current_user_id; ?></div>
          <div id="other_user_name" style="display:none"><?php echo $prenom_dest; ?></div>
          <div id="other_user_id" style="display:none"><?php echo $other_user_id; ?></div>
          <div id="speaker" style="display:none"><?php echo $current_user_firstname; ?></div>
          <div id="ip" style="display:none"><?php echo WS_SERVER; ?></div>


          <div class="wrap-chat">
              <h2 style='margin-bottom:40px;'><center>Discussion avec <?php echo $prenom_dest." ".$nom_dest; ?> <span id="en_ligne" style="color:green"></span></center></h2>
              <div ><p id="chatbox"></p></div>
              <form id="send-message" method="post">
                  <div class="wrap-input">
                      <input type="text" name="texte" id="texte" style="width:80%;" autocomplete="off" autofocus>
                      <input type="submit" value="Envoyer" id="valid">
                  </div>
              </form>
          </div>

            <form id="rdv"  method="post">
                <h3>Prendre un rendez-vous</h3>
                Ville : <input type="text" name="" value="" id="ville" ><br>
                Date : <input type="date" name="" value=""  id="date" >
                Heure : <input type="time" name="" value=""  id="heure" >
                <input type="submit" id="check-meteo" value="Vérifier la météo">
            </form>
            <div id="meteo" style="">
                <p>Météo du <span id="rdv-creneau"></span> : </p>
                <ul>
                    <li>Temps : <span id="meteo-temps"></span></li>
                    <li>Température : <span id="meteo-temperature"> </span></li>
                    <li>Vent : force <span id="meteo-vent"></span></li>
                </ul>
            </div>
          </div>
        </div>
    </body>
    <script type="text/javascript">

        var ws = null;
        var ip = document.getElementById("ip")

        if ('MozWebSocket' in window) {
          ws = new MozWebSocket("ws://"+ip.innerHTML+":1337");
        }
        else if ('WebSocket' in window) {
          ws = new WebSocket("ws://"+ip.innerHTML+":1337");
        }

        if (typeof ws !=='undefined') {

            ws.onopen = function() {
                var user_id = document.getElementById('user_id');
                var speaker = document.getElementById('speaker');
                var other_user_id = document.getElementById('other_user_id');
                var to_send = "connect#!" + user_id.innerHTML + "#!" + speaker.innerHTML+"#!"+other_user_id.innerHTML;
                ws.send(to_send);
                console.log("> Socket ouvert"); //DEBUG
            };

            ws.onmessage = function(e) {
                console.log("> Message brut reçu : "+e.data); //DEBUG
                var parsed_msg = e.data.split('#!');
                var user_id = document.getElementById('user_id');
                var other_user_name = document.getElementById('other_user_name');
                switch (parsed_msg[0]) {
                    case 'chat':
                        var to_print ="";
                        if (parsed_msg[2] == user_id.innerHTML) {
                            log("<b>Vous : </b>" + parsed_msg[1]);
                        } else if(parsed_msg[2] == other_user_id.innerHTML) {
                            log( "<b>"+ other_user_name.innerHTML+" : </b>" + parsed_msg[1]);
                        } else {

                        }
                        break;
                    case 'connect':
                        log("vous êtes connectés.")
                        break;
                    case 'info':
                        var span_enLigne = document.getElementById('en_ligne');
                        span_enLigne.innerHTML = "en ligne";
                        break;

                    case 'meteo':
                        var temps = parsed_msg[1];
                        var temperature = parsed_msg[2];
                        var vent = parsed_msg[3];
                        var date = parsed_msg[4];

                        var meteo_temps = document.getElementById('meteo-temps');
                        var meteo_temperature = document.getElementById('meteo-temperature');
                        var meteo_vent = document.getElementById('meteo-vent');
                        var rdv_creneau = document.getElementById('rdv-creneau');

                        rdv_creneau.innerHTML = date;
                        meteo_temps.innerHTML = temps;
                        meteo_temperature.innerHTML = temperature + " °C";
                        meteo_vent.innerHTML = vent;

                        break;
                  default:

                }
            };

            document.getElementById('send-message').onsubmit = function(e) {
                var texte = document.getElementById('texte');
                var user_id = document.getElementById('user_id');
                var other_user_id = document.getElementById('other_user_id');
                var to_send = "chat#!" + texte.value +  "#!" + user_id.innerHTML + "#!" + other_user_id.innerHTML;
                ws.send(to_send);
                texte.focus();
                texte.value = '';
                e.preventDefault();
            };

            document.getElementById('rdv').onsubmit = function(e) {
                var ville = document.getElementById('ville');
                //var ville = "Toulouse";
                var date = document.getElementById('date');
                //var date = "2018-03-31";
                var heure = document.getElementById('heure');
                //var heure = "15:00";
                var user_id = document.getElementById('user_id');
                var to_send = "meteo#!"+user_id.innerHTML+"#!" + ville.value + "#!" + date.value + "#!" + heure.value;
                //var to_send = "meteo#!"+user_id.innerHTML+"#!" + ville. + "#!" + date + "#!" + heure;

                ws.send(to_send);
                console.log(to_send);
                e.preventDefault();
            };
        }

        function log(txt) {
          //document.getElementById('chatbox').innerHTML += id + " dit : " + txt + "<br>\n";
          var chatbox = document.getElementById('chatbox');
          chatbox.innerHTML += txt + "<br>\n";
          chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>
</html>

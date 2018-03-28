<?php
include '../new/data/vars.php';
require "websocket.class.php";


class Lebonskill extends WebSocket{

    private $connected_users = array();

    public function process($user, $msg){

        $this->say("message recu > ".$msg);

        $parsed_msg = $this->parse_msg($msg);

        switch ($parsed_msg[0]) {
            case 'chat':
                //Inscrire le message en bdd
                $this->nouveau_message($parsed_msg[1],$parsed_msg[2],substr($parsed_msg[3],0,1));
                //Afficher le dernier message - chat content user_id conv_id
                $this->lire_dernier_message($this->check_chat($parsed_msg[2],substr($parsed_msg[3],0,1)),$parsed_msg[2],substr($parsed_msg[3],0,1));
                //// DEBUG:
                break;

            case 'connect':
                //un utilisateur vient de se connecter au chat
                $this->say("> ".$parsed_msg[2]." est connecté.");
                //$this->say("> Après parsing : ".$parsed_msg[0]." ".$parsed_msg[1]." ".$parsed_msg[2]." ".substr($parsed_msg[3],0,1));
                $this->connected_users[$parsed_msg[1]] = $user->socket;
                print_r($this->connected_users);
                $res = $this->check_chat($parsed_msg[1],substr($parsed_msg[3],0,1));
                if ($res != FALSE)
                {
                    //$this->welcome(substr($parsed_msg[3],0,1),$parsed_msg[1],$parsed_msg[2]);
                    $response = $this->lire_tous_messages($res,$parsed_msg[1]);
                }
                break;

            case "meteo":

                break;

            default:
                $this->say("> La commande n'est pas reconnue");
                break;
        }
    }

    public function nouveau_message($contenu, $user_id,$dest){
        $conv_id = $this->check_chat($user_id,$dest);

        if ($conv_id == FALSE) {
            $this->say("> Nouveau CHAT ! conv_id = ".$conv_id);
            $conv_id = $this->nouveau_chat($user_id,$dest);
        }
        $this->say("> CHAT de destination : conv_id = ".$conv_id);
        $this->say("> Inscription du message");

        $horodatage = date('Y-m-d H:i:s');

        $this->say("> Heure courante : ".$horodatage);

        $bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME);
        $req = mysqli_prepare($bdd,'INSERT INTO message(horodatage,contenu,id_u,id_conv) VALUES(?,?,?,?)');
        if($req == FALSE)
        {
            $this->say("Error prepare ".mysqli_error($bdd));
        }

        if(mysqli_stmt_bind_param($req,'ssis',$horodatage,$contenu,$user_id,$conv_id) == FALSE)
        {
            $this->say("Error bind param ".mysqli_error($bdd));
        }

        if(mysqli_stmt_execute($req) == FALSE)
        {
            $this->say("Error execute 1: ".mysqli_error($bdd));
        }
    }


    public function lire_dernier_message($id_conv, $emet, $dest){

        $response = "";

        $this->say("> Lecture du dernier du message");

        if($bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME))
        {
            $req = mysqli_prepare($bdd,'SELECT message.contenu, utilisateur.id_u FROM message, utilisateur WHERE utilisateur.id_u=message.id_u AND id_conv = ? ORDER BY message.horodatage DESC LIMIT 1');
            mysqli_stmt_bind_param($req,'i',$id_conv);
            mysqli_stmt_execute($req);
            mysqli_stmt_bind_result($req, $data['contenu'],$data['id_u']);
            mysqli_stmt_fetch($req);

            $response = "chat#!".$data['contenu']."#!".$data['id_u'];

            if(isset($this->connected_users[$emet])){
                $this->send($this->connected_users[$emet], $response);
                $this->say("(emett)Message envoyé à : ".$emet);
            }

            if(isset($this->connected_users[$dest])){
                $this->send($this->connected_users[$dest], $response);
                $this->say("(Dest)Message envoyé à : ".$dest);
            }

        }
        else
        {
            $this->say("ERREUR BDD");
        }
        $this->say("> Dernier messages envoyés");
    }



    public function lire_tous_messages($id_conv,$id_user){

        $response = "";

        $this->say("> Lecture du dernier du message");

        if($bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME))
        {
            $bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME);
            $req = mysqli_prepare($bdd,'SELECT message.contenu, utilisateur.id_u FROM message, utilisateur WHERE utilisateur.id_u=message.id_u AND id_conv = ? ORDER BY message.horodatage ASC');
            mysqli_stmt_bind_param($req,'i',$id_conv);
            mysqli_stmt_execute($req);
            mysqli_stmt_bind_result($req, $data['contenu'], $data['id_u']);
            while(mysqli_stmt_fetch($req))
            {
                $response = "chat#!".$data['contenu']."#!".$data['id_u'];

                $this->send($this->connected_users[$id_user],$response);

            }
        }
        else
        {
            $this->say("ERREUR BDD");
        }
        $this->say("> Tous les messages ont étés envoyés");
    }

    public function welcome($id_conv,$id_user, $prenom){

        $response = "";

        $this->say("> Envoi du welcome");

        if($bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME))
        {
            $bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME);
            $req = mysqli_prepare($bdd,'SELECT id_u FROM participer WHERE id_conv = ?');
            mysqli_stmt_bind_param($req,'i',$id_conv);
            mysqli_stmt_execute($req);
            mysqli_stmt_bind_result($req, $data['id_u']);
            while(mysqli_stmt_fetch($req))
            {
                foreach ($this->connected_users as $socket)
                {
                    if(key($this->connected_users) == $data['id_u']){
                        $this->send($socket, "info#!".$prenom." est connecté au chat !");
                    }
                }
            }
        }
        else
        {
            $this->say("ERREUR BDD");
        }
        $this->say("> Welcome envoyé");
    }

    public function check_chat($user_1, $user_2){
        //Connexion à la bdd
        $bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME);
        //Vérification de l'existance éventuelle d'une conversation
        $req = mysqli_prepare($bdd,'SELECT t1.id_conv AS id_c FROM participer AS t1, participer AS t2 WHERE t1.id_conv = t2.id_conv AND t1.id_u = ? AND t2.id_u= ?');
        if(mysqli_stmt_bind_param($req,'ii',$user_1,$user_2) == FALSE)
        {
            $this->say("Error bind param");
        }

        if(mysqli_stmt_execute($req) == FALSE)
        {
            $this->say("Error execute 3: ".mysqli_error($bdd));
        }

        mysqli_stmt_store_result($req);
        $nb_res = mysqli_stmt_num_rows($req);
        if ($nb_res == 1)
        {
            //Il existe une conversation
            mysqli_stmt_bind_result($req, $data['id_c']);
            mysqli_stmt_fetch($req);
            $res = $data['id_c'];
            $this->say("> Le chat existe : ".$res);
        }else{
            //Pas de conversation
            $res = FALSE;
            $this->say("> Le chat n'existe pas.");
        }
        return $res;
    }

    public function nouveau_chat($u1, $u2){

        $id_conv = substr(md5($u1),0,12);

        $bdd = mysqli_connect(DB_SERVER,DB_USER,PW_USER,DB_NAME);
        $req = mysqli_prepare($bdd,'INSERT INTO participer(id_u,id_conv) VALUES (?,?),(?,?)');
        if($req == FALSE)
        {
            $this->say("Error prepare ");
        }

        if(mysqli_stmt_bind_param($req,'isis',$u1,$id_conv,$u2,$id_conv) == FALSE)
        {
            $this->say("Error bind param");
        }

        if(mysqli_stmt_execute($req) == FALSE)
        {
            $this->say("Error execute 2: ".mysqli_error($bdd));
        }

        return $id_conv;
    }

    public function parse_msg($msg){
      $msg_exploded = explode("#!",$msg);
      return $msg_exploded;
    }
}

$master = new Lebonskill("0.0.0.0", 1337);

?>

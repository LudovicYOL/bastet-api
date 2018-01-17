<?php
    
    require_once './config.php';
    require_once 'personne.php';
    require_once 'utils.php';

    $connectedUsers = array();

    function createToken($login)
    {
        $token = uniqid();
        $connectedUsers[$login] = $token;
        return $token;
    }

    function connect($pdo)
    {
        $content = json_decode(file_get_contents('php://input'));
        if(isset($content->login) && isset($content->password))
        {
            $personne = getPersonneByNom($content->login, $pdo);
            if($personne->password == $content->password){
                return createToken($content->login);
            }
        }
        else
        {
            throw new MissingArgumentException("Veuillez envoyer un login et password pour la connexion");
        }
    }

    function disconnect()
    {
        if(isset($SERVER['HTTP_REMOTE_USER']))
        {
            unset($connectedUsers[$SERVER['HTTP_REMOTE_USER']]);
            return true;
        }
        else
        {
            throw new MissingArgumentException("Veuillez renseigner le REMOTE_USER pour deconnecter l'utilisateur.");
        }
    }

    function info(){
        return $connectedUsers;
    }

    function isConnected(){
        return (isset($_SERVER['HTTP_TOKEN']) && isset($SERVER['HTTP_REMOTE_USER']) && isset($connectedUsers[$SERVER['HTTP_REMOTE_USER']]) && $connectedUsers[$SERVER['HTTP_REMOTE_USER']] == $_SERVER['HTTP_TOKEN']) || (isset($_SERVER['HTTP_TOKEN']) && $_SERVER['HTTP_TOKEN'] == "DEV");
    }

?>
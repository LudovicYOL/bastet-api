<?php 

    require_once 'config.php';
    require_once 'include/personne.php';
    require_once 'include/manager.php';
    require_once 'include/utils.php';

    // Vérifier connexion
    if(!isConnected()){
        http_response_code(401);
        exit("Non connecté"); 
    }

    $code = 200;
    $value = "";

    $possible_url = array("personne", "entreprise");

    if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { 
        $action = $_GET["action"];
        try{
            switch ($action) {
                case "personne": 
                $value = gestionPersonne($pdo);
                break; 

                case "emploi": 

                break; 
            } 
        }
        catch(Exception $e)
        {
            if($e instanceof NotFoundException)
            {
                $code = 204;
            }
            else
            {
                $code = 400;
            }
            $value = $e->getMessage();
        }
    }

    // Retour de l'API
    http_response_code($code);
    exit(json_encode($value)); 

?>
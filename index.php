<?php 
    require_once 'config.php';
    require_once 'include/personne.php';

    // Gestion API
    $code = 200;
    $value = "";

    $possible_url = array("personne", "entreprise");

    if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { 

        // Récupération des informations utiles
        $action = $_GET["action"];
        $method = $_SERVER['REQUEST_METHOD'];
        try{

            switch ($action) {
                // PERSONNE
                case "personne": 
                    switch($method){
                        case "POST":
                            $content = json_decode(file_get_contents('php://input'));
                            $value = add_personne($content, $pdo); 
                            break;
                        case "GET":
                            if (isset($_GET["id"])){
                                $value = get_personne_by_id($_GET["id"], $pdo); 
                            }else{
                                $value = get_list_personne($pdo); 
                            }
                            break;
                        case "PUT":
                            echo("PUT");
                            break;
                        case "DELETE":
                            if (isset($_GET["id"])){
                                $value = delete_personne_by_id($_GET["id"], $pdo); 
                            }else{
                                $value = "Please, specify an id with the personne to delete.";
                            }
                            break;
                    }
                break; 
            case "emploi": 
                if (isset($_GET["id"])){
                    $value = get_personne_by_id($_GET["id"], $pdo); 
                }else{
                    $value = "Argument manquant"; 
                } 
                break; 
            } 
        }
        catch(Exception $e){
            $code = 400;
            $value = $e->getMessage();
        }
    }

    // Retour au client
    http_response_code($code);
    exit(json_encode($value)); 

?>
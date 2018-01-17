<?php 

    require_once 'config.php';
    require_once 'include/personne.php';
    require_once 'include/utils.php';

    $code = 200;
    $value = "";

    $possible_url = array("personne", "entreprise");

    if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { 

        $action = $_GET["action"];
        $method = $_SERVER['REQUEST_METHOD'];
        
        try{

            switch ($action) {
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
                            if (isset($_GET["id"])){
                                $content = json_decode(file_get_contents('php://input'));
                                $value = update_personne($_GET["id"], $content, $pdo);
                            }else{
                                throw new MissingArgumentException("Please, specify the id of the entity to update in the URL.");
                            }
                            break;
                        case "DELETE":
                            if (isset($_GET["id"])){
                                $value = delete_personne_by_id($_GET["id"], $pdo); 
                            }else{
                                throw new MissingArgumentException("Please, specify the id of the entity to delete in the URL.");
                            }
                            break;
                    }
                break; 

            case "emploi": 
                if (isset($_GET["id"])){
                    $value = get_personne_by_id($_GET["id"], $pdo); 
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to delete in the URL.");
                } 
                break; 
            } 
        }
        catch(Exception $e){
            if($e instanceof NotFoundException){
                $code = 204;
            }else{
                $code = 400;
            }
            $value = $e->getMessage();
        }
    }

    // Retour de l'API
    http_response_code($code);
    exit(json_encode($value)); 

?>
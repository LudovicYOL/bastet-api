<?php

    /*
        EMPLOI
    {
        "id": "id",
        "poste": "poste",
        "type_poste": "type_poste",
        "debut_contrat": "debut_contrat",
        "fin_contrat": "fin_contrat",
        "localisation": "localisation",
        "en_recherche": "en_recherche"
    }
    */

    function getEmploiFromResult($result){
        return array(
            "id" => $result->ID_EMPLOI,
            "poste" => $result->POSTE,
            "type_poste" => $result->TYPE_POSTE,
            "localisation" => $result->LOCALISATION, 
            "debut_contrat" => $result->DEBUT_CONTRAT,
            "fin_contrat" => $result->FIN_CONTRAT,
            "en_recherche" => $result->EN_RECHERCHE);
    }

    function getListeEmploi($pdo) { 
        $sql = "SELECT * FROM O_EMPLOI"; 
        $exe = $pdo->query($sql); 
        $emplois = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($emplois, getEmploiFromResult($result));
        }
        return $emplois; 
    }
  
    function getEmploiById($id, $pdo) { 
        $sql = "SELECT * FROM O_EMPLOI WHERE ID_EMPLOI = ".$id;    
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $emploi = getEmploiFromResult($result); 
        }
        if($emploi == null){
            throw new NotFoundException("Aucune entité pour id ". $id);
        }
        return $emploi; 
    }

    function getEmploiByPoste($poste, $pdo) { 
        $sql = "SELECT * FROM O_EMPLOI WHERE POSTE LIKE '%". $poste ."%'"; 
        $exe = $pdo->query($sql); 
        $emplois = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($emplois, getEmploiFromResult($result));
        }
        return $emplois; 
    }

    function getEmploiByLocalisation($localisation, $pdo) { 
        $sql = "SELECT * FROM O_EMPLOI WHERE LOCALISATION LIKE '%". $localisation ."%'"; 
        $exe = $pdo->query($sql); 
        $emplois = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($emplois, getEmploiFromResult($result));
        }
        return $emplois; 
    }

    function validerEmploi($emploi){
        // if(!property_exists($emploi,'nom')){
        //     throw new ValidationException("Entite invalide : pas de valeur pour 'nom'");
        // } 
    }

    function addEmploi($emploi, $pdo){ 
        validerEmploi($emploi);
        $sql = "INSERT INTO o_emploi (POSTE, TYPE_POSTE, LOCALISATION, DEBUT_CONTRAT, FIN_CONTRAT, EN_RECHERCHE) VALUES ('". $emploi->poste ."', '". $emploi->type_poste ."', '". $emploi->localisation ."', '". $emploi->debut_contrat ."', '". $emploi->fin_contrat ."', '". $emploi->en_recherche ."');";
        $pdo->exec($sql);
        return getEmploiById($pdo->lastInsertId(), $pdo);
    }

    function updateEmploi($id, $emploi, $pdo){
        validerEmploi($emploi);
        $sql = "UPDATE o_emploi SET POSTE = '". $emploi->poste ."', TYPE_POSTE = '". $emploi->type_poste ."', LOCALISATION = '". $emploi->localisation ."', DEBUT_CONTRAT = '". $emploi->debut_contrat ."', FIN_CONTRAT = '". $emploi->fin_contrat ."', EN_RECHERCHE = '". $emploi->en_recherche ."'  WHERE id_emploi= ".$id;    
        $pdo->exec($sql);
        return getEmploiById($id, $pdo);
    }

    function deleteEmploiById($id, $pdo) { 
        $sql = "DELETE FROM o_emploi WHERE id_emploi = ".$id;
        $del = $pdo->exec($sql);
        if($del == 0){
            throw new NotFoundException("Pas de ressource pour l'id : ". $id);
        }
        return true;
    }

    function gestionEmploi($pdo){
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method){
            case "POST":
                $content = json_decode(file_get_contents('php://input'));
                $value = addEmploi($content, $pdo);
                break;
            case "GET":
                if (isset($_GET["id"])){
                    $value = getEmploiById($_GET["id"], $pdo);
                }else if (isset($_GET["poste"])){
                    $value = getEmploiByPoste($_GET["poste"], $pdo);
                }else if (isset($_GET["localisation"])){
                    $value = getEmploiByLocalisation($_GET["localisation"], $pdo);
                }else{
                    $value = getListeEmploi($pdo);
                }
                break;
            case "PUT":
                if (isset($_GET["id"])){
                    $content = json_decode(file_get_contents('php://input'));
                    $value = updateEmploi($_GET["id"], $content, $pdo);
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to update in the URL.");
                }
                break;
            case "DELETE":
                if (isset($_GET["id"])){
                    $value = deleteEmploiById($_GET["id"], $pdo); 
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to delete in the URL.");
                }
                break;
        }
        return $value;
    }

?>
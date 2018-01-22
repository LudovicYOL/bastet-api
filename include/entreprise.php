<?php

    /*
        ENTREPRISE
    {
        "id": "TEST",
        "nom": "TEST",
        "localisation": "secteur",
        "secteur": "secteur"
    }
    */

    function getEntrepriseFromResult($result){
        return array(
            "id" => $result->ID_ENTREPRISE,
            "nom" => $result->NOM, 
            "localisation" => $result->LOCALISATION,
		    "secteur" => $result->SECTEUR);
    }

    function getListeEntreprise($pdo) { 
        $sql = "SELECT * FROM O_ENTREPRISE"; 
        $exe = $pdo->query($sql); 
        $entreprises = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($entreprises, getEntrepriseFromResult($result));
        }
        return $entreprises; 
    }
  
    function getEntrepriseById($id, $pdo) { 
        $sql = "SELECT * FROM O_ENTREPRISE WHERE ID_ENTREPRISE = ".$id;    
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $entreprise = getEntrepriseFromResult($result); 
        }
        if($entreprise == null){
            throw new NotFoundException("Aucune entité pour id ". $id);
        }
        return $entreprise; 
    }

    function getEntrepriseByNom($nom, $pdo) { 
        $sql = "SELECT * FROM O_ENTREPRISE WHERE nom LIKE '%". $nom ."%'"; 
        $exe = $pdo->query($sql); 
        $entreprises = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($entreprises, getEntrepriseFromResult($result));
        }
        return $entreprises; 
    }

    function getEntrepriseByLocalisation($localisation, $pdo) { 
        $sql = "SELECT * FROM O_ENTREPRISE WHERE LOCALISATION LIKE '%".$localisation ."%'";    
        $exe = $pdo->query($sql); 
        $entreprises = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($entreprises, getEntrepriseFromResult($result));
        }
        return $entreprises; 
    }

    function getEntrepriseBySecteur($secteur, $pdo) { 
        $sql = "SELECT * FROM O_ENTREPRISE WHERE SECTEUR LIKE '%".$secteur ."%'";    
        $exe = $pdo->query($sql); 
        $entreprises = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($entreprises, getEntrepriseFromResult($result));
        }
        return $entreprises; 
    }

    function validerEntreprise($entreprise){
        // if(!property_exists($entreprise,'nom')){
        //     throw new ValidationException("Entite invalide : pas de valeur pour 'nom'");
        // } 
    }

    function addEntreprise($entreprise, $pdo){ 
        validerEntreprise($entreprise);
        $sql = "INSERT INTO o_entreprise (NOM, LOCALISATION, SECTEUR) VALUES ('". $entreprise->nom ."', '". $entreprise->localisation ."', '". $entreprise->secteur ."');";
        $pdo->exec($sql);
        return getEntrepriseById($pdo->lastInsertId(), $pdo);
    }

    function updateEntreprise($id, $entreprise, $pdo){
        validerEntreprise($entreprise);
        $sql = "UPDATE o_entreprise SET NOM = '". $entreprise->nom ."', LOCALISATION = '". $entreprise->localisation ."', SECTEUR = '". $entreprise->secteur ."' WHERE id_entreprise = ".$id;    
        $pdo->exec($sql);
        return getEntrepriseById($id, $pdo);
    }

    function deleteEntrepriseById($id, $pdo) { 
        $sql = "DELETE FROM o_entreprise WHERE id_entreprise = ".$id;
        $del = $pdo->exec($sql);
        if($del == 0){
            throw new NotFoundException("Pas de ressource pour l'id : ". $id);
        }
        return true;
    }

    function gestionEntreprise($pdo){
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method){
            case "POST":
                $content = json_decode(file_get_contents('php://input'));
                $value = addEntreprise($content, $pdo);
                break;
            case "GET":
                if (isset($_GET["id"])){
                    $value = getEntrepriseById($_GET["id"], $pdo);
                }else if (isset($_GET["nom"])){
                    $value = getEntrepriseByNom($_GET["nom"], $pdo);
                }else if (isset($_GET["localisation"])){
                    $value = getEntrepriseByLocalisation($_GET["localisation"], $pdo);
                }else if (isset($_GET["secteur"])){
                    $value = getEntrepriseBySecteur($_GET["secteur"], $pdo);
                }else{
                    $value = getListeEntreprise($pdo);
                }
                break;
            case "PUT":
                if (isset($_GET["id"])){
                    $content = json_decode(file_get_contents('php://input'));
                    $value = updateEntreprise($_GET["id"], $content, $pdo);
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to update in the URL.");
                }
                break;
            case "DELETE":
                if (isset($_GET["id"])){
                    $value = deleteEntrepriseById($_GET["id"], $pdo); 
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to delete in the URL.");
                }
                break;
        }
        return $value;
    }

?>
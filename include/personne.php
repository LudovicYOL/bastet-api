<?php

    /*
        PERSONNE
    {
        "nom": "TEST",
        "prenom": "TEST",
        "adresse": null,
        "date_naiss": "1993-10-01",
        "email": "test@gmail.com",
        "telephone": null,
        "promotion": "",
        "statut": "test"
    }
    */

    function getPersonneFromResult($result){
        return array(
            "login" => $result->LOGIN,
            "password" => $result->PASSWORD,
            "id" => $result->ID_PERSONNE,
            "nom" => $result->NOM, 
            "prenom" => $result->PRENOM, 
            "adresse" => $result->ADRESSE,	
            "date_naiss" => $result->DATE_NAISS,
            "email" => $result->EMAIL,
            "telephone" => $result->TELEPHONE,
            "promotion" => $result->PROMOTION,
            "statut" => $result->STATUT);
    }

    function getListePersonne($pdo) { 
        $sql = "SELECT * FROM o_personne"; 
        $exe = $pdo->query($sql); 
        $personnes = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($personnes, getPersonneFromResult($result));
        }
        return $personnes; 
    }
  
    function getPersonneById($id, $pdo) { 
        $sql = "SELECT * FROM o_personne WHERE id_personne = ".$id;    
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $personne = getPersonneFromResult($result); 
        }
        if($personne == null){
            throw new NotFoundException("Aucune entité pour id ". $id);
        }
        return $personne; 
    }

    function getPersonneByNom($nom, $pdo) { 
        $sql = "SELECT * FROM o_personne WHERE nom = '".$nom."'";    
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $personne = getPersonneFromResult($result); 
        }
        if($personne == null){
            throw new NotFoundException("Aucune entité pour nom ". $nom);
        }
        return $personne; 
    }

    function validerPersonne($personne){
        if(!property_exists($personne,'nom')){
            throw new ValidationException("Entite invalide : pas de valeur pour 'nom'");
        } 
    }

    function addPersonne($personne, $pdo){ 
        validerPersonne($personne);
        $sql = "INSERT INTO o_personne (NOM, PRENOM, ADRESSE, EMAIL, TELEPHONE, PROMOTION, STATUT) VALUES ('". $personne->nom ."', '". $personne->prenom ."', '". $personne->adresse ."', '". $personne->email ."', '". $personne->telephone ."', '". $personne->promotion ."', '". $personne->statut ."');";
        $pdo->exec($sql);
        return getPersonneById($pdo->lastInsertId(), $pdo);
    }

    function updatePersonne($id, $personne, $pdo){
        validerPersonne($personne);
        $sql = "UPDATE o_personne SET NOM = '". $personne->nom ."', PRENOM = '". $personne->prenom ."', ADRESSE = '". $personne->adresse ."', EMAIL = '". $personne->email ."', TELEPHONE = '". $personne->telephone ."', PROMOTION = '". $personne->promotion ."', STATUT = '". $personne->statut ."' WHERE id_personne = ".$id;    
        $pdo->exec($sql);
        return getPersonneById($id, $pdo);
    }

    function deletePersonneById($id, $pdo) { 
        $sql = "DELETE FROM o_personne WHERE id_personne = ".$id;
        $del = $pdo->exec($sql);
        if($del == 0){
            throw new NotFoundException("Pas de ressource pour l'id : ". $id);
        }
        return true;
    }

    function gestionPersonne($pdo){
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method){
            case "POST":
                $content = json_decode(file_get_contents('php://input'));
                $value = addPersonne($content, $pdo);
                break;
            case "GET":
                if (isset($_GET["id"])){
                    $value = getPersonneById($_GET["id"], $pdo);
                }else{
                    $value = getListePersonne($pdo);
                }
                break;
            case "PUT":
                if (isset($_GET["id"])){
                    $content = json_decode(file_get_contents('php://input'));
                    $value = updatePersonne($_GET["id"], $content, $pdo);
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to update in the URL.");
                }
                break;
            case "DELETE":
                if (isset($_GET["id"])){
                    $value = deletePersonneById($_GET["id"], $pdo); 
                }else{
                    throw new MissingArgumentException("Please, specify the id of the entity to delete in the URL.");
                }
                break;
        }
        return $value;
    }

?>
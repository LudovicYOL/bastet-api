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
            "id" => $result->ID_PERSONNE,
            "nom" => $result->NOM, 
            "prenom" => $result->PRENOM, 
            "Adresse" => $result->ADRESSE,	
            "date_naiss" => $result->DATE_NAISS,
            "mail" => $result->EMAIL,
            "telephone" => $result->TELEPHONE,
            "promotion" => $result->PROMOTION,
            "statut" => $result->STATUT);
    }

    function get_list_personne($pdo) { 
        $sql = "SELECT * FROM o_personne"; 
        $exe = $pdo->query($sql); 
        $personnes = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($personnes, getPersonneFromResult($result));
        }
        return $personnes; 
    }
  
    function get_personne_by_id($id, $pdo) { 
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

    function validerDonnee($personne){
        if(!property_exists($personne,'nom')){
            throw new ValidationException("Entite invalide : pas de valeur pour 'nom'");
        } 
    }

    function add_personne($personne, $pdo){ 
        validerDonnee($personne);
        $sql = "INSERT INTO o_personne (NOM, PRENOM, ADRESSE, EMAIL, TELEPHONE, PROMOTION, STATUT) VALUES ('". $personne->nom ."', '". $personne->prenom ."', '". $personne->adresse ."', '". $personne->email ."', '". $personne->telephone ."', '". $personne->promotion ."', '". $personne->statut ."');";
        $pdo->exec($sql);
        return get_personne_by_id($pdo->lastInsertId(), $pdo);
    }

    function update_personne($id, $personne, $pdo){
        validerDonnee($personne);
        $sql = "UPDATE o_personne SET NOM = '". $personne->nom ."', PRENOM = '". $personne->prenom ."', ADRESSE = '". $personne->adresse ."', EMAIL = '". $personne->email ."', TELEPHONE = '". $personne->telephone ."', PROMOTION = '". $personne->promotion ."', STATUT = '". $personne->statut ."' WHERE id_personne = ".$id;    
        $pdo->exec($sql);
        return get_personne_by_id($id, $pdo);
    }

    function delete_personne_by_id($id, $pdo) { 
        $sql = "DELETE FROM o_personne WHERE id_personne = ".$id;
        $del = $pdo->exec($sql);
        if($del == 0){
            throw new NotFoundException("Pas de ressource pour l'id : ". $id);
        }
        return true;
    }

?>
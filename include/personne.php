<?php

    // Récupérer la liste de tous les utilisateurs - /personne/
     function get_list_personne($pdo) { 
        $sql = "SELECT * FROM o_personne"; 
        $exe = $pdo->query($sql); 
        $personnes = array(); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($personnes, array(
	            "id" => $result->ID_PERSONNE,
                "nom" => $result->NOM, 
                "prenom" => $result->PRENOM, 
	            "Adresse" => $result->ADRESSE,	
                "date_naiss" => $result->DATE_NAISS,
                "mail" => $result->EMAIL,
                "telephone" => $result->TELEPHONE,
                "promotion" => $result->PROMOTION,
                "statut" => $result->STATUT));
        }
        return $personnes; 
    }
  
    // Récupérer un utilisateur par son id - /personne/{id_personne}
    function get_personne_by_id($id, $pdo) { 
        $sql = "SELECT * FROM o_personne WHERE id_personne = ".$id;    
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $personne = array(
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
        return $personne; 
    }

    // ajouter un utilisateur

    /*
    {
        "nom": "TEST",
        "prenom": "TEST",
        "adresse": null,
        "date_naiss": "1993-10-01",
        "mail": "test@gmail.com",
        "telephone": null,
        "promotion": "",
        "statut": "test"
    }
    */

    function add_personne($personne, $pdo){ // ajouter date naiss et id 
        // Validation de la donnée
        if(!property_exists($personne,'nom')){
            throw new Exception("Pas de nom");
        } 

        try {  
            // Composition de la requête SQL
            $sql = "INSERT INTO o_personne (NOM, PRENOM, ADRESSE, EMAIL, TELEPHONE, PROMOTION, STATUT) VALUES ('". $personne->nom ."', '". $personne->prenom ."', '". $personne->adresse ."', '". $personne->email ."', '". $personne->telephone ."', '". $personne->promotion ."', '". $personne->statut ."');";

            // Ajout dans la base de données
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            $pdo->exec($sql);
            $pdo->commit();
            return "ok";
          } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
          }
    }

    // supprimer un utilisateur
    function delete_personne_by_id($id, $pdo) { 
        try {
            $sql = "DELETE FROM o_personne WHERE id_personne = ".$id;
            $pdo->exec($sql);
            return "deleted";
        }
        catch(PDOException $e)
        {
            return $sql . "<br>" . $e->getMessage();
        }

    }
?>
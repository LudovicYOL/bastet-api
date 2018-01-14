<?php 

    require_once 'config.php';

    // Récupérer la liste de tous les utilisateurs
    function get_list_personne($pdo) { 
        $sql = "SELECT * FROM personne"; 
        $exe = $pdo->query($sql); 
        $personnes = array(); 

        while($result = $exe->fetch(PDO::FETCH_OBJ)) { 
            array_push($personnes, array(
                "nom" => $result->nom, 
                "prenom" => $result->prenom, 
                "date_naissance" => $result->date_naissance,
                "mail" => $result->mail));
        }
        return $personnes; 
    }

    // Récupérer un utilisateur par son nom
    function get_personne_by_nom($nom, $pdo) { 
        $sql = "SELECT * FROM personne WHERE nom = ".$nom;     
        $exe = $pdo->query($sql); 
        while($result = $exe->fetch(PDO::FETCH_OBJ)) {
            $personne = array(
                "nom" => $result->nom, 
                "prenom" => $result->prenom, 
                "date_naissance" => $result->date_naissance,
                "mail" => $result->mail); 
        }
        return $personne; 
    }

    // Gestion API
    $possible_url = array("get_list_personne", "get_personne_by_nom");
    $value = "Une erreur est survenue"; 
    if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { 
        switch ($_GET["action"]) {
        case "get_list_personne": 
            $value = get_list_personne($pdo); 
            break; 
        case "get_personne_by_nom": 
            if (isset($_GET["id"])){
                $value = get_article_by_id($_GET["id"], $pdo); 
            }else{
                $value = "Argument manquant"; 
            } 
            break; 
        } 
    }
    exit(json_encode($value)); 
?>
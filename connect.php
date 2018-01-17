<?php

require_once("config.php");
require_once("include/manager.php");

$code = 200;
$value = "";

$possible_url = array("connect", "disconnect", "info");

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { 
    $action = $_GET["action"];
    try{
        switch ($action) {
            case "connect": 
            $value = connect($pdo);
            break; 

            case "disconnect": 
            $value = disconnect();
            break; 

            case "info":
            $value = info();
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
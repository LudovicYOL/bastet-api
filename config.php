<?php

    define("USER", "root");
    define("PASSWORD", "root");
    define("DNS", 'mysql:host=localhost;dbname=bastet');

    try {
        $pdo = new PDO(DNS, USER, PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    } 
    catch (Exception $e)
    {
        die("Impossible de se connecter : " . $e->getMessage());
    }

?>
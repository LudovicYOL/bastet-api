<?php

    define("USER", "root");
    define("PASSWORD", "root");
    define("DNS", 'mysql:host=localhost;dbname=bastet');

    try { 
        $pdo = new PDO(DNS, USER, PASSWORD); 
    }catch (PDOException $e) {
        die($e->getMessage());
    }

?>
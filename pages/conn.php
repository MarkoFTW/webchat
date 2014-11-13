<?php
    
    try{
        $stmt = new PDO("mysql:host=localhost;dbname=DB_NAME", "username", "password");
    } catch (Exception $ex) {
        die("Error: " . $ex->getMessage());
    }

?>
<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "to-do_list";

    try{
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Connection Failed!: " . $e->getMessage();
    }

?>
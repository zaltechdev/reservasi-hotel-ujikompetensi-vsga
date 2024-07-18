<?php

ob_start();
date_default_timezone_set("asia/jakarta");

function sql(string $query_string, array $params = []){

    $hostname = "localhost";
    $password = "";
    $username = "root";
    $database = "reservasihotel";

    try{
        $pdo = new \PDO("mysql:host=$hostname;dbname=$database",$username,$password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $db = $pdo->prepare($query_string);

        $db->execute($params);
        $fetch = $db->fetchAll(\PDO::FETCH_ASSOC);
        $row = count($fetch);
        $pdo = null;
        
        return [
            "row" => $row,
            "data" => $fetch
        ];
    }
    catch(\PDOException $error){
        die($error);
    }
}

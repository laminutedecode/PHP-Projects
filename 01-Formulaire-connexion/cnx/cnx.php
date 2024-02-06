<?php


$dsn = 'mysql:host=localhost;dbname=comptes;charset=utf8';
$user = 'root';
$pass = "";


try {
    $cnx = new PDO($dsn, $user, $pass);
} catch(PDOException $e){
    echo 'Une erreur est survenu, rééssayer plus tard !';
}



?>
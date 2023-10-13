<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');

if(!$pdo){
    die(var_dump($pdo->errorInfo()));
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $pdo;

?>
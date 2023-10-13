<?php
/** @var $pdo \PDO */
require_once("../../database/connection.php");

$id = $_POST['id'] ?? null;

if(!$id){
    header("Location: index.php " );
    exit;
}

var_dump($id);

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);

$result = $statement->execute();
if($result){
    header("Location: index.php");
}

?>
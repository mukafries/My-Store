<?php
$id = $_POST['id'] ?? null;

if(!$id){
    header("Location: index.php " );
    exit;
}

var_dump($id);

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);

$result = $statement->execute();
if($result){
    header("Location: index.php");
}

?>
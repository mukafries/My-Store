<?php 
/** @var $pdo \PDO */
require_once("../../database/connection.php");
require_once("../../functions.php");

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: index.php " );
    exit;
}

$statement = $pdo->prepare("SELECT * FROM products where id = :id");
$statement->bindValue(':id', $id);
$statement->execute();

$product = $statement->fetch(PDO::FETCH_ASSOC);


$errors =[];
$image_path = $product['image'];
$title = $product['title'];
$price = $product['price'];
$description = $product['description'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['title'])){
        require_once("../../validate-product.php");

        if(empty($errors)){   

            $statement = $pdo->prepare("UPDATE products SET title = :title,
                        image = :image, 
                        description = :description, 
                        price = :price where id = :id");


            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $image_path);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':id', $id);
            $result = $statement->execute();

            if ($result) {
                echo "Product Successfully updated";
                header('Location: index.php');
            }
        }
    }
}

?>

<?php include_once("../../views/partials/header.php");?>
    <br>
    <p>
        <a href="index.php" class="btn btn-secondary">Go back to Products page</a>
    </p>
   

    <h1>Update Product <?= $title?> </h1>

    <?php include_once("../../views/products/form.php");?>

    <?php include_once("../../views/partials/footer.php") ?>
</body>
</html>
<?php 
/** @var $pdo \PDO */
require_once("../../database/connection.php");
require_once("../../functions.php");;

$errors =[];
$title ='';
$price ='';
$description ='';
$image_path ='';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['title'])){

        require_once("../../validate-product.php");

        if(empty($errors)){ 

            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                        VALUES(:title, :image, :description, :price, :date)");

            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $image_path);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', date("Y-m-d H:i:s", time()));

            $result = $statement->execute();

            if ($result) {
                echo "Product Successfully added";
                header('Location: index.php');
            }
        }
    }
}

?>

<?php include_once("../../views/partials/header.php");?>

<p>
    <a href="index.php" class="btn btn-secondary">Go back to Products page</a>
</p>

<h1>Create Product</h1>

<?php include_once("../../views/products/form.php");?>

<?php include_once("../../views/partials/footer.php") ?>
</body>
</html>
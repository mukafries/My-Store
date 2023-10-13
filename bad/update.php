
<?php 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: index.php " );
    exit;
}

$statement = $pdo->prepare("SELECT * FROM products where id = :id");
$statement->bindValue(':id', $id);
$statement->execute();

$product = $statement->fetch(PDO::FETCH_ASSOC);
var_dump($product);


$errors =[];
$image_path = $product['image'];
$title = $product['title'];
$price = $product['price'];
$description = $product['description'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['title'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $date = date("Y-m-d H:i:s", time());

        

        if(!$title){
            $errors[] = "Title is required";
        }
        if(!$price){
            $errors[] = "Price is required";
        }


        if(!is_dir('images/product-images')){
            mkdir('images/product-images');
        }

        if(empty($errors)){

            

            $image = $_FILES['image'] ?? null;
            if($image && $image['tmp_name']){
                if($product['image']){
                    unlink($product['image']);
                }

                $newlocation ='images/product-images/';

                $image_path = $newlocation.random_string(8).'/'.$image['name'];

                mkdir(dirname($image_path));
                move_uploaded_file($image['tmp_name'], $image_path);
                echo $image['tmp_name']." moved to ".$image_path;
            }         

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

function random_string($n){
    $characters = "1234567890QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
    $str ='';
    for ($i =0; $i< $n; $i++){
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

    <title>Update Product</title>
  </head>
  <body>
    <br>
    <a href="index.php" class="btn btn-secondary">Go back to Products page</a>



    <h1>Update Product <?= $title?> </h1>


    <?php if(!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $error): ?>
            <div><?= $error ?></div>
        <?php endforeach ?>
    </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <?php if($image_path):?>
            <img class="update-image" src= "<?= $image_path ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" >
        </div>
        <div class="mb-3">
            <label  class="form-label">Title</label>
            <input type="text" name="title" value="<?= $title ?>" class="form-control" >
        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea type="text" name="description" class="form-control" ><?= $description ?></textarea>
        </div>
        <div class="mb-3">
            <label  class="form-label">Price</label>
            <input type="number" name="price" value="<?= $price ?>" step=".01" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

</table>

</body>
</html>
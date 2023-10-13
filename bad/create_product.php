
<?php 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors =[];
$title ='';
$price ='';
$description ='';
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
            
            $newlocation ='';
            if($image && $image['tmp_name']){
                $newlocation ='images/product-images/';

                $newlocation = $newlocation.random_string(8).'/'.$image['name'];

                mkdir(dirname($newlocation));
                move_uploaded_file($image['tmp_name'], $newlocation);
                echo $image['tmp_name']." moved to ".$newlocation;
            }         

            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                        VALUES(:title, :image, :description, :price, :date)");

            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $newlocation);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);

            $result = $statement->execute();

            if ($result) {
                echo "Product Successfully added";
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

    <title>Create Product</title>
  </head>
  <body>
    <h1>Create Product</h1>
    <?php if(!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $error): ?>
            <div><?= $error ?></div>
        <?php endforeach ?>
    </div>
    <?php endif; ?>

    <form action="create_product.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label  class="form-label">Image</label>
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
   
</table>
  </body>
</html>
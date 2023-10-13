
<?php 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? null;

if($search){
    $statement = $pdo->prepare("SELECT * FROM products WHERE title like :search ORDER BY create_date DESC");

    $statement->bindValue(':search', "%$search%");
}else{
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Products App</title>
  </head>
  <body>
    <h1>Products App</h1>

    <p>
        <a class ='btn btn-success' href='create_product.php'> Create Product</a>
    </p>

    <form>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="search for products" value="<?= $search?>" name="search">
            <button class="btn btn-outline-secondary" type="submit" >Search</button>
        </div>
    </form>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Date Created</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $i => $product):?>
        <tr>
            <th scope="row"><?= $i + 1 ?></th>
            <td>
                <img class='thumb-image' src="<?php echo $product['image'] ?>">
            </td>
            <td><?php echo $product['title'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['create_date'] ?></td>
            <td><a href= "update.php?id=<?= $product['id']?>" type="button" class="btn btn-sm btn-outline-primary">Edit</a>
            <form style='display: inline-block' method="post" action = 'delete.php'>
                <input type='hidden' name='id' value="<?= $product['id']?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        </td>
        </tr>
    <?php endforeach ?>
  </tbody>
</table>
  </body>
</html>
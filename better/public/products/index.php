
<?php
/** @var $pdo \PDO */
require_once("../../database/connection.php");

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

<?php include_once("../../views/partials/header.php");?>

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
                <img class='thumb-image' src="/<?php echo $product['image'] ?>">
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

<?php include_once("../../views/partials/footer.php") ?>
</body>
</html>
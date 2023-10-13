<?php

namespace app;

use PDO;
use app\models\Product;

class Database{

    private ?PDO $pdo;

    private static Database $db;

    public static function db(): Database{
        return new Database();
    }

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_app', 'root','');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$db = $this;
        } catch (\Throwable $th) {
            echo "This is \$th :".$th;
            exit;
        }
        
    }

    public function getProducts($search =''){
        if($search){
            $statement = $this->get_pdo()->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
            $statement->bindValue(':title', "%$search%");
        }else{
            $statement = $this->get_pdo()->prepare("SELECT * FROM products ORDER BY create_date DESC");
        }
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product){

        $statement = $this->get_pdo()->prepare('INSERT INTO products (title, image, description, price, create_date)
                                                VALUES(:title, :image, :description, :price, :date)');
        
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->image_path);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s', time()));

        $statement->execute();
    }

    public function updateProduct(Product $product){
        $statement = $this->get_pdo()->prepare("UPDATE products SET title = :title,
                        image = :image, 
                        description = :description, 
                        price = :price where id = :id");
        
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->image_path);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':id', $product->id);

        return $statement->execute();

        
    }

    public function deleteProduct(int $id){
        $statement = $this->get_pdo()->prepare("DELETE FROM products  where id = :id");

        $statement->bindValue(':id', $id);

        $statement->execute();
    }

    public function getProductById(int $id){
        $statement = $this->get_pdo()->prepare("SELECT * FROM products  where id = :id");

        $statement->bindValue(':id', $id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function get_pdo(): PDO {
        return $this->pdo;
    }



}
?>

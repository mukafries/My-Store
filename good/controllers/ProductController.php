<?php

namespace app\controllers;

use app\Database;
use app\models\Product;
use app\Router;

class ProductController{

    // This routes to the home/index page such that if the searchbox is empty, it shows all products BUT
    // if search is not empty, it shows only results of search products
    public static function index(Router $router){
        $search = $_GET['search'] ?? null;
        $products = Database::db()->getProducts($search);
        $router->renderView("products/index",[
            'products' => $products,
            'search' =>$search
        ]);
    }

    /*
    Gives two options:
    1. checks if the function is accessed through a POST method:
        if yes: it loads the data passed to be a new product which is then saved to the database using the ->load() and -> save function of the product class after which the user is hen redirected to the homepage
    2. if not, uses the GET method: showss the user the form
    */
    public static function create(Router $router){
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'price' =>'',
            'image' =>''
        ];

        $product = new Product();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            

            $product->load($productData);
            $errors = $product->save();
            if(empty($errors)){
                header('Location: /products');
                exit();
            }
        }
        

        $router->renderView("products/create",[
            'product' => $product,
            'errors' => $errors
            ]);
    }

    public static function update(Router $router){
        $errors = [];
        $id = $_GET['id'] ?? null;
        if(!$id){
            header('location: /products');
            exit();
        }
        $productData = Database::db()->getProductById($id);

        $product = new Product();
        $product->load($productData);

        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            $product->title = $_POST['title'];
            $product->description = $_POST['description'];
            $product->price = (float) $_POST['price'];
            $product->imageFile = $_FILES['image'];

            $errors = $product->save();
            if (empty($errors)) {
                header('location: /products');
                exit();
            }
        }

        $router->renderView("products/update",[
            'product' => $product,
            'errors' => $errors
            ]);
    }

    public static function delete(Router $router){
        $id = $_POST['id'] ?? null;
        if(!$id){
            header('location: /products');
            exit();
        }
        Database::db()->deleteProduct($id);
        header('location: /products');
    }
}
?>
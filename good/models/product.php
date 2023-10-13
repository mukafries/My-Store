<?php

namespace app\models;

use app\Database;

class Product{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?string $image_path = null;
    public ?array $imageFile = null;


    public function load($data){
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->price = (float) $data['price'];
        $this->image_path = $data['image'] ?? null;
        $this->imageFile = $data['imageFile'] ?? null;
    }

    public function save(){
        
        $errors = [];
        if(!$this->title){
            $errors[] = 'product title is required';
        }

        if(!$this->price){
            $errors[] = 'product price is required';
        }

        if(!is_dir(__DIR__.'/../public/images')){
            mkdir(__DIR__.'/../public/images');
        }

        if (empty($errors)) {
        
            if ($this->imageFile && $this->imageFile['tmp_name']) {
        
                if ($this->image_path) {
                    unlink(__DIR__."/../public/".$this->image_path);
                }
        
                $newlocation = 'images/product-images/';
        
                $this->image_path = $newlocation . $this->random_string(8) . '/' . $this->imageFile['name'];
        
                mkdir(dirname(__DIR__.'/../public/'.$this->image_path));
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__.'/../public/'.$this->image_path);
                echo $this->imageFile['tmp_name']. " moved to " . $this->image_path;
            }
            if($this->id){
                Database::db()->updateProduct($this);
            }else{
                Database::db()->createProduct($this);                    
            }

        }
        return $errors;
    }

    private function random_string($n){
        $characters = "1234567890QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
        $str ='';
        for ($i =0; $i< $n; $i++){
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
    
        return $str;
    }
    
}


?>
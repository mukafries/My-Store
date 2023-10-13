<?php
namespace app;

use app\Database;

class Router{

    public array $getRoutes =[];
    public array $postRoutes =[];

    public function __construct(){

    }


    public function get($url, $fn){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn){
        $this->postRoutes[$url] = $fn;
    }

    public function resolve(){
        

        // echo "<pre>";
        // var_dump($_SERVER);
        // echo "</pre>";
        $current_url = $_SERVER['REQUEST_URI'] ?? '/';

        if(strpos($current_url, '?') != false){
            $current_url = substr($current_url,0, strpos($current_url, '?'));
        }

        // echo "<pre>";
        // var_dump($current_url);
        // echo "</pre>";
        // exit;
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET'){
            $fn = $this->getRoutes[$current_url] ?? null;
        }
        if($method === 'POST'){
            $fn = $this->postRoutes[$current_url] ?? null;
        }

        if($fn){
            call_user_func($fn, $this);
        }else{
            echo "Error 404: page not found";
        }
    }

    public function renderView($view, $params = []){

        foreach($params as $key => $value){
            $$key = $value; //outputs the reference keys for the values as their own new arrays with their natural variable name i.e 
            // for the array params, it will always contain 'product' and 'errors' as it's keys
            // this then initializes the keys as as their own usable variable which are used later in rendering the pages
        }
        
        ob_start();
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean();
        include_once __DIR__.'/views/layout.php';
    }
}

?>
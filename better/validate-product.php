<?php
require_once('functions.php');

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date("Y-m-d H:i:s", time());



if (!$title) {
    $errors[] = "Title is required";
}
if (!$price) {
    $errors[] = "Price is required";
}


if (!is_dir(__DIR__.'/public/images/product-images')) {
    mkdir(__DIR__.'/public/images/product-images');
}

if (empty($errors)) {

    $image = $_FILES['image'] ?? null;

    if ($image && $image['tmp_name']) {

        // This checks if there is an image for the product sent from the update method
        // This will not execute for validating from create because there's no such variable sent from create product file
        if ($product['image']) {
            unlink(__DIR__."/public/".$product['image']);
        }

        $newlocation = 'images/product-images/';

        $image_path = $newlocation . random_string(8) . '/' . $image['name'];

        mkdir(dirname(__DIR__.'/public/'.$image_path));
        move_uploaded_file($image['tmp_name'], __DIR__.'/public/'.$image_path);
        echo $image['tmp_name'] . " moved to " . $image_path;
    }
}
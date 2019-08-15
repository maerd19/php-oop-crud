<?php
  // This file accepts the ID posted by the JavaScript file.
  // A record will be deleted from the database based on posted ID.
  // check if value was posted
  if($_POST){
      // include database and object file
      include_once 'config/database.php';
      include_once 'objects/product.php';

      // get database connection
      $database = new Database();
      $db = $database->getConnection();

      // set ID property of product to be read
      $product = new Product($db);

      // set ID property of product to be delete
      $product->id = $_POST['object_id'];

      // delete the product
      if($product->delete()){
          echo "Object was deleted.";
      }

      // if unable to delete the product
      else{
          echo "Unable to delete object.";
      }
  }
?>

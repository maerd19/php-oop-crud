<?php
  // include database and object files
  include_once 'config/database.php';
  include_once 'objects/product.php';
  include_once 'objects/category.php';

  // get database connection
  $database = new Database();
  $db = $database->getConnection();

  // prepare and pass connection to objects
  $product = new Product($db);
  $category = new Category($db);
  // set page header
  $page_title = "Create Product";
  include_once "layout_header.php";

  // The following code will render a button that will let us go back to the records list.
  echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
  echo "</div>";

  // The user will enter the values in the HTML form and when the create (submit) button was clicked, values will be sent via POST request
  // This code will assign the "posted" values to the object properties.
  // Once assigned, it will create in the database the values using the create() method.

  // if the form was submitted
  if($_POST){
      // set product property values
      $product->name = $_POST['name'];
      $product->price = $_POST['price'];
      $product->description = $_POST['description'];
      $product->category_id = $_POST['category_id'];

      // The value will be the file name of the submitted file. We used the built-in sha1_file() function to make the file name unique.
      $image = !empty($_FILES["image"]["name"]) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
      $product->image = $image;

      // product was created in database
      if($product->create()){
          echo "<div class='alert alert-success alert-dismissable'>Product was created.</div>";
          // try to upload the submitted file
          // uploadPhoto() method will return an error message, if any.
          echo $product->uploadPhoto();
      }

      // if unable to create the product, tell the user
      else{
          echo "<div class='alert alert-danger'>Unable to create product.</div>";
      }
  }
?>

<!-- The following code will render an HTML form -->
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
              <?php
                // read the product categories from the database
                $stmt = $category->read();
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                    echo "<option>Select category...</option>";

                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_category);
                        echo "<option value='{$id}'>{$name}</option>";
                    }

                echo "</select>";
              ?>
            </td>
        </tr>
        <tr>
            <td>Photo</td>
            <td><input type="file" name="image" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
    </table>
</form>
<?php
// footer
include_once "layout_footer.php";
?>

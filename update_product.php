<?php
  // This code will retrieve data that will populate an HTML form. This will let the user know what record he is updating.
  // get ID of the product to be edited
  $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

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
  $page_title = "Update Product";
  include_once "layout_header.php";

  // The following code will render a button that will let us go back to the records list.
  echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
  echo "</div>";

  // set ID property of product to be edited
  $product->id = $id;

  // read the details of product to be edited
  $product->readOne();

    // The user will enter the values in the HTML form and when the update (submit) button was clicked, values will be sent via POST request
    // This code will assign the "posted" values to the object properties.
    // Once assigned, it will update the database with those values using the update() method.

    // if the form was submitted
    if($_POST){
        // set product property values
        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->description = $_POST['description'];
        $product->category_id = $_POST['category_id'];

        // product was updated
        if($product->update()){
            echo "<div class='alert alert-success alert-dismissable'> Product was updated.</div>";
        }

        // if unable to update the product, tell the user
        else{
            echo "<div class='alert alert-danger alert-dismissable'>Unable to update product.</div>";
        }
    }
  ?>
  <!-- The following code will render an HTML form -->
  <!-- HTML form for updating a product -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
      <table class='table table-hover table-responsive table-bordered'>
          <tr>
              <td>Name</td>
              <td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' /></td>
          </tr>
          <tr>
              <td>Price</td>
              <td><input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' /></td>
          </tr>
          <tr>
              <td>Description</td>
              <td><textarea name='description' class='form-control'><?php echo $product->description; ?></textarea></td>
          </tr>
          <tr>
              <td>Category</td>
              <td>
                <?php
                  // read the product categories from the database
                  $stmt = $category->read();
                  // put them in a select drop-down
                  echo "<select class='form-control' name='category_id'>";
                    echo "<option>Please select...</option>";

                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $category_id=$row_category['id'];
                        $category_name = $row_category['name'];

                        // current category of the product must be selected
                        if($product->category_id==$category_id){
                            echo "<option value='$category_id' selected>";
                        }else{
                            echo "<option value='$category_id'>";
                        }
                        echo "$category_name</option>";
                    }
                  echo "</select>";
                ?>
              </td>
          </tr>
          <tr>
              <td></td>
              <td>
                  <button type="submit" class="btn btn-primary">Update</button>
              </td>
          </tr>
      </table>
  </form>
<?php
  // footer
  include_once "layout_footer.php";
?>

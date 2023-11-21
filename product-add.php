<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $_SESSION['table'] = 'productdb';

  $_SESSION['redirect_to'] = 'product-add.php';

  $user = $_SESSION['user'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product - Inventory System</title>

    <?php include('partials/app-header-scripts.php'); ?>
  </head>
  <body>
    <!-- navigation bar -->
    <?php include('partials/navigation-bar.php')?>
    <!-- Heading section includes logo, title and search bar -->
    <?php include('partials/heading-bar.php')?>
    <!-- Button Section -->
    <?php include('partials/button-bar.php')?>
    <!-- dashboard content -->
    <div class="dashboard-content">
      <div class="dashboard_content_main">
        <div class="row">
          <div class="column">
            <h1 class="section-header">Add Product</h1>
            <div id="userAddFormContainer">
              <form action="database/add-123.php" method="POST" class="appForm" enctype="multipart/form-data">
                  <div class=appFormInputContainer>
                      <label for="ProductName">Product Name</label>
                      <input type="text" id="ProductName" class="appFormInput" placeholder="Enter product name..." name="ProductName" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="Price">Price</label>
                      <input type="text" id="Price" class="appFormInput" placeholder="Enter product Price..." name="Price" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="ProductName">Product Image</label>
                      <input type="file" name="image" value="Upload Image" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="AvailStocks">Avail Stocks</label>
                      <input type="text" id="	AvailStocks" class="appFormInput" placeholder="Enter product quantity..." name="AvailStocks" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="	AvailStocks">Suppliers</label>
                      <select name="suppliers[]" id="suppliersSelect" multiple="">
                        <option value="">Select Supplier</option>
                        <?php
                          $_SESSION['table'] = 'suppliers';
                          $suppliers = include('database/show.php');

                          foreach ($suppliers as $supplier) {
                            echo "<option value='". $supplier['id'] . "'>". $supplier['supplier_name'] ."</option>";
                          }
                      
                        ?>
                      </select>  
                  </div>
                  <button type="submit" class="appBtn">Add Product</button>
              </form>
              <?php if (isset($_SESSION['response'])) { 
                        $response_message = $_SESSION['response']['message'];
                        $is_success = $_SESSION['response']['success'];
              ?>
                <div class="responseMessage">
                  <p class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                    <?= $response_message ?>
                  </p>
                </div>
              <?php unset($_SESSION['response']);}  ?>
            </div>
            <?php include('product-view.php')?>
        </div>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>
  </body>
</html>

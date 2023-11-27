<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
    //Get all the products
    $show_table = 'products';
    $products = include('database/show.php');
    $products = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Order Product - Inventory System</title>

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
            <h1 class="section-header">Order Product</h1>
            <div>
                <div class="alignRight">
                    <button class="orderBtn orderProductBtn">Order Product</button>
                </div>
                <div id="orderProductList"  style="padding-left:30px;">
                    <div class="orderProductRow">
                        <div>
                            <label for="ProductName">Product Name</label>
                            <select name="ProductName" class="productNameSelect" id="ProductName">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="suppliersRows">
                            <div class="row">
                                <div style="width:50%;">
                                    <p class="supplierName">Supplier 1</p>
                                </div>
                                <div style="width:50%;">
                                    <label for="quantity">Quantity: </label>
                                    <input type="number" id="quantity" class="appFormInput" placeholder="Enter Quantity name..." name="quantity" >
                                </div>
                                <div style="width:50%;">
                                    <p class="supplierName">Supplier 2</p>
                                </div>
                                <div style="width:50%;">
                                    <label for="quantity">Quantity: </label>
                                    <input type="number" id="quantity" class="appFormInput" placeholder="Enter Quantity name...." name="quantity" >
                                </div>
                                <div style="width:50%;">
                                    <p class="supplierName">Supplier 3</p>
                                </div>
                                <div style="width:50%;">
                                    <label for="quantity">Quantity: </label>
                                    <input type="number" id="quantity" class="appFormInput" placeholder="Enter Quantity name..." name="quantity" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="alignRight marginTop20">
                    <button class="orderBtn submitOrderProductBtn">Submit Order</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>
  <script>
    var products = <?= $products ?>;

    console.log(products);
  </script>
  </body>
</html>

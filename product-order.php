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
              <form action="database/save-order.php" method="POST">
                <div class="alignRight">
                  <button type="button" class="orderBtn orderProductBtn" id="orderProductBtn">Add Another Product</button>
                </div>

                <div id="orderProductLists"  style="padding-left:30px;">
                  <p id="noData">No products selected</p>
                </div>
                  
                <div class="alignRight marginTop20">
                  <button type="submit" class="orderBtn submitOrderProductBtn">Submit Order</button>
                </div>
              </form>
            </div>
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
        </div>
      </div>
    </div>
  
  <?php include('partials/app-scripts.php'); ?>
  <script>
    var products = <?= $products ?>;
    var counter = 0;

    function script() {

      var vm = this;

      let productOptions =  '\
      <div>\
        <label for="ProductName">Product Name</label>\
        <select name="products[]" class="productNameSelect" id="ProductName">\
          <option value="">Select Product</option>\
          INSERTPRODUCTHERE\
        </select>\
        <button class="btn removeOrderBtn">Remove</button>\
      </div>';
      




      this.initialize = function(){
        this.registerEvents();
        this.renderProductOptions();
      },

      this.renderProductOptions = function(){
        let optionHtml = '';
        products.forEach((product) => {
          optionHtml += '<option value="'+ product.id +'">'+ product.ProductName +'</option>';
        })
        
        productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
      },

      this.registerEvents = function(){
        document.addEventListener('click', function(e){
          targetElement = e.target; // Target element
          classList = targetElement.classList;

          // Add new product order event
          if (targetElement.id === 'orderProductBtn') {
            document.getElementById('noData').style.display = 'none';
            let orderProductListContainer = document.getElementById('orderProductLists');

            orderProductLists.innerHTML += '\
                  <div class="orderProductRow">\
                    '+ productOptions +'\
                    <div class="suppliersRows" id="supplierRows_'+ counter +'" data-counter="'+ counter +'"></div>\
                  </div>';

                  counter++;
          }

          // if remove button os clicked
          if (targetElement.classList.contains('removeOrderBtn')) {

            let orderRow = targetElement.closest('div.orderProductRow');
            // Remove element.
            orderRow.remove();
          }
        });
        
        document.addEventListener('change', function(e){
          targetElement = e.target; // Target element
          classList = targetElement.classList;

          // Add suppliers row on product option change
          if (classList.contains('productNameSelect')) {
            let pid = targetElement.value;

            let counterId = targetElement.closest('div.orderProductRow').querySelector('.suppliersRows').dataset.counter;

            $.get('database/get-product-supplier.php', {id: pid} , function(suppliers){
              vm.renderSupplierRows(suppliers, counterId);
            }, 'json');
          }
        });  
      },

      this.renderSupplierRows = function(suppliers, counterId) { 
        let supplierRows = '';

        suppliers.forEach((supplier) => {
                supplierRows +='\
                        <div class="row">\
                          <div style="width:50%;">\
                            <p class="supplierName">'+ supplier.supplier_name +'</p>\
                          </div>\
                          <div style="width:50%;">\
                            <label for="quantity">Quantity: </label>\
                            <input type="number" id="quantity" class="appFormInput orderProductQty"  placeholder="Enter Quantity name..." name="quantity['+ counterId +']['+ supplier.id +']" >\
                          </div>\
                        </div>';
        });                        

        //Append to container
        let supplierRowContainer = document.getElementById('supplierRows_' + counterId);
        supplierRowContainer.innerHTML = supplierRows;
      }
    }
    
    (new script()).initialize();
  </script>
  </body>
</html>

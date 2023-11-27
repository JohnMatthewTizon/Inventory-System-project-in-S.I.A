<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');




  $show_table = 'suppliers';
  $suppliers = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supplier - Inventory System</title>

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
            <h1 class="section-header">List of Suppliers</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Supplier Name</th>
                      <th>Location</th>
                      <th>Products</th>
                      <th>Email</th>
                      <th>Admin</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($suppliers as $index => $supplier) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="lastname"><?= $supplier['supplier_name'] ?></td>
                        <td class="lastname"><?= $supplier['supplier_location'] ?></td>
                        <td>
                        <?php

                            $product_list = '-';

                            $sid = $supplier['id'];
                            $stmt = $conn->prepare("SELECT ProductName 
                                  FROM 
                                    products, productsuppliers 
                                  WHERE 
                                    productsuppliers.supplier = $sid
                                      AND
                                    productsuppliers.product = products.id");
                            $stmt->execute();
                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($row) {
                              $product_arr = array_column($row, 'ProductName');
                              $product_list = '<li>' . implode("</li><li>", $product_arr);
                            }

                            echo $product_list;
                        ?>
                        </td>
                        <td class="email"><?= $supplier['email'] ?></td>
                        <td>
                            <?php
                                $uid = $supplier['adminId'];
                                $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['email'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td>
                          <a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>" >Edit</a>
                          <a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>"data-sid="<?= $supplier['id'] ?>">Delete</a>
                        </td>
                      </tr>

                    <?php  } ?>
                    

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
        include('partials/app-scripts.php'); 
        
        $show_table = 'products';
        $products = include('database/show.php');

        $products_arr = [];

        foreach ($products as $product) {
          $products_arr[$product['id']] = $product['ProductName'];
        }

        $products_arr = json_encode($products_arr);


  ?>
  <script>
    function script(){
      var productsList =  <?= $products_arr ?>;


      var vm = this;
      this.registerEvents = function(){
        document.addEventListener('click', function(e){
          targetElement = e.target; // Target element
          classList = targetElement.classList;
          
          if(classList.contains("deleteSupplier")){
            e.preventDefault(); // this prevents the default mechanism.

            sId = targetElement.dataset.sid;
            supplierName = targetElement.dataset.name;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              title: 'Delete Supplier',
              message: 'Are you sure to delete <strong>'+ supplierName +'</strong>?',
              callback: function(isDelete){
                if(isDelete){
                  $.ajax({
                  method: 'POST',
                  data: {
                    id: sId,
                    table: 'suppliers'
                  },
                  url: 'database/delete.php',
                  dataType: 'json',
                    success: function(data){
                      message = data.success ?
                        supplierName + ' successfully deleted!' : 'Error processing your request!';
                      
                      BootstrapDialog.alert({
                        type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                        message: message,
                        callback: function(){
                          if(data.success) location.reload();
                        }
                      });
                    }
                  });
                }else {
                  alert('cancelled');
                }

                
              }
            });
          }
          
          if (classList.contains("updateSupplier")) {
            e.preventDefault(); // this prevents the default mechanism.

            sId = targetElement.dataset.sid;
            vm.showEditDialog(sId);


          }
        });

        document.addEventListener('submit', function(e){
          e.preventDefault();
          targetElement = e.target;

          if(targetElement.id === 'editSupplierForm') {
            vm.saveUpdatedDate(targetElement);
            
          }
        })

      },
      
      this.saveUpdatedDate = function(form){
        $.ajax({
          method: 'POST',
          data: {
            supplier_name: document.getElementById('supplier_name').value,
            supplier_location: document.getElementById('supplier_location').value,
            email: document.getElementById('email').value,
            products: $('#products').val(),
            sid: document.getElementById('sid').value
          },
          url: 'database/update-supplier.php',
          dataType: 'json',
          success: function(data){
            BootstrapDialog.alert({
              type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
              message: data.message,
              callback:function(){
                if (data.success) location.reload();
              }
            });
          }
        });
      },

      this.showEditDialog = function(id){
        $.get('database/get-supplier.php', {id: id}, function(supplierDetails){
            let curProducts = supplierDetails['products'];
            let productOptions = '';

            for(const [pId, pName] of Object.entries(productsList)) {
              selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
              productOptions += "<option "+ selected +" value='"+ pId +"'>"+ pName +"</option>";
            }
            BootstrapDialog.confirm({
              title: 'Update <strong>' + supplierDetails.supplier_name + '</strong>',
              message: '<form action="database/add-123.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
              <div class=appFormInputContainer>\
                  <label for="supplier_name">Supplier Name</label>\
                  <input type="text" id="supplier_name" class="appFormInput" value="'+ supplierDetails.supplier_name +'" placeholder="Enter supplier name..." name="supplier_name" >\
              </div>\
              <div class=appFormInputContainer>\
                  <label for="supplier_location">Location</label>\
                  <input type="text" id="supplier_location" class="appFormInput" value="'+ supplierDetails.supplier_location +'" placeholder="Enter location of the supplier..." name="supplier_location" >\
              </div>\
              <div class=appFormInputContainer>\
                <label for="	products">Products</label>\
                  <select name="products[]" id="products" multiple="">\
                    <option value="">Select Products</option>\
                    '+ productOptions +'\
                  </select>\
              </div>\
              <div class=appFormInputContainer>\
                  <label for="email">email</label>\
                  <input type="email" id="email" class="appFormInput" value="'+ supplierDetails.email +'" placeholder="Enter email of the supplier..." name="email" >\
              </div>\
              <input type="hidden" name="sid" id="sid" value="'+ supplierDetails.id +'" />\
              <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden" />\
              </form>\
              ',
              callback: function(isUpdate){
                if(isUpdate){ // if user click 'OK' button
                  document.getElementById('editSupplierSubmitBtn').click();      
                }
              }
            });
        }, 'json');
      },

      this.initialize = function(){
        this.registerEvents();
      } 


    }

    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

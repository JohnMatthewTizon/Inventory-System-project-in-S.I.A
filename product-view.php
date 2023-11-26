<?php
  //Start the session.

  if (!isset($_SESSION['user'])) header('location: index.php');



  $user = $_SESSION['user'];
  $show_table = 'products';
  $products = include('database/show.php');
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
    
          <div class="column">
            <h1 class="section-header">List of Products</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>Supplier</th>
                      <th>Admin</th>
                      <th>Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $index => $product) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="productImages">
                          <img class="productImages" src="uploads/products/<?= $product['image']?>" alt="">
                        </td>
                        <td class="lastname"><?= $product['ProductName'] ?></td>
                        <td>
                            <?php

                                $supplier_list = '-';

                                $pid = $product['id'];
                                $stmt = $conn->prepare("SELECT supplier_name 
                                      FROM 
                                        suppliers, productsuppliers 
                                      WHERE 
                                        productsuppliers.product = $pid
                                          AND
                                        productsuppliers.supplier = suppliers.id");
                                $stmt->execute();
                                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if ($row) {
                                  $supplier_arr = array_column($row, 'supplier_name');
                                  $supplier_list = '<li>' . implode("</li><li>", $supplier_arr);
                                }

                                echo $supplier_list;
                            ?>
                        </td>
                        <td>
                            <?php
                                $uid = $product['adminId'];
                                $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['email'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td class="email"><?= $product['Price'] ?></td>
                        <td>
                        <a href="" class="updateProduct" data-pid="<?= $product['id'] ?>">Edit</a>
                          <a href="" class="deleteProduct" data-name="<?= $product['ProductName'] ?>"data-pid="<?= $product['id'] ?>">Delete</a>
                        </td>
                      </tr>

                    <?php  } ?>
                    

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
  <?php include('partials/app-scripts.php'); ?>
  <script>
    function script(){
      var vm = this;
      this.registerEvents = function(){
        document.addEventListener('click', function(e){
          targetElement = e.target; // Target element
          classList = targetElement.classList;
          
          if(classList.contains("deleteProduct")){
            e.preventDefault(); // this prevents the default mechanism.

            pId = targetElement.dataset.pid;
            pName = targetElement.dataset.name;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              title: 'Delete Product',
              message: 'Are you sure to delete <strong>'+ pName +'</strong>?',
              callback: function(isDelete){
                if(isDelete){
                  $.ajax({
                  method: 'POST',
                  data: {
                    id: pId,
                    table: 'products'
                  },
                  url: 'database/delete.php',
                  dataType: 'json',
                    success: function(data){
                      message = data.success ?
                        pName + ' successfully deleted!' : 'Error processing your request!';
                      
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

          if (classList.contains("updateProduct")) {
            e.preventDefault(); // this prevents the default mechanism.

            pId = targetElement.dataset.pid;
            vm.showEditDialog(pId);


          }
        });

        document.addEventListener('submit', function(e){
          e.preventDefault();
          targetElement = e.target;

          if(targetElement.id === 'editProductForm') {
            vm.saveUpdatedDate(targetElement);
            
          }
        })

      },
      
      this.saveUpdatedDate = function(form){
        $.ajax({
          method: 'POST',
          data: new FormData(form),
          url: 'database/update-product.php',
          processData: false,
          contentType: false,
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
        $.get('database/get-product.php', {id: id}, function(productDetails){
            BootstrapDialog.confirm({
              title: 'Update <strong>' + productDetails.ProductName + '</strong>',
              message: '<form action="database/add-123.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
              <div class=appFormInputContainer>\
                <label for="ProductName">Product Name</label>\
                <input type="text" id="ProductName" class="appFormInput" value="'+ productDetails.ProductName +'" placeholder="Enter product name..." name="ProductName" >\
              </div>\
              <div class=appFormInputContainer>\
                <label for="Price">Price</label>\
                <input type="text" id="Price" class="appFormInput" value="'+ productDetails.Price +'" placeholder="Enter product Price..." name="Price" >\
              </div>\
              <div class=appFormInputContainer>\
              <label for="ProductName">Product Image</label>\
                <input type="file" name="image">\
              </div>\
              <div class=appFormInputContainer>\
                <label for="suppliers">Suppliers</label>\
                <input type="text" id="suppliers" class="appFormInput" placeholder="Edit Supplier.." name="supplier" >\
              </div>\
              <input type="hidden" name="pid" value="'+ productDetails.id +'" />\
              <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden" />\
              </form>\
              ',


              callback: function(isUpdate){
                if(isUpdate){ // if user click 'OK' button

                  document.getElementById('editProductSubmitBtn').click();      

                }
              }
            });
        }, 'json');



      }
      
      this.initialize = function(){
        this.registerEvents();
      } 


    }

    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

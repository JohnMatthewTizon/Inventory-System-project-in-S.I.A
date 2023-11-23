<?php
  //Start the session.

  if (!isset($_SESSION['user'])) header('location: index.php');



  $user = $_SESSION['user'];
  $_SESSION['table'] = 'productdb';
  $productdb = include('database/show.php');
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
                      <th>Price</th>
                      <th>Avail Stocks</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($productdb as $index => $product) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="productImages">
                          <img class="productImages" src="uploads/products/<?= $product['image']?>" alt="">
                        </td>
                        <td class="lastname"><?= $product['ProductName'] ?></td>
                        <td class="email"><?= $product['Price'] ?></td>
                        <td class="email"><?= $product['AvailStocks'] ?></td>
                        <td>
                          <a href="" class="deleteProduct" data-name="<?= $product['ProductName'] ?>"data-pid="<?= $product['ProductID'] ?>">Delete</a>
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
                    table: 'productdb'
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
        });
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

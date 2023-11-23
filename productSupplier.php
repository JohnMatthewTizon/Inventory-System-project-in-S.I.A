<?php
  //Start the session.

  if (!isset($_SESSION['user'])) header('location: index.php');



  $user = $_SESSION['user'];
  $_SESSION['table'] = 'productsuppliers';
  $productsuppliers = include('database/show.php');
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
            <h1 class="section-header">List of Informations Ordered</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Supplier</th>
                      <th>Product</th>
                      <th>Updated at</th>
                      <th>Created at</th>\
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($productsuppliers as $index => $productSupp) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?php
                                $uid = $productSupp['supplier'];
                                $stmt = $conn->prepare("SELECT * FROM suppliers WHERE id=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['supplier_name'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td>
                            <?php
                                $uid = $productSupp['product'];
                                $stmt = $conn->prepare("SELECT * FROM productdb WHERE ProductID=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['ProductName'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td class="email"><?= $productSupp['updated_at'] ?></td>
                        <td class="email"><?= $productSupp['created_at'] ?></td>
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

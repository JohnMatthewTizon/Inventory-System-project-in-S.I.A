<?php
  //Start the session.

  if (!isset($_SESSION['user'])) header('location: index.php');



  $user = $_SESSION['user'];
  $_SESSION['table'] = 'suppliers';
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
                      <th>Email</th>
                      <th>Created_by</th>
                      <th>Created_at</th>
                      <th>Updated-at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($suppliers as $index => $supplier) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="lastname"><?= $supplier['supplier_name'] ?></td>
                        <td class="lastname"><?= $supplier['supplier_location'] ?></td>
                        <td class="email"><?= $supplier['email'] ?></td>
                        <td>
                            <?php
                                $uid = $supplier['created_by'];
                                $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($supplier['created_at'])) ?></td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($supplier['updated_at'])) ?></td>
                        <td>
                          <a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>">Edit</a>
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
  <?php include('partials/app-scripts.php'); ?>
  <script>
    function script(){

      this.registerEvents = function(){
        document.addEventListener('click', function(e){
          targetElement = e.target; // Target element
          classList = targetElement.classList;
          
          if(classList.contains("deleteSupplier")){
            e.preventDefault(); // this prevents the default mechanism.

            sId = targetElement.dataset.sid;
            pName = targetElement.dataset.name;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              title: 'Delete Supplier',
              message: 'Are you sure to delete <strong>'+ pName +'</strong>?',
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

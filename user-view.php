<?php
  //Start the session.
  if (!isset($_SESSION['user'])) header('location: index.php');
  $show_table = 'users';
  
  $_SESSION['redirect_to'] = 'user-add.php';
  $users = include('database/show.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User - Inventory System</title>

    <?php include('partials/app-header-scripts.php'); ?>
  </head>
  <body>
    <!-- dashboard content -->


          <div class="column">
            <h1 class="section-header">List of Admin</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Email</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Employee Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $index => $user) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="email"><?= $user['email'] ?></td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($user['created_at'])) ?></td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($user['updated_at'])) ?></td>
                        <td>
                            <?php
                                $uid = $user['emp'];
                                $stmt = $conn->prepare("SELECT * FROM tbempinfo WHERE empid=$uid");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                $created_by_name = $row['firstname'] . ' ' . $row['lastname'];
                                echo $created_by_name; 
                            ?>
                        </td>
                        <td>
                          <a href="" class="updateUser" data-userid="<?= $user['id'] ?>">Edit</a>
                          <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-email="<?= $user['email'] ?>" >Delete</a>
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
      
      this.initialize = function(){
        this.registerEvents();
      },

      this.registerEvents = function(){
        document.addEventListener('click', function(e){
          targetElement = e.target;
          classList = targetElement.classList;

          
          if(classList.contains("deleteUser")){
            e.preventDefault();
            userId = targetElement.dataset.userid;
            userEmail = targetElement.dataset.email;
            EmailName = userEmail;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              message: 'Are you sure to delete '+ EmailName +'?',
              callback: function(isDelete){
                $.ajax({
                  method: 'POST',
                  data: {
                    user_id: userId,
                    user_email: userEmail
                  },
                  url: 'database/delete-user.php',
                  dataType: 'json',
                  success: function(data){
                          if(data.success){
                              BootstrapDialog.alert({
                                type: BootstrapDialog.TYPE_SUCCESS,
                                message: data.message,
                                callback: function(){
                                  location.reload();
                                }
                              });
                            }else 
                              BootstrapDialog.alert({
                                type: BootstrapDialog.TYPE_DANGER,
                                message: data.message,
                              });
                  }
                });
              }
            });
          }

          if(classList.contains("updateUser")){
            e.preventDefault(); // prevent from refreshing or loading.

            // Get data.
            email = targetElement.closest('tr').querySelector('td.email').innerHTML;
            userId = targetElement.dataset.userid;

            BootstrapDialog.confirm({
              title: "Update " + email,
              message: '<form>\
                <div class="form-group">\
                  <label for="email">Email address:</label>\
                  <input type="email" class="form-control" id="emailUpdate" value="'+ email +'">\
                </div>\
              </form>',
              callback: function(isUpdate){
                if(isUpdate){ // if user click 'OK' button
                  $.ajax({
                    method: 'POST',
                    data: {
                      userId: userId,
                      email: document.getElementById('emailUpdate').value
                    },
                    url: 'database/update-user.php',
                    dataType: 'json',
                    success: function(data){
                      if(data.success){
                        BootstrapDialog.alert({
                          type: BootstrapDialog.TYPE_SUCCESS,
                          message: data.message,
                          callback: function(){
                            location.reload();
                          }
                        });
                      }else 
                        BootstrapDialog.alert({
                          type: BootstrapDialog.TYPE_DANGER,
                          message: data.message,
                        });
                    }
                  })
                }
              }
            });
          }
        });
      }
  } 
    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

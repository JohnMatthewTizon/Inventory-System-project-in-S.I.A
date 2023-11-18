<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $_SESSION['table'] = 'users';
  $user = $_SESSION['user'];

  
  $_SESSION['redirect_to'] = 'user-add.php';
  $show_table = 'users';
  $users = include('database/show-users.php');
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
            <h1 class="section-header">Insert New Admin</h1>
            <div id="userAddFormContainer">
              <form action="database/add.php" method="POST" class="appForm">
                  <div class=appFormInputContainer>
                      <label for="first_name">First Name</label>
                      <input type="text" id="first_name" class="appFormInput" name="first_name" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="last_name">Last Name</label>
                      <input type="text" id="last_name" class="appFormInput" name="last_name" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="email">Email</label>
                      <input type="text" id="email" class="appFormInput" name="email" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="password">Password</label>
                      <input type="password" id="password" class="appFormInput" name="password" >
                  </div>
                  <button type="submit" class="appBtn">Add New Admin</button>
              </form>
              <?php if (isset($_SESSION['response'])) { 
                        $response_message = $_SESSION['response']['message'];
                        $is_success = $_SESSION['response']['success'];
              ?>
                <div class="responseMessage">
                  <p class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                    <?=   $response_message ?>
                  </p>
                </div>
              <?php unset($_SESSION['response']);}  ?>
            </div>
          <div class="column">
            <h1 class="section-header">List of Admin</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $index => $user) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="firstname"><?= $user['first_name'] ?></td>
                        <td class="lastname"><?= $user['last_name'] ?></td>
                        <td class="email"><?= $user['email'] ?></td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($user['created_at'])) ?></td>
                        <td><?= date('M d, Y @ h:i:s: A' , strtotime($user['updated_at'])) ?></td>
                        <td>
                          <a href="" class="updateUser" data-userid="<?= $user['id'] ?>">Edit</a>
                          <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>" >Delete</a>
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
            fname = targetElement.dataset.fname;
            lname = targetElement.dataset.lname;
            fullName = fname + ' ' + lname;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              message: 'Are you sure to delete '+ fullName +'?',
              callback: function(isDelete){
                $.ajax({
                  method: 'POST',
                  data: {
                    user_id: userId,
                    f_name: fname,
                    l_name: lname 
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
            firstName = targetElement.closest('tr').querySelector('td.firstname').innerHTML;
            lastName = targetElement.closest('tr').querySelector('td.lastname').innerHTML;
            email = targetElement.closest('tr').querySelector('td.email').innerHTML;
            userId = targetElement.dataset.userid;

            BootstrapDialog.confirm({
              title: "Update " + firstName + " " + lastName,
              message: '<form>\
                <div class="form-group">\
                  <label for="firstName">First Name:</label>\
                  <input type="text" class="form-control" id="firstName" value="'+ firstName +'">\
                </div>\
                <div class="form-group">\
                  <label for="lastName">Last Name:</label>\
                  <input type="text" class="form-control" id="lastName" value="'+ lastName +'">\
                </div>\
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
                      f_name: document.getElementById('firstName').value,
                      l_name: document.getElementById('lastName').value,
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
            })
          }
        });
      }
  } 
    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

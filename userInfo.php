<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $show_table = 'tbempinfo';
  
  $_SESSION['redirect_to'] = 'user-add.php';
  $tbempinfo = include('database/show.php');
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
            <h1 class="section-header">Insert New Employee Information</h1>
            <div id="userAddFormContainer">
            <form action="database/add-123.php" method="POST" class="appForm">
                  <div class=appFormInputContainer>
                      <label for="firstname">First Name</label>
                      <input type="text" id="firstname" class="appFormInput" name="firstname" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="lastname">Last Name</label>
                      <input type="text" id="lastname" class="appFormInput" name="lastname" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="department">Department</label>
                      <input type="text" id="department" class="appFormInput" name="department" >
                  </div>
                  <button type="submit" class="appBtn">Add Admin Info</button>
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
            <h1 class="section-header">List of Admin Information</h1>
            <div class="section-content">
              <div class="users">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>first Name</th>
                      <th>Lasr Name</th>
                      <th>Department</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($tbempinfo as $index => $emp) { ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="email"><?= $emp['firstname'] ?></td>
                        <td class="email"><?= $emp['lastname'] ?></td>
                        <td class="email"><?= $emp['department'] ?></td>
                        <td>
                          <a href="" class="deleteEmployee" data-userid="<?= $emp['empid'] ?>" data-fname="<?= $emp['firstname'] ?>" >Delete</a>
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

            empId = targetElement.dataset.userid;
            empfname = targetElement.dataset.fname;
            Firstname = empfname;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              message: 'Are you sure to delete '+ Firstname +'?',
              callback: function(isDelete){
                $.ajax({
                  method: 'POST',
                  data: {
                    emp_id: empId,
                    emp_fname: empfname
                  },
                  url: 'database/delete-Employee.php',
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

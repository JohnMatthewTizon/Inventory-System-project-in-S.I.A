<?php
  //Start the session.

  if (!isset($_SESSION['user'])) header('location: index.php');
  $show_table = 'tbempinfo';

  $_SESSION['redirect_to'] = 'userInfo-add.php';
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

          
          if(classList.contains("deleteEmployee")){
            e.preventDefault();

            empId = targetElement.dataset.userid;
            empfname = targetElement.dataset.fname;
            Firstname = empfname;

            BootstrapDialog.confirm({
              type: BootstrapDialog.TYPE_DANGER,
              message: 'Are you sure to delete <strong>'+ Firstname +'</strong>?',
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
                                message: Firstname + ' Successfully deleted.',
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
        });
      }
  } 
    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

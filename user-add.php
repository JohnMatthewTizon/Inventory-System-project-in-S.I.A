<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $_SESSION['table'] = 'users';
  
  $_SESSION['redirect_to'] = 'user-add.php';
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

              <form action="database/add-123.php" method="POST" class="appForm">
                  <div class=appFormInputContainer>
                      <label for="email">Email</label>
                      <input type="text" id="email" class="appFormInput" name="email" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="password">Password</label>
                      <input type="password" id="emp" class="appFormInput" name="emp" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="emp">Employee</label>
                      <select name="emp" id="suppliersSelect" multiple="">
                        <option value="">Select Employee</option>
                        <?php
                          $show_table = 'tbempinfo';
                          $tbempinfo = include('database/show.php');

                          foreach ($tbempinfo as $emp) {
                            echo "<option value='". $emp['empid'] . "'>". $emp['lastname'] ."</option>";
                          }
                      
                        ?>
                      </select>  
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
        </div>
        <?php include('user-view.php')?>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>
  </body>
</html>

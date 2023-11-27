<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $show_table = 'tbempinfo';
  $_SESSION['table'] = 'tbempinfo';
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
        </div>
        <?php include('userInfo-view.php'); ?>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>

  </body>
</html>

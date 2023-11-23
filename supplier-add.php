<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
  $_SESSION['table'] = 'suppliers';

  $_SESSION['redirect_to'] = 'supplier-add.php';

  $user = $_SESSION['user'];


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
            <h1 class="section-header">Add Supplier</h1>
            <div id="userAddFormContainer">
              <form action="database/add-123.php" method="POST" class="appForm" enctype="multipart/form-data">
                  <div class=appFormInputContainer>
                      <label for="supplier_name">Supplier Name</label>
                      <input type="text" id="supplier_name" class="appFormInput" placeholder="Enter supplier name..." name="supplier_name" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="supplier_location">Location</label>
                      <input type="text" id="supplier_location" class="appFormInput" placeholder="Enter location of the supplier..." name="supplier_location" >
                  </div>
                  <div class=appFormInputContainer>
                      <label for="email">email</label>
                      <input type="email" id="email" class="appFormInput" placeholder="Enter email of the supplier..." name="email" >
                  </div>
                  <button type="submit" class="appBtn">Add Supplier</button>
              </form>
              <?php if (isset($_SESSION['response'])) { 
                        $response_message = $_SESSION['response']['message'];
                        $is_success = $_SESSION['response']['success'];
              ?>
                <div class="responseMessage">
                  <p class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                    <?= $response_message ?>
                  </p>
                </div>
              <?php unset($_SESSION['response']);}  ?>
            </div>
        </div>
        <?php include('supplier-view.php')?>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>
  </body>
</html>

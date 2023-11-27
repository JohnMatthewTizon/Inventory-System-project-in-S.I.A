<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');
 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Order Product - Inventory System</title>

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
            <h1 class="section-header">Order Product</h1>
            <div id="userAddFormContainer">
              <form action="" method="POST" class="appForm">

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php include('partials/app-scripts.php'); ?>
  </body>
</html>

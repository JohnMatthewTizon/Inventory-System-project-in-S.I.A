<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');

           // Include the database connection file
           include('database/connection.php');

           // SQL query to retrieve data from the table
           $sql = "SELECT * FROM tbempinfo";
           $result = $conn->query($sql);
           $result->execute();

           if ($result->rowCount() > 0) {
             $result->setFetchMode(PDO::FETCH_ASSOC);
             $empinfo = $result->fetchAll()[0];

             $_SESSION['empinfo'] = $empinfo;
           }
    
  $empinfo = $_SESSION['empinfo'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory System</title>
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

        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>
  </body>
</html>
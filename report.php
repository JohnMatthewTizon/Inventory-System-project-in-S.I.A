<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');

  $user = $_SESSION['user'];
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
            <div id="reportsContainer">
                <div class="box">
                    <div class="reportType">
                        <p>Export Products</p>
                        <div class="alignRight">
                            <a href="database/report_csvproduct.php?report=product" class="reportExportBtn">Export</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Supplier</p>
                        <div class="alignRight">
                            <a href="database/report_csvsupplier.php?report=supplier" class="reportExportBtn">Export</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Deliveries</p>
                        <div class="alignRight">
                            <a href="database/report_csvproductSuppliers.php?report=order_product_history" class="reportExportBtn">Export</a>
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Purchase Order</p>
                        <div class="alignRight">
                            <a href="database/report_csvpurchaseorder.php?report=product_in" class="reportExportBtn">Export</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>
  </body>
</html>

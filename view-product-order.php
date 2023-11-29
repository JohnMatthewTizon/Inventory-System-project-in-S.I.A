<?php
  //Start the session.
  session_start();
  if (!isset($_SESSION['user'])) header('location: index.php');




  $show_table = 'suppliers';
  $suppliers = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> View Purchase Orders - Inventory System</title>

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
            <h1 class="section-header">List of Purchase Orders</h1>
            <div class="section-content">
              <div class="poListContainers">
                <?php
                $stmt = $conn->prepare("SELECT product_in.id, products.ProductName, product_in.quantity_ordered, product_in.batch, product_in.quantity_received, users.email, suppliers.supplier_name, product_in.status, product_in.created_at  
                      FROM product_in, suppliers, products, users
                      WHERE 
                        product_in.supplier = suppliers.id
                          AND
                        product_in.adminId = users.id
                      ORDER BY
                        product_in.created_at DESC
                        ");
                $stmt->execute();
                $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $data = [];
                foreach ($purchase_orders as $purchase_order) {
                    $data[$purchase_order['batch']][] = $purchase_order;
                }
                ?>

                <?php
                    foreach ($data as $batch_id => $batch_pos) {
                ?>
                <div class="poList" id="container-<?= $batch_id ?>">
                    <p>Batch #:<?= $batch_id ?></p>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty Ordered</th>
                                <th>Qty Received</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Ordered By</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($batch_pos as $index => $batch_po) {
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td class="po_product"><?= $batch_po['ProductName']?></td>
                                <td class="po_qty_ordered"><?= $batch_po['quantity_ordered']?></td>
                                <td class="po_qty_received"><?= $batch_po['quantity_received']?></td>
                                <td class="po_qty_supplier"><?= $batch_po['supplier_name']?></td>
                                <td class="po_qty_status"><span class="po-badge po_qty_status"><?= $batch_po['status']?></span></td>
                                <td><?= $batch_po['email']?></td>
                                <td>
                                    <?= $batch_po['created_at']?>
                                    <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="poOrderUpdateBtnContainer alignRight">
                        <button class="appbtn updatePoBtn" data-id="<?= $batch_id ?>">Update</button>
                    </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('partials/app-scripts.php');?>
  <script>
    function script(){


      var vm = this;
      this.registerEvents = function(){
        document.addEventListener('click', function(e){
            targetElement = e.target;
            classList = targetElement.classList;

            if(classList.contains('updatePoBtn')){
                e.preventDefault();

                batchNumberContainer = 'container-' + targetElement.dataset.id;
                
                // Get all purchase order product records

                productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
                supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');

                poListsArr = [];

                for (i=0;i<productList.length;i++){
                  poListsArr.push({
                    name: productList[i].innerText,
                    qtyOrdered: qtyOrderedList[i].innerText,
                    qtyReceived: qtyReceivedList[i].innerText,
                    supplier: supplierList[i].innerText,
                    status: statusList[i].innerText,
                  });
                }
                

                productList.forEach((product, key) => {
                  poListsArr[key]['product'] = product.innerText;
                });

                return;
            }
        })
      },

      this.initialize = function(){
        this.registerEvents();
      } 


    }

    var script = new script;
    script.initialize();
  </script>
  </body>
</html>

<?php

$product_name = $_POST['ProductName'];
$Price = $_POST['Price'];
$pid = $_POST['pid'];



//upload or move the file to directory
$target_dir = "../uploads/products/";

$file_name_value = NULL;
$file_data = $_FILES['image'];

if ($file_data['tmp_name'] !== '') {
    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'product-' . time() . '.' . $file_ext;


    $check = getimagesize($file_data['tmp_name']);
    // Move the file
    if ($check) {
        if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)){
        // Save the file_name to the database.
        $file_name_value = $file_name;
        }
    }
}



// Save the database
try {
    $sql = "UPDATE products SET ProductName=?, Price=?, image=?
            WHERE id=?";


        include('connection.php');

        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_name, $Price, $file_name_value, $pid]);

        //Delete the old values.
        $sql ="DELETE FROM productsuppliers WHERE product=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$pid]);

        // Loop through the suppliers and add record
        //Get suppliers
        $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
        foreach ($suppliers as $supplier) {
            $supplier_data = [
                'supplier_id' => $supplier,
                'product_id' => $pid,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $sql = "INSERT INTO productsuppliers
                                    (supplier, product, updated_at, created_at)
                                VALUES 
                                    (:supplier_id, :product_id, :updated_at, :created_at)";

            include('connection.php');

            $stmt = $conn->prepare($sql);
            $stmt->execute($supplier_data);
        }
    

        $response = [
            'success' => true,
            'message' => "<strong>$product_name</strong> Successfully updated to the system."
        ];
} catch (\Exception $e) {
    $response = [
        'success' => false,
        'message' => "Error processing your request "
    ];
}


        echo json_encode($response);
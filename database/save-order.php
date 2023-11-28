<?php

session_start();

$post_data = $_POST;
$products = $post_data['products'];
$qty = array_values($post_data['quantity']);

$post_data_arr = [];

foreach ($products as $key => $pid) {
    if (isset($qty[$key])) $post_data_arr[$pid] = $qty[$key];
}

//Include Connection
include('connection.php');


// Store data.
$batch = time();

$success = false;

try {
    foreach ($post_data_arr as $pid => $supplier_qty){
        foreach ($supplier_qty as $sid => $qty) {
        // Insert to database.
    
        $values = [
            'supplier' => $sid,
            'product' => $pid,
            'quantity_ordered' => $qty,
            'status' => 'ORDERED',
            'batch' => $batch,
            'adminId' => $_SESSION['user']['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $sql = "INSERT INTO product_in
                                (supplier, product, quantity_ordered, status, batch, adminId, updated_at, created_at)
                            VALUES 
                                (:supplier, :product, :quantity_ordered, :status, :batch, :adminId, :updated_at, :created_at)";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
        }
    } 
    $success = true;
    $message = 'Order Successfully created!';
} catch (\Exception $e) {
    $message = $e->getMessage();
}

$_SESSION['response'] = [
    'message' => $message,
    'success'=> $success
];


header('location: ../product-order.php');


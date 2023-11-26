<?php
    $data = $_POST;
    $id = (int) $data['emp_Id'];
    $firstname = $data['emp_fname'];

    

    try {
        
        $command = "DELETE FROM tbempinfo WHERE empid ={$id}";
    
        include('connection.php');

        $conn->exec($command);
        
        echo json_encode([
            'success' => true,
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
        ]);
    }
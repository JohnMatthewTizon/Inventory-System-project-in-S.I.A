<?php
    $data = $_POST;
    $user_id = (int) $data['user_id'];
    $user_email = $data['user_email'];

    try {
        
        $command = "DELETE FROM users WHERE id={$user_id}";
    
        include('connection.php');

        $conn->exec($command);
        
        echo json_encode([
            'success' => true,
                'message' => $user_email. ' successfully deleted.'
        ]);
    } catch (\PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request!'
        ]);
    }

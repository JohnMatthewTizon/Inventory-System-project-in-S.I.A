<?php
    $data = $_POST;
    $user_id = (int) $data['userId'];
    $email = $data['email'];

    // Adding the record.
    try {
        $sql = "UPDATE users SET email=?, updated_at=? WHERE id=?";    
        include('connection.php');
        $conn->prepare($sql)->execute([$email, date('Y-m-d h:i:s'), $user_id]);
        echo json_encode([
            'success' => true,
            'message' => $email. ' successfully updated.'
        ]);
    } catch (\PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request!'
        ]);
    }

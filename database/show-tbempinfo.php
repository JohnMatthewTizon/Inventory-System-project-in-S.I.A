<?php

  $error_message = '';

  if ($_POST) {
    include('database/connection.php');
    
    $query = 'SELECT * FROM tbempinfo';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $emp = $stmt->fetchAll()[0];

      // Captures data of currently login users.
      $_SESSION['emp']= $emp;

  }
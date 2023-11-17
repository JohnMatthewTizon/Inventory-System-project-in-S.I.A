<?php
  //Start the session.
  session_start();
  if(isset($_SESSION['user'])) header('location:Dashboard.php');

  $error_message = '';

  if ($_POST) {
    include('database/connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = 'SELECT * FROM users WHERE users.email="'. $username .'" AND users.password="'. $password .'"';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $user = $stmt->fetchAll()[0];

      // Captures data of currently login users.
      $_SESSION['user']= $user;

      header('Location: dashboard.php');
    }else $error_message = 'Please make sure that username and password are correct.';
    
  }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Inventory Management System</title>
    <?php include('partials/app-header-scripts.php'); ?>
  </head>
  <body id="Container">
    <?php if (!empty($error_message)) { ?>
    <div id="errorMessage">
      <strong>ERROR:</strong><p><?= $error_message ?></p>
    </div>
    <?php } ?>
    <!-- Login form -->
    <div class="login-container">
      <h2>CICS INVENTORY</h2>
      <form action="index.php" method="POST">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
  </body>
</html>

<?php
  $user = $_SESSION['user'];
?>    
    <!-- navigation bar -->
    <div class="navbar">
      <div class="navbar-title">Inventory System</div>
      <div class="user-info">
        <p>Welcome,<span><?=$user['email']?></span></p>
        <a href="database/logout.php" id="logoutBtn"><i class="fa fa-sign-out"></i>Log-out</a>
      </div>
    </div>
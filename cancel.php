<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
  //session has not started
  session_start();
};

// connects to the datbase
include("php/connection.php");

// logout code
include("php/logout.php");

include("php/setAvailable.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("php/head.php"); ?>
</head>

<body class="main">

  <!--Navbar-->
  <?php include("php/navbar.php"); ?>

  <!--Main-->
  <div class="container mt-5 mb-5 pt-1 pb-4 p-3 text-center" style="border: 1px solid #000000; border-radius:12px; background-color: #ffffff; min-height: 430px;">
  <div class="status">
    <h1 class="error">Your transaction was canceled!</h1>
  </div>
  <a href="index.php" class="btn-link">Back to Product Page</a>
</div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php

if (session_status() == PHP_SESSION_NONE) {
  //session has not started
  session_start();
};


// connects to the datbase
include("php/connection.php");

// logout code
include("php/logout.php");
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
  <div style="display: block; height: 60vh; min-height: 350px;" aria-modal="true">
    <div class="modal-dialog modal-login" style="margin-top: 4%; box-shadow: 10px 10px 5px grey;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reset your password</h4>
        </div>

        <div class="modal-body">
          <p>An e-mail will be sent to you with instructions on how to reset your password.</p>
          <form action="php/reset-request-submit.php" method="post">
            <input type="text" name="email" placeholder="Enter your e-mail address...">
            <button type="submit" name="submit">Recieve new password by email</button>
          </form>

          <?php
          if (isset($_GET["reset"])) {
            if ($_GET["reset"] == "success"){
              echo "<p class='signupsuccess'>Check your e-mail!</p>";
            }
          }
          ?>

        </div>
      </div>
    </div>
  </div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
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

// Handles button presses for the site
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['Email'];
  $comment = $_POST['Comment'];

  $subject = "Support Query - BigPrizeDraw Contact Form";
  $message = "From: $email\n\n$comment";

  if (mail("monomeno1@gmail.com", $subject, $message)) {
    $response = "Email successfully sent, we will get in touch soon!";
  } else {
    $response = "Email sending failed...";
  }
}
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
  <div style="display: block; height: 60vh; min-height: 350px; margin-bottom: 50px;" aria-modal="true">
    <div class="modal-dialog modal-login" style="margin-top: 4%; box-shadow: 10px 10px 5px grey;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Contact Us</h4>
        </div>




        <!-- /\/\/\/\/\/
            \/\/ MAIN LOGIN FORM
            /\/\/\/\/\/\/\/\-->

        <div class="modal-body">
          <p>We will try to respond to any of your queries as soon as possible. Send us a question using the form below : </p>
          <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="sendMail">
            <div class="form-group" data-children-count="1">
              <i class="fa fa-envelope" style="margin: 3px;"></i>
              <input type="email" class="form-control" placeholder="Your Email..." required="required" name="Email">
            </div>
            <div class="form-group" data-children-count="1">
              <i class="fa fa-comment" style="margin: 3px;"></i>
              <textarea style="resize: none;" class="form-control" placeholer="Your message..." rows="4" cols="50" name="Comment"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary btn-block btn-lg" value="send">
            </div>
            <?php
            if (isset($response) && $response != "") {
              echo "<h5 class='p-2 bg-success text-white'> $response </h5>";
            }
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
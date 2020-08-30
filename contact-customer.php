<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php
// Initialize the session
if(session_status() == PHP_SESSION_NONE){
    //session has not started
    session_start();
};

// connects to the datbase
include("php/connection.php");

// logout code
include("php/logout.php");

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("Location: index.php");
}

$all = true;

$firstName = "";
$surname = "";
$email = "";

// gets details from header
if (isset($_GET['id'])) {
  $all = false;

  $query = "SELECT * FROM `tblusers` WHERE userID=" . $_GET['id'];
  $result = mysqli_query($conn, $query);

  $user = mysqli_fetch_array($result);

  $firstName = $user['firstName'];
  $surname = $user['surname'];
  $email = $user['email'];
}

// Handles button presses for the site
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $subject = $_POST['Subject'];
  $comment = $_POST['Comment'] . ""; // IMAGES CAN BE ADDED FROM WEB SERVER HTML FORMAT

  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  if (!$all) {
    if (mail($email, $subject, $comment, $headers)) {
      $response = "Email successfully sent!";
    } else {
      $response = "Email sending failed...";
    }
  } else {
    $query = "SELECT * FROM `tblusers`";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
      $email = $row['email'];

      if (mail($email, $subject, $comment)) {
        $response = "Email successfully sent!";
      } else {
        $response = "Email sending failed...";
      }
    }
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
          <h4 class="modal-title">Send email to <?php if ($all) {
                                                  echo "all";
                                                } else {
                                                  echo "$firstName $surname";
                                                } ?> :</h4>
        </div>


        <!-- /\/\/\/\/\/
            \/\/ MAIN Contact Form
            /\/\/\/\/\/\/\/\-->

        <div class="modal-body">

          <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="sendMail">
            <div class="form-group" data-children-count="1">
              <i class="fa fa-envelope" style="margin: 3px;"></i>
              <input type="text" class="form-control" placeholder="Email Subject..." required="required" name="Subject">
            </div>
            <div class="form-group" data-children-count="1">
              <i class="fa fa-comment" style="margin: 3px;"></i>
              <textarea style="resize: none;" class="form-control" placeholer="Your message..." required="required" rows="8" cols="50" name="Comment"></textarea>
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
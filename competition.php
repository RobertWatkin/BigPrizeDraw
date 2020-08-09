<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php
// Initialize the session
session_start();

// Connect to Database
include("php/connection.php");

// logout code
include("php/logout.php");

// display comps
include("php/dynamic-table.php");



// create sql code to search for users with the given email
$query = "SELECT * FROM `tblcompetitions` WHERE competitionID=".$_GET['comp'];
$result = mysqli_query($conn, $query);

// Handles button presses for the site
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["tickets"])){
    foreach($_POST["tickets"] as $ticketID){
      if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = array();
      }
      array_push($_SESSION["basket"],$ticketID);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("php/head.php"); ?>
  <link rel="stylesheet" href="stylesheets/compButtons.css">
</head>

<body class="main">
  <!--Navbar-->
  <?php include("php/navbar.php"); ?>

  <!--Main-->
  <!-- Content section -->


  <div class="container mt-2 mb-2 pt-1 p-3" style="border: 1px solid #000000; border-radius:12px; background-color: #ffffff;">
  <?php
    if (mysqli_num_rows($result) < 1) {
      echo "
      <div class='text-center' style='height: 70vh;'>
        <h1 class='mt-5'>This Competition Does Not Exist.</h1>
        <h4>Please click <a href='index.php'>here</a> to return to the home page</h4>
      </div>";
    } else {
      include("php/displayCompetition.php");
    }
  ?>
  </div>


  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
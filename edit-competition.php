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

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("Location: index.php");
}

// connects to the datbase
include("php/connection.php");

// Double check that the user has admin access
//================================
$id = $_SESSION["userID"];

$query = "SELECT * FROM `tblusers` WHERE userID='$id' and isAdmin=1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) < 1) {
  header("Location: index.php");
}
//==================================

// logout code
include("php/logout.php");

// create competition code
include("php/new-comp.php");

$query = "SELECT * FROM `tblcompetitions` WHERE competitionID=" . $_GET['comp'];
$result = mysqli_query($conn, $query);

$comp = $row = mysqli_fetch_array($result);
$competitionID = $comp['competitionID'];
$title = $comp['title'];
$desc = $comp['description'];
$price = $comp['pricePerTicket'];
$numTickets = $comp['numberOfTickets'];
$image = $comp['image'];
$date = $comp['drawDate'];
$isActive = $comp['isActive'];


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
  <?php

  if (mysqli_num_rows($result) < 1) {
    echo "
    <div class='container mt-5 mb-5' style='border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;'>
      <div class='text-center' style='height: 70vh;'>
        <h1 class='mt-5'>This Competition Does Not Exist.</h1>
        <h4>Please click <a href='index.php'>here</a> to return to the home page</h4>
      </div>
    </div>";
  } else {
    $row = mysqli_fetch_row($result);
    echo "
  <div class='container mt-5 mb-5' style='border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;'>

    <h1>Edit Competition - Competition ID : </h1>
    <form " . $_SERVER['PHP_SELF'] . " method='post' name='signup' enctype='multipart/form-data'>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-gift' style='margin: 3px;'></i>
        <input type='text' class='form-control' placeholder='Competition Name / Prize' required='required' name='title' value='".$title."'/>
      </div>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-gift' style='margin: 3px;'></i>
        <input type='text' class='form-control' placeholder='Short Description' required='required' name='description' value='".$desc."' />
      </div>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-ticket' style='margin: 3px;'></i>
        <p><i>Number of Tickets Cannot be Changed<i> - This competition has $numTickets tickets</p>
      </div>


      <div class='form-group' data-children-count='1'>
        <i class='fa fa-picture-o' style='margin: 3px;'></i> Competition Image 
        <br>
        <p> Current : </p>
        <img src='$image' style='width: 30%'>
        <p> Select New Image : </p>
        <input class='form-control-file' type='file' name='file'>
      </div>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-calendar' style='margin: 3px;'></i> Competition Draw Date
        <br>
        <input type='datetime-local' id='drawdate'
        name='drawDate'  REQUIRED>
      </div>
      
        

      <div class='form-group'>
        <input type='submit' class='btn btn-success btn-block btn-lg' name='Save Changes' value='Save Changes'></input>
      </div>

      <div class='form-group'>
        <input type='submit' class='btn btn-danger btn-block btn-lg' name='Delete Competition' value='Delete Competition'></input>
      </div>
    </form>
  </div>";
  }
  ?>



  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
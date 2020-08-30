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
$winnerTicketID = $comp['winnerTicketID'];


// edit competition code
include("php/edit-comp.php");


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
  <div class='container mt-5 mb-5' style='border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;'>
  <?php
  if (mysqli_num_rows($result) < 1) {
    echo "
      <div class='text-center' style='height: 70vh;'>
        <h1 class='mt-5'>This Competition Does Not Exist.</h1>
        <h4>Please click <a href='index.php'>here</a> to return to the home page</h4>
      </div>
    </div>";
  } else {
    $row = mysqli_fetch_row($result);
    echo "
    <h1>Edit Competition - Competition ID : </h1>
    <form " . $_SERVER['PHP_SELF'] . " method='post' name='signup' enctype='multipart/form-data'>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-gift' style='margin: 3px;'></i>
        <input type='text' class='form-control' placeholder='Competition Name / Prize' required='required' name='title' value='" . $title . "'/>
      </div>

      <div class='form-group' data-children-count='1'>
        <i class='fa fa-gift' style='margin: 3px;'></i>
        <input type='text' class='form-control' placeholder='Short Description' required='required' name='description' value='" . $desc . "' />
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
        <p>Current : $date</p>
        <p>Select New (leave blank to keep current date) :</p>
        <input type='datetime-local' id='drawdate'
        name='drawDate'>
      </div>
      
        

      <div class='form-group'>
        <input type='submit' class='btn btn-success btn-block btn-lg' name='btnSave' value='Save Changes'></input>
      </div>

      <div class='form-group'>
        <input type='submit' class='btn btn-danger btn-block btn-lg' name='btnDelete' value='Delete Competition' onclick=\"return confirm('Are you sure you wish to delete this competition? THIS CANNOT BE UNDONE')\"></input>
      </div>
    </form>

    <hr>";


    if ($isActive == 1) {
      echo "
      <h2>Select a Winner</h2>
      <hr>
      <form method='post'>
      <div class='' data-toggle='buttons' style='display: flex; flex-wrap: wrap; justify-content: flex-start; padding: 10px;'>
      ";

      $query = "SELECT * FROM `tbltickets` WHERE competitionID=" . $_GET['comp'];
      $result = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['userID']) && isset($row['userID'])) {
          echo " 
            <label class='btn btn-success' style='margin: 3px; width: 50px; height: 50px;'>
                <input type='radio' name='selectedTicket' value='" . $row['ticketID'] . "' style='display:none; padding: auto;'><b>" . $row['ticketNumber'] . "</b>
            </label>";
        } else {
          echo "
            <label class='btn btn-info' style='opacity: 0.8; margin: 3px; width: 50px; height: 50px;' disabled>
                <input type='checkbox' name='invalid[]' value='" . $row['ticketID'] . "' style='display:none; padding: auto;' disabled><b>" . $row['ticketNumber'] . "</b>
            </label>";
        }
      }
      echo "
      </div>
      <input id='submitButton' class='btn btn-success center' type='submit' name='btnSelectWinner' value='Select' onclick=\"return confirm('Are you sure?')\"/>
      </form>
      <br>
      </div>
      ";
    } else {
      if (isset($winnerTicketID) && !empty($winnerTicketID)){
      // Display winner details

        $query = "SELECT * FROM `tbltickets` WHERE ticketID=" . $winnerTicketID;
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0){

          $row = mysqli_fetch_row($result);
          $tnum = $row[2];



          $query = "SELECT * FROM `tblusers` WHERE userID=" . $row[4];
          $result = mysqli_query($conn, $query);

          $row = mysqli_fetch_row($result);
          $fname = $row[1];
          $sname = $row[2];
          $email = $row[3];
          $phone = $row[5];

          echo "
            <h2>Competition Winner</h2>
            <h6>This competition winner has been drawn. Find their details below :</h6>
            <table class='table'>
              <thead>
                <tr>
                  <th scope='col'>Ticket Number</th>
                  <th scope='col'>First</th>
                  <th scope='col'>Last</th>
                  <th scope='col'>Email</th>
                  <th scope='col'>Phone Number</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope='row'>$tnum</th>
                  <td>$fname</td>
                  <td>$sname</td>
                  <td>$email</td>
                  <td>$phone</td>
                </tr>
              </tbody>
            </table>
          ";
        } else {
          echo "
          <h2>An error has occured - no ticket could be found with the given ID</h2>";
        }
      } else {
      // Display competition no longer active
        echo "
        <h2>This competition is no longer active</h2>
        ";
      }
    }
  }
  ?>
  </div>
  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
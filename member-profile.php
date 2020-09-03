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

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("Location: index.php");
}

// connects to the datbase
include("php/connection.php");

// logout code
include("php/logout.php");

// RETRIEVE USER DETAILS
$userquery = "SELECT * FROM `tblusers` WHERE userID='".$_SESSION['userID']."'";
$userresults = mysqli_query($conn, $userquery);

$userrow = mysqli_fetch_array($userresults);

$fname = $userrow['firstName'];
$sname = $userrow['surname'];
$number = $userrow['phoneNumber'];

include("php/save-details.php");
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
  <div class="container mt-5 mb-5" style="border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;">
    <h1>Your Account</h1>
    <h2>Your Tickets</h2>
    <?php

    $query = "SELECT * FROM `tbltickets` WHERE userID='" . $_SESSION['userID'] . "' AND purchased=1";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) > 0) { ?>
      <table class='table'>
        <thead>
          <tr>
            <th scope='col'>Competition</th>
            <th scope='col'>Ticket Number</th>
            <th scope='col'>Price</th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($row = mysqli_fetch_array($results)) {
            $query = "SELECT * FROM `tblcompetitions` WHERE competitionID=" . $row['competitionID'];
            $result = mysqli_query($conn, $query);

            while ($comprow = mysqli_fetch_array($result)) {
              $cimg = $comprow['image'];
              $ctitle = $comprow['title'];
              $cprice = $comprow['pricePerTicket'];
            }
          ?>
            <tr>
              <th scope='row'><?php echo $ctitle; ?></th>
              <td><?php echo $row['ticketNumber']; ?></td>
              <td>£<?php echo $cprice; ?></td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
    <?php
    } else { ?>
      <div class="text-center">
        <h3>You currently have no active tickets</h3>
        <h5>Click <a href='index.html'>here</a> to browse competitions</h5>
      </div>
    <?php
    }
    ?>

    <!-- =========== MEMBER DETAILS ============= -->
    <h2>Your Details</h2>

    <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="save">
      <?php
      // displays error message to the user
      if (isset($errorMessage) && strlen($errorMessage) != 0) {
        echo "
              <div style='border-radius: 5px; color: #ffffff; background-color: #f05050;'>
                  <i class='fa fa-ban' style='float: right; margin: 6px;'></i>
                  <p style='padding: 3px;'>$errorMessage</p>
              </div>
              ";
      }
      ?>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-user" style="margin: 3px;"></i>
        <div class="form-inline">
          <input style="width: 47.5%; margin-right: 5%;" type="text" class="form-control" placeholder="First Name*" required="required" name="Firstname" value='<?php echo $fname; ?>'>
          <input style="width: 47.5%;" type="text" class="form-control" placeholder="Surname*" required="required" name="Surname" value='<?php echo $sname; ?>'>
        </div>
      </div>
      <div class="form-group" data-children-count="1">
        <i class="fa fa-envelope" style="margin: 3px;"></i>
        <input type="email" class="form-control" placeholder="Email*" required="required" name="Email" value='<?php echo $_SESSION['email']; ?>''>
      </div>
      <div class="form-group" data-children-count="1">
        <i class="fa fa-mobile" style="font-size: 24px; margin: 3px;"></i>
        <input type="tel" class="form-control" placeholder="Phone Number* - e.g 07123456789" required="required" pattern="[0-9]{11}" name="Number" value='<?php echo $number; ?>'>
      </div>

      <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block btn-lg" value="Save" name="submit">
      </div>
    </form>
  </div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
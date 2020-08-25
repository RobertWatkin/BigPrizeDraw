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
  <div class="container mt-2 mb-2 pt-1 p-3" style="border: 1px solid #000000; border-radius:12px; background-color: #ffffff;">
  <?php
 
          $total = 0;
          // Display Items
          if (isset($_SESSION['basket']) && count($_SESSION['basket']) >= 1) {
            echo "
            <form method='post'>
            <table class='table'>
            <thead>
              <tr>
                <th scope='col'>Competition</th>
                <th scope='col'>Ticket Number</th>
                <th scope='col'>Price</th>
                <th scope='col'>Select</th>
              </tr>
            </thead>
            <tbody>";
            // Gather data for tickets
            foreach ($_SESSION['basket'] as $id) {

              

              $query = "SELECT * FROM `tbltickets` WHERE ticketID=" . $id;
              $result = mysqli_query($conn, $query);

              $cid = 0;
              $cimg = "";
              $ctitle = "";
              $tnum = 0;

              while ($row = mysqli_fetch_array($result)) {
                $tnum = $row['ticketNumber'];
                $cid = $row['competitionID'];
              }

              $query = "SELECT * FROM `tblcompetitions` WHERE competitionID=" . $cid;
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_array($result)) {
                $cimg = $row['image'];
                $ctitle = $row['title'];
                $cprice = $row['pricePerTicket'];

                $total += $cprice;

                // HTML for navbar basket
                echo "
                <tr>
                  <th scope='row'>$ctitle</th>
                  <td>$tnum</td>
                  <td>£$cprice</td>
                  <td><input type='checkbox' name='delTickets[]' value=$id></td>
                </tr>
              
              ";
              }
            }
          } else {
            echo "
            <div class='text-center' style='margin: 100px;'>
              <h2 style='margin-bottom: 30px;'> There are no items in your basket </h4>
              <h5>Click <a href='index.php'>here</a> to find competitions</h5>
            </div>
            <hr>";
          }
          echo "
            </tbody>
            </table>
            </p>Total: <b>£$total</b></p>
            <button class='btn btn-danger' style='width: 40%; min-width: 100px;' name='delete' type='submit'>Remove</button>
            </form>
          ";

          include("stripe/stripe-payment-form.php");
          ?>
  </div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>
</html>


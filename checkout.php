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
  echo "
          
          <form method='post'>
            <ul class='' style='width: 100%; role='menu'>";
          $total = 0;
          // Display Items
          if (isset($_SESSION['basket']) && count($_SESSION['basket']) >= 1) {
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
                <li style='padding: 5px;'>
                <h6><b>" . $ctitle . "</b></h6>
                  
                  <div class='row justify-content-end' style='width: 100%;'>
                    <div class='col'>
                      <div class='box'>
                        <img src='" . $cimg . "' alt='comp image' style='height: 60px;' />
                      </div>
                    </div>
                    <div class='col'>
                      <div class='box'>
                        <p style='margin-bottom:0px;'>Number: <b>$tnum</b></p>
                        <p style='margin-bottom:0px;'>Price: <b>£$cprice</b></p>
                      </div>
                    </div>
                    <div class='col'>
                      <div class='box' style='padding: 10px; float: right;'>
                          <input type='checkbox' name='delTickets[]' value=$id>
                      </div>
                    </div>
                  </div>
                  <hr>
                </li>
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
            </p>Total: <b>£$total</b></p>
            <input type='hidden' name='cmd' value='_ext-enter'>
            <form action='https://www.paypal.com/us/cgi-bin/webscr' method='post'>
              <input type='hidden' name='cmd' value='_xclick'>
              <input type='hidden' name='business' value='robert_watkin@yahoo.co.uk'>
              <input type='hidden' name='item_name' value='Item Name'>
              <input type='hidden' name='currency_code' value='GBP'>
              <input type='hidden' name='amount' value='$total'>
              <input type='image' class='paypal-button-logo paypal-button-logo-paypal paypal-button-logo-gold' src='http://www.paypal.com/en_US/i/btn/x-click-but01.gif' name='submit' alt='Make payments with PayPal - it's fast, free and secure!'>
            </form>

            <form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
              <input type='hidden' name='cmd' value='_s-xclick'>
              <input type='hidden' name='hosted_button_id' value='P5ETB4NZPDRZC'>
              <input type='image' src='https://www.paypalobjects.com/en_GB/i/btn/btn_buynow_LG.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
              <img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
            </form>

            
            <button class='btn btn-danger' style='width: 40%; min-width: 100px; margin-left: 10%;' name='delete' type='submit'>Remove</button>
            </ul>
            </form>
          ";
          ?>
  </div>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>
</html>


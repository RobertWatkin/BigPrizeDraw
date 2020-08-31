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


require_once 'config.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php include("php/head.php"); ?>

  <!-- Stripe JavaScript library -->
  <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="main">

  <!--Navbar-->
  <?php include("php/navbar.php"); ?>

  <!--Main-->
  <div class="container mt-5 mb-5 pt-1 pb-4 p-3" style="border: 1px solid #000000; border-radius:12px; background-color: #ffffff; min-height: 430px;">
    <h2>Checkout</h2>
    <div id='paymentResponse'></div>
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

    //
    //  PAYMENT SECTION
    //

    $_SESSION['total'] = $total;
    $productPrice = $total;

    echo "
            </tbody>
            </table>
            <p class='p-3'>Total: <b>£$total</b></p>
            <div style='width: 50%; float: left; text-align: center;'>
              <button class='btn btn-danger' style='width: 90%;' name='delete' type='submit'>Remove</button>
            </div>
            </form>
          ";

    ?>



    <div id='buynow' style='width: 50%; float: left;'>
      <form method="post">
        <button class='btn btn-success stripe-button' id='payButton' name='pay' style='width: 90%;'>Buy Now</button>
      </form>
    </div>
    <div style="height: 50px;"></div>
    <div id="paymentResponse"></div>
    <div id="resultMsg"></div>
    <div id="invalidTickets"></div>

  </div>

  <script>
    var buyBtn = document.getElementById('payButton');
    var responseContainer = document.getElementById('paymentResponse');

    // Create a Checkout Session with the selected product
    var createCheckoutSession = function(stripe) {
      return fetch("stripe_charge.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          checkoutSession: 1,
        }),
      }).then(function(result) {
        return result.json();
      });
    };

    // Handle any errors returned from Checkout
    var handleResult = function(result) {
      if (result.error) {
        responseContainer.innerHTML = '<p>' + result.error.message + '</p>';
      }
      buyBtn.disabled = false;
      buyBtn.textContent = 'Buy Now';
    };

    // Specify Stripe publishable key to initialize Stripe.js
    var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

    buyBtn.addEventListener("click", function(evt) {
      buyBtn.disabled = true;
      buyBtn.textContent = 'Please wait...';


      var usedTickets = "<?php include('php/checkAvailability.php'); ?>";


      if (usedTickets == "") {
        $('#resultMsg').load('php/setUnavailable.php');

        createCheckoutSession().then(function(data) {
          if (data.sessionId) {
            stripe.redirectToCheckout({
              sessionId: data.sessionId,
            }).then(handleResult);
          } else {
            handleResult(data);
          }
        });
      } else {
        responseContainer.innerHTML = '<h5 class="p-3 bg-danger text-white"> There has been an error with your request. Tickets <b>' + usedTickets + '</b> is no longer available. Please remove these from your basket<h5>';
      }
    });
  </script>

  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>
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

$_SESSION['purchased'] = array();

$payment_id = $statusMsg = '';
$ordStatus = 'error';

// Check whether stripe checkout session is not empty 
if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];

    // Fetch transaction data from the database if already exists 
    $sql = "SELECT * FROM orders WHERE checkout_session_id = '" . $session_id . "'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $orderData = $result->fetch_assoc();

        $paymentID = $orderData['id'];
        $transactionID = $orderData['txn_id'];
        $paidAmount = $orderData['paid_amount'];
        $paidCurrency = $orderData['paid_amount_currency'];
        $paymentStatus = $orderData['payment_status'];

        $ordStatus = 'success';
        $statusMsg = 'Your Payment has been Successful!';
    } else {
        // Include Stripe PHP library  
        require_once 'stripe-php-master/init.php';
        require_once 'config.php';

        // Set API key 
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

        // Fetch the Checkout Session to display the JSON result on the success page 
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $checkout_session) {
            // Retrieve the details of a PaymentIntent 
            try {
                $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            // Retrieves the details of customer 
            try {
                // Create the PaymentIntent 
                $customer = \Stripe\Customer::retrieve($checkout_session->customer);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $intent) {
                // Check whether the charge is successful 
                if ($intent->status == 'succeeded') {
                    // Customer details 
                    $name = $customer->name;
                    $email = $customer->email;

                    // Transaction details  
                    $transactionID = $intent->id;
                    $paidAmount = $intent->amount;
                    $paidAmount = ($paidAmount / 100);
                    $paidCurrency = $intent->currency;
                    $paymentStatus = $intent->status;

                    // Insert transaction data into the database 
                    $sql = "INSERT INTO orders(name,email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,checkout_session_id,created,modified) VALUES('" . $name . "','" . $email . "','" . $productName . "','" . $productID . "','" . $productPrice . "','" . $currency . "','" . $paidAmount . "','" . $paidCurrency . "','" . $transactionID . "','" . $paymentStatus . "','" . $session_id . "',NOW(),NOW())";
                    $insert = $conn->query($sql);
                    $paymentID = $conn->insert_id;

                    // If the order is successful 
                    if ($paymentStatus == 'succeeded') {
                        $statusMsg = 'Your Payment has been Successful!';

                        foreach ($_SESSION['basket'] as $id) {
                            $query = "UPDATE `tbltickets` SET purchased=1, userID='" . $_SESSION['userID'] . "' WHERE ticketID='$id'";
                            $run = mysqli_query($conn, $query);
                        }

                        $_SESSION['purchased'] = $_SESSION['basket'];
                        $_SESSION['basket'] = null;
                    } else {
                        $statusMsg = "Your Payment has failed!";
                    }
                } else {
                    $statusMsg = "Transaction has been failed!";
                }
            } else {
                $statusMsg = "Unable to fetch the transaction details! $api_error";
            }

            $ordStatus = 'success';
        } else {
            $statusMsg = "Transaction has been failed! $api_error";
        }
    }
} else {
    $statusMsg = "Invalid Request!";
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
    <div class="container mt-5 mb-5" style="border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;">
        <div class="status">
            <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>
            <?php if (!empty($paymentID)) { ?>
                <h4>Payment Information</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Reference Number:</th>
                            <td><?php echo $paymentID; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Transaction ID:</th>
                            <td><?php echo $transactionID; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Paid Amount:</th>
                            <td><?php echo $paidAmount . ' ' . $paidCurrency; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Payment Status:</th>
                            <td><?php echo $paymentStatus; ?></td>
                        </tr>
                    </tbody>
                </table>

                <h4>Product Information</h4>
                <?php
                echo "
                    <table class='table'>
                        <thead>
                            <tr>
                                <th scope='col'>Competition</th>
                                <th scope='col'>Ticket Number</th>
                                <th scope='col'>Price</th>
                            </tr>
                        </thead>
                        <tbody>";
                // Gather data for tickets
                foreach ($_SESSION['purchased'] as $id) {


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
                            </tr>
                            ";
                    }
                }
                echo "</tbody></table>
                <h2>An order confirmation has been sent to ".$_SESSION['email']."</h2>"
                ?>
            

            <?php include("php/purchaseConfirmation.php"); } ?>

        </div>
        <a href="index.php" class="btn-link">Back to Product Page</a>
    </div>

    <!--Footer-->
    <?php include("php/footer.php"); ?>
</body>

</html>
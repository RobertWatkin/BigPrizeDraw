<?php

$subject = "Order Confirmation - The Big Prize Draw";

$comment = "
            <h4>Payment Information</h4>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Info</th>
                            <th scope='col'>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope='row'>Reference Number:</th>
                            <td>$paymentID</td>
                        </tr>
                        <tr>
                            <th scope='row'>Transaction ID:</th>
                            <td>$transactionID</td>
                        </tr>
                        <tr>
                            <th scope='row'>Paid Amount:</th>
                            <td>$paidAmount $paidCurrency</td>
                        </tr>
                        <tr>
                            <th scope='row'>Payment Status:</th>
                            <td>$paymentStatus</td>
                        </tr>
                    </tbody>
                </table>

                <h4>Product Information</h4>

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


        // HTML for navbar basket
        $comment .= "
                    <tr>
                        <th scope='row'>$ctitle</th>
                        <td>$tnum</td>
                        <td>&#8356;$cprice</td>
                    </tr>
                    ";
    }
}
$comment .= "
</tbody>
</table>
<p>Total = &#8356;$total</p>
<br>
<p><b>Please keep this email saved</b></p>";


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

if (mail($_SESSION['email'], $subject, $comment, $headers)) {
    $response = "Email successfully sent!";
} else {
    $response = "Email sending failed...";
}
?>
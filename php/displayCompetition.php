<?php


$comp = $row = mysqli_fetch_array($result);
$title = $comp['title'];
$desc = $comp['description'];
$price = $comp['pricePerTicket'];
$numTickets = $comp['numberOfTickets'];
$image = $comp['image'];
$date = $comp['drawDate'];
$isActive = $comp['isActive'];
$winnerTicketID = $comp['winnerTicketID'];
$qInput = $comp['QA'];


$questionAnswers = explode("|", $qInput);
$qerror = "";

$correct = false;
if (isset($_SESSION['correct'])){
    if ($_SESSION['correct']){
        $correct = true;
    }
}

// Handles button presses for the site
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['submit']) {
        case 'Add To Cart':
            //...
            if ($correct) {
                if (!empty($_POST["selectedTickets"])) {
                    foreach ($_POST["selectedTickets"] as $ticketID) {
                        if (!isset($_SESSION['basket'])) {
                            $_SESSION['basket'] = array();
                        }

                        if (!in_array($ticketID, $_SESSION['basket']))
                            array_push($_SESSION["basket"], $ticketID);
                            $_SESSION['correct'] = false;
                    }

                    echo "<meta http-equiv='refresh' content='0'>";
                }
            } else {
                $errorMessage = "You must answer the question correctly to enter the competition!";
            }
            break;
        case 'Submit Answer':
            //...
            if (isset($_POST['options'])){
                if ($_POST['options'] == $questionAnswers[1]){
                    $_SESSION['correct'] = true;
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $errorMessage = "You have answered incorrectly";
                }
            } else {
                $errorMessage = "Please select an answer!";
            }
            break;
    }
}
?>

<?php echo "

<h1>$title</h1>
<div class='row'>
    <div class='col-xs-12 col-md-6'>
        <img class='mb-3 ml-2 mr-2' src='$image' alt='Competition Image' style='border-radius: 7px; width: 100%;' />
        <a href='https://www.facebook.com/groups/682779282509700' class='ml-2 mr-2 p-2 text-white btn btn-primary' style='width:100%;'>Watch the Draw On Facebook!</a>
    </div>

    <div class='col-xs-12 col-md-6' padding: 50px;'>";
    if ($isActive) {
        echo "
        <h5>Countdown</h5>
        <div class='row text-center'>
            <div class='col-3'>
                <h4 id='dn'></h4>
                <p >DAYS</p>
            </div>
            <div class='col-3'>
                <h4 id='hn'></h4>
                <p >HOURS</p>
            </div>
            <div class='col-3'>
                <h4 id='mn'></h4>
                <p >MINUTES</p>
            </div>
            <div class='col-3'>
                <h4 id='sn'></h4>
                <p >SECONDS</p>
            </div>
        </div>";
    } else {
            $query = "SELECT * FROM `tbltickets` WHERE ticketID=" . $winnerTicketID;
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {

                $row = mysqli_fetch_row($result);
                $tnum = $row[2];
                echo "<h4>Competition Winner</h4>
                <p>This competition winner has been drawn and the winning ticket is :</p>
                <div class='text-center'>
                <h1>$tnum<h1>
                </div>
                <p>If this is your ticket we will get in contact with you via your email or mobile number</p>";
            } else {
                echo "
                <div class='text-center'>
                <h3>There has been an error retrieving the winning ticket</h3>
                </div>";
            }
        
    }
    echo "
        
        <hr>
        <h5 class='mt-4 mb-4'>$desc</h5>
        <h5 class='text-center'><b>£$price</b> per ticket</h5>
        <p class='mt-4'>To enter this competition select your tickets below. Your tickets will be added to your cart so you can continue to browse our other competitions</p>
        
    </div>
</div>";
if ($isActive){
echo "
<div id='question-answer'>
<h3>Question : </h3>";

// displays error message to the user
if (isset($errorMessage) && strlen($errorMessage) != 0) {
    echo "
                        <div style='border-radius: 5px; color: #ffffff; background-color: #f05050;'>
                            <i class='fa fa-ban' style='float: right; margin: 6px;'></i>
                            <p style='padding: 3px;'>$errorMessage</p>
                        </div>
                        ";
}
if ($correct) {
    echo "
                        <div style='border-radius: 5px; color: #ffffff; background-color: #008000;'>
                            <p style='padding: 3px; margin: 5px;'>You have answered correctly. Please select your tickets</p>
                        </div>
                        ";
}

echo "
<form method='post'>
    <h4>$questionAnswers[0]</h4>
    <div class='btn-group btn-group-toggle mb-2' data-toggle='buttons'>
        <label class='btn btn-success'>
            <input type='radio' name='options' id='option1' value='$questionAnswers[1]' autocomplete='off'>$questionAnswers[1]
        </label>
        <label class='btn btn-success'>
            <input type='radio' name='options' id='option2' value='$questionAnswers[2]' autocomplete='off'>$questionAnswers[2]
        </label>
        <label class='btn btn-success'>
            <input type='radio' name='options' id='option3' value='$questionAnswers[3]' autocomplete='off'>$questionAnswers[3]
        </label>
    </div>
    <br />
    <input class='btn btn-success' name='submit' type='submit' value='Submit Answer'>
</form>
</div>
<p>(You must answer the question correctly to enter the competition)</p>
<h2>Select Your Tickets</h2>
";

$query = "SELECT * FROM `tbltickets` WHERE competitionID=" . $_GET['comp'];
$result = mysqli_query($conn, $query);

echo "
<hr>
<form method='post'>
<div class='' data-toggle='buttons' style='display: flex; flex-wrap: wrap; justify-content: flex-start; padding: 10px;'>
";
while ($row = mysqli_fetch_array($result)) {
    if ($row['available'] < date('Y-m-d H:i:s') && $row['purchased'] == 0) {
        echo " 
        <label class='btn btn-success' style='margin: 3px; width: 50px; height: 50px;'>
            <input type='checkbox' name='selectedTickets[]' value='" . $row['ticketID'] . "' style='display:none; padding: auto;'><b>" . $row['ticketNumber'] . "</b>
        </label>";
    } else {
        echo "
        <label class='btn btn-info' style='opacity: 0.8; margin: 3px; width: 50px; height: 50px;' disabled>
            <input type='checkbox' name='invalid[]' value='" . $row['ticketID'] . "' style='display:none; padding: auto;' disabled><b>" . $row['ticketNumber'] . "</b>
        </label>";
    }
}
echo "</div>
<input id='submitButton' name='submit' class='btn btn-success center' type='submit' name='submit' value='Add To Cart' />
</form>";
}


?>
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $date; ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);



        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            var days = 0;
            var hours = 0;
            var minutes = 0;
            var seconds = 0;
        }

        // Display the countdowm
        document.getElementById("dn").innerHTML = days;
        document.getElementById("hn").innerHTML = hours;
        document.getElementById("mn").innerHTML = minutes;
        document.getElementById("sn").innerHTML = seconds;


    }, 1000);
</script>
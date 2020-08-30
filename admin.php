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
$id = $_SESSION["userID"];

$query = "SELECT * FROM `tblusers` WHERE userID='$id' and isAdmin=1";
$result = mysqli_query($conn, $query);

// redirect if there is no competition
if (mysqli_num_rows($result) < 1) {
    header("Location: index.php");
}

// Button press for create competition
if (array_key_exists('createCompetition', $_POST)) {
    createCompetition();
}
function createCompetition()
{
    header("Location: create-competition.php");
}

// Button press for select competition
if (array_key_exists('select', $_POST)) {
    selectCompetition();
}
function selectCompetition()
{
    header("location: edit-competition.php?comp=" . $_POST['select']);
    exit;
}

// Button press for sending individual mail
if (array_key_exists('sendMailIndividual', $_POST)) {
    sendMailIndividual();
}
function sendMailIndividual()
{
    header("location: contact-customer.php?id=" . $_POST['sendMailIndividual']);
    exit;
}

// Button press to send mail to all
if (array_key_exists('sendMailAll', $_POST)) {
    sendMailAll();
}
function sendMailAll()
{
    header("location: contact-customer.php");
    exit;
}

// Display for competitions
include("php/dynamic-table.php");

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
    <div class="container mt-4 mb-4" style="border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;">
        <!-- Content here -->
        <h1>Admin Page</h1>


        <!-- =================== Create New Competition ======================= -->

        <h4>Create Competitions</h4>
        <form method='post'>

            <button class='btn btn-success btn-lg btn-block mb-5 mt-4' type='submit' name='createCompetition' value='createComp'>Create a New Competition</button>

        </form>

        <hr />
        <!-- =================== Edit Competitions ======================= -->
        <h4>Select a Competition to Edit</h4>

        <?php

        echo $dyn_table;

        ?>

        <hr />
        <!-- =================== View Customers ======================= -->

        <h1 class="mt-4">View Members</h1>
        <form method='post'>
            <button class='btn btn-secondary btn-lg btn-block' type='submit' name='sendMailAll' value='all'>Send Mail to All</button>
        </form>
        <?php
        $sql = "SELECT * FROM tblusers"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table'>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Contact</th>
                    </tr>
            ";

            while ($row = mysqli_fetch_array($result)) {   //Creates a loop to loop through results
                echo "<tr><td>" . $row['userID'] .
                    "</td><td>" . $row['firstName'] .
                    "</td><td>" . $row['surname'] .
                    "</td><td>" . $row['email'] .
                    "</td><td>" . $row['phoneNumber'] .
                    "</td><td><form method='post'><button class='btn btn-secondary btn-lg btn-block' type='submit' name='sendMailIndividual' value='" . $row['userID'] . "'>Send Mail</button></form></td>";
            }

            echo "</table>"; //Close the table in HTML
        } else {
            echo "<h3>There are no users to display!</h3>";
        }
        ?>

    </div>


    <!--Footer-->
    <?php include("php/footer.php"); ?>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['submit'] == "Save") {
        // Setup relevent variables from forms
        $errorMessage = "";

        $firstName = $_POST['Firstname'];
        $surname = $_POST['Surname'];
        $email = $_POST['Email'];
        $phone = $_POST['Number'];




        // Setup sql code to find if there are already users with the given email
        $sql = "SELECT * FROM `tblusers` WHERE email='$email'";
        $results = mysqli_query($conn, $sql);

        $ur = mysqli_fetch_array($results);

        // If there are accounts with the given email
        if (mysqli_num_rows($results) > 0 && !($ur['userID'] == $_SESSION['userID'])) {
            // Set relevant error message
            $errorMessage = "Email taken! Try Again";
        } else {
            // Set member account type
            $isAdmin = 0;

            // Prepare sql code to create account
            $q = "UPDATE `tblusers` SET firstName='$firstName', surname='$surname', email='$email', phoneNumber='$phone' WHERE userID=" . $_SESSION['userID'];
            $r = mysqli_query($conn, $q);

            header("location: member-profile.php");
        }
    }
}

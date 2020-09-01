<?php
// handles button presses for the page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Setup relevent variables from forms
    $errorMessage = "";

    $firstName = $_POST['Firstname'];
    $surname = $_POST['Surname'];
    $email = $_POST['Email'];
    $phone = $_POST['Number'];
    $password = $_POST['Password'];
    $confirmPassword = $_POST['ConfirmPassword'];




    if (isset($_POST['terms'])) {
        // Check both passwords match for confirmation
        if ($password != $confirmPassword) {
            // Set relevant error message
            $errorMessage = "Passwords do not match! Try Again";
        } else {
            // Setup sql code to find if there are already users with the given email
            $sql = "SELECT * FROM `tblusers` WHERE email='$email'";
            $results = mysqli_query($conn, $sql);

            // If there are accounts with the given email
            if (mysqli_num_rows($results) > 0) {
                // Set relevant error message
                $errorMessage = "Email taken! Try Again";
            } else {
                // Encrypts the password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                // Set member account type
                $isAdmin = 0;

                // Prepare sql code to create account
                $stmt = $conn->prepare("INSERT INTO tblusers (firstName, surname, email, password, phoneNumber, isAdmin, agreedTCs) VALUES ('$firstName', '$surname', '$email', '$hashedPassword', '$phone','$isAdmin', 1)");
                $stmt->execute();   // execute the sql code

                $stmt->close();     // close the statement
                $conn->close();     // close the connection

                $subject = $_POST['Subject'];

                $subject = "Welcome To The Big Prize Draw";

                $message = "Hi $firstName,\n\nYour account has now been successfully created. Get started by having a look at the competitions we currently have available :\n\nFILLER LINK\n\nTerms and Conditions :\n\n FILLER LINK\n\nThanks,\nThe Big Prize Draw Ltd";



                mail($email, $subject, $message);

                // redirect the the member login page
                header("Location: member-login.php");
                exit();
            }
        }
    } else {
        $errorMessage = "You must agree to the Terms and Conditions to sign up";
    }
}

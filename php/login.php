<?php
    $errorMessage = "";

    // Handles button presses for the site
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        echo "$errorMessage";
        // Sets up relevent variables
        $email = $_POST['Email'];
        $password = $_POST['Password'];

        // create sql code to search for users with the given email
        $query = "SELECT * FROM `tblusers` WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        // verify password if accounts with email have been found
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                if (password_verify($password, $row["password"])){  // checks against encrypted passwords

                    // SUCCESSFUL LOGIN
                    // Set all session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["userID"] = $row["userID"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["isAdmin"] = $row["isAdmin"];
                    echo "login successful";
                    // Redirect to the home page
                    header("Location: index.php");
                }
            }   
        }
        else {
            // Display incrorrect login error message
            $errorMessage = "Email or Password is incorrect! Please try again.";
        }
    }
?>
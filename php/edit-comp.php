<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // COMPETITION DELETION
    if (isset($_POST['btnDelete'])) {
        // btnDelete
        $competitionID;
        $sql = "DELETE FROM `tblCompetitions` WHERE competitionID = $competitionID" ;
        $result = mysqli_query($conn, $sql);

        $sql = "DELETE FROM `tblTickets` WHERE competitionID = $competitionID" ;
        $result = mysqli_query($conn, $sql);

        header("Location: admin.php");
        exit();
    
    // WINNER SELECTION
    } else if (isset($_POST['btnSelectWinner'])) {

        if (!empty($_POST["selectedTicket"])){
            $ticketID = $_POST["selectedTicket"];

            $sql = "UPDATE `tblCompetitions` SET winnerTicketID=$ticketID, isActive=0 WHERE competitionID=$competitionID" ;
            $result = mysqli_query($conn, $sql);
          }
    } else {
        // Assume btnSave
        if (!empty($_FILES['file']['name'])) {
            // ==== File Upload ====
            $file = $_FILES['file'];
    
            // All file info
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];
        
            
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
    
            $allowed = array('jpg', 'jpeg', 'png');
    
            $fileDestination = "";
            $upload = 0;
            // File validation
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 2000000) {
    
                        // Actual file upload
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'competitionImages/' . $fileNameNew;
    
                        //file is uploaded here
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $upload = 1;
    
                        // ERROR MESSAGES BELOW
                    } else {
                        echo "Your image is too big! Over 2mb";
                    }
                } else {
                    echo "There has been an error uploading your file!";
                }
            } else {
                echo "<p style='background-color: #fff;'>You cannot upload files of this type! Use either Jor PNG</p>";
            }
        }
    
        // ==== Competition Entry is Created ====
    
        $title = $_POST['title'];
        $description = $_POST['description'];
    
        if (!empty($_POST['drawDate'])){
            $drawDate = $_POST['drawDate'];
        }
        else{
            $drawDate = $date;
        }
    
        // ==== Prepare sql code to create competition ====
        $isActive = 1;
        $sql = ("UPDATE tblcompetitions SET title='$title', description='$description', drawDate='$drawDate' WHERE competitionID='$competitionID'");
    
        if (mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);
        }
    
        $conn->close();     // close the connection
    
        header("Location: admin.php");
        exit();
    }
}

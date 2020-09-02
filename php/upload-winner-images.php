<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ==== File Upload ====
    $file = $_FILES['file'];

    // All file info
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Getting file extention
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
                $fileDestination = 'winnerImages/' . $fileNameNew;

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
        echo "You cannot upload files of this type! Use either JPG or PNG";
    }

    if ($upload == 1){
        $stmt = $conn->prepare("INSERT INTO winnerImages (imagePath) VALUES ('$fileDestination')");
        $stmt->execute();   // execute the sql code

        $stmt->close();     // close the statement
        $conn->close();     // close the connection
    }
}

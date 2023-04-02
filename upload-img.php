<?php
require_once 'mysql-connect.php';
$msg = "";

function uploadimg() {
    global $connect;

    // If upload button is clicked ...
    if (isset($_POST['upload'])) {
        // Get the filename and temporary name of the uploaded file
        $filename = mysqli_real_escape_string($connect, $_FILES["uploadfile"]["name"]);
        $tempname = mysqli_real_escape_string($connect,$_FILES["uploadfile"]["tmp_name"]);

        // Validate the file type to ensure only image files are uploaded
        $fileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" ) {
            echo "<h3> Only JPG, JPEG, PNG & GIF files are allowed!</h3>";
            return;
        }

        // Generate a unique filename to prevent overwriting existing files
        $newFilename = uniqid('', true) . '.' . $fileType;
        $folder = "./upimage/" . $newFilename;

        // Get the file size to ensure it's not too large
        $fileSize = $_FILES["uploadfile"]["size"];
        if($fileSize > 500000) {
            echo "<h3> Your file is too large!</h3>";
            return;
        }

        // Insert the filename into the database
        $stmt = $connect->prepare("INSERT INTO image (filename) VALUES (?)");
        $stmt->bind_param("s", $newFilename);
        $stmt->execute();

        // Now let's move the uploaded image into the folder: upimage
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3> Image uploaded successfully!</h3>";
        } else {
            echo "<h3> Failed to upload image!</h3>";
        }
    }
}
uploadimg();
?>

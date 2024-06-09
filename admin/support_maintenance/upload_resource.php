<?php
include '../../source/mysqlcon.php';

$link = $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resourceFile = $_FILES['resourceFile'];
    $courseId = $_POST['courseId'];

    // Check if a file has been uploaded
    if (isset($resourceFile) && $resourceFile['error'] === UPLOAD_ERR_OK) {
        $fileName = $resourceFile['name'];
        $fileTmpName = $resourceFile['tmp_name'];
        $fileSize = $resourceFile['size'];

        // Additional code to validate and process the uploaded file

        // Move the uploaded file to the destination directory
        $destination = '../uploads/' . $fileName;
        if (move_uploaded_file($fileTmpName, $destination)) {
            // Check if the CourseID exists in the courses table
            $checkQuery = "SELECT CourseID FROM courses WHERE CourseID = ?";
            $checkStmt = $link->prepare($checkQuery);
            $checkStmt->execute([$courseId]);
            $rowCount = $checkStmt->rowCount();

            if ($rowCount > 0) {
                // Save the resource information into the database
                $insertQuery = "INSERT INTO CourseResources (ResourceName, CourseID, FilePath, FileSize) VALUES (?, ?, ?, ?)";
                $insertStmt = $link->prepare($insertQuery);
                $insertStmt->execute([$fileName, $courseId, $destination, $fileSize]);

                // Redirect the user to the main resource page
                header('Location: support_maintenance.php');
                exit();
            } else {
                echo 'Invalid CourseID. Please select a valid CourseID.';
            }
        } else {
            echo 'An error occurred while uploading the file.';
        }
    } else {
        echo 'Please select a file to upload.';
    }
}
?>
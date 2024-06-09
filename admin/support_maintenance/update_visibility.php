<?php
include '../../source/mysqlcon.php';

$link = $conn; // Utilize the variable $conn from mysqlcon.php

// Check if the form is submitted for updating visibility
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['courseId']) && isset($_POST['visibility'])) {
        $courseId = $_POST['courseId'];
        $visibility = $_POST['visibility'];

        // Perform the update in the database
        $query = "UPDATE Courses SET Visibility = :visibility WHERE CourseID = :courseId";
        $stmt = $link->prepare($query);
        $stmt->bindValue(':visibility', $visibility);
        $stmt->bindValue(':courseId', $courseId);
        $stmt->execute();

        // Retrieve the course title
        $query = "SELECT Title FROM Courses WHERE CourseID = :courseId";
        $stmt = $link->prepare($query);
        $stmt->bindValue(':courseId', $courseId);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        $courseTitle = $course['Title'];

        // Set the status message based on the update result
        if ($stmt->rowCount() > 0) {
            $statusMessage = "Visibility for Course '$courseTitle' (ID: $courseId) updated successfully!";
        } else {
            $statusMessage = "Failed to update visibility for Course ID: $courseId";
        }

        // Start the session to store the status message
        session_start();

        // Set the status message in the session
        $_SESSION['statusMessage'] = $statusMessage;

        // Redirect back to the dashboard page
        header('Location: ../support_maintenance/support_maintenance.php');
        exit();
    }
}
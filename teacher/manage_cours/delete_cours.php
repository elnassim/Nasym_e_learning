<?php
// Include database connection
include_once("../../source/mysqlcon.php");

// Check if the delete_course button is clicked and a course ID is provided
if (isset($_POST['delete_course']) && isset($_POST['course_id'])) {
    // Sanitize the input
    $courseIDToDelete = filter_input(INPUT_POST, 'course_id', FILTER_SANITIZE_NUMBER_INT);

    // Delete related records from Enrollments table
    $query_delete_enrollments = "DELETE FROM Enrollments WHERE CourseID = :courseID";
    $stmt_delete_enrollments = $conn->prepare($query_delete_enrollments);
    $stmt_delete_enrollments->bindParam(':courseID', $courseIDToDelete, PDO::PARAM_INT);

    // Execute deletion query for related records in Enrollments table
    $stmt_delete_enrollments->execute();

    // Delete related records from CourseParts table
    $query_delete_parts = "DELETE FROM CourseParts WHERE CourseID = :courseID";
    $stmt_delete_parts = $conn->prepare($query_delete_parts);
    $stmt_delete_parts->bindParam(':courseID', $courseIDToDelete, PDO::PARAM_INT);

    // Execute deletion query for related records in CourseParts table
    $stmt_delete_parts->execute();

    // Prepare and execute deletion query for the course
    $query_delete_course = "DELETE FROM Courses WHERE CourseID = :courseID";
    $stmt_delete_course = $conn->prepare($query_delete_course);
    $stmt_delete_course->bindParam(':courseID', $courseIDToDelete, PDO::PARAM_INT);
    
    // Check if deletion is successful
    if ($stmt_delete_course->execute()) {
        // Redirect back to the view_cours.php page after successful deletion
        header("Location:cours.php");
        exit();
    } else {
        // If deletion fails, display an error message
        echo "Error deleting course. Please try again.";
    }
} else {
    // If course ID is not provided or delete_course button is not clicked, redirect back to view_cours.php
    header("Location:cours.php");
    exit();
}
?>

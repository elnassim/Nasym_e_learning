<?php
// Delete a course

if (isset($_GET['id'])) {
    // Get the course ID to delete from the GET request
    $courseID = $_GET['id'];

    // Include the database connection file
    include '../../source/mysqlcon.php';

    // Check if the confirmation form has been submitted
    if (isset($_POST['confirmation']) && $_POST['confirmation'] === 'yes') {
        // Delete the associated student records
        $deleteStudentsSql = "DELETE FROM students WHERE CourseID = :courseID";
        $deleteStudentsStmt = $conn->prepare($deleteStudentsSql);
        $deleteStudentsStmt->bindParam(':courseID', $courseID);
        $deleteStudentsStmt->execute();

        // Delete the course from the "Courses" table
        $deleteCourseSql = "DELETE FROM Courses WHERE CourseID = :courseID";
        $deleteCourseStmt = $conn->prepare($deleteCourseSql);
        $deleteCourseStmt->bindParam(':courseID', $courseID);
        $deleteCourseStmt->execute();

        // Redirect to the course management page with a confirmation message
        header("Location: course_management.php?message=The course has been successfully deleted.");
        exit();
    }

    // Retrieve the course information from the database
    $getCourseSql = "SELECT * FROM Courses WHERE CourseID = :courseID";
    $getCourseStmt = $conn->prepare($getCourseSql);
    $getCourseStmt->bindParam(':courseID', $courseID);
    $getCourseStmt->execute();
    $courseData = $getCourseStmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!-- Course deletion confirmation form -->
<form action="delete_course.php?id=<?php echo $courseID; ?>" method="POST" class="slide-up">
    <h3>Confirm Course Deletion</h3>
    <p>Are you sure you want to delete the course "<?php echo $courseData['Title']; ?>"?</p>
    <input type="hidden" name="confirmation" value="yes">
    <input type="submit" value="Yes">
    <a href="course_management.php">Cancel</a>
</form>
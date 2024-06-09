<?php
// Include the database connection file
require_once('../source/mysqlcon.php');

// Get the logged-in student's ID (You may have to modify this based on your session implementation)
$studentID = isset($_SESSION["StudentID"]) ? $_SESSION["StudentID"] : null;

if ($studentID) {
    // Fetch enrolled courses for the logged-in student
    $query = "SELECT Courses.CourseID, Courses.Title, Courses.Description, Professors.FirstName, Professors.LastName 
              FROM Enrollments 
              INNER JOIN Courses ON Enrollments.id = Courses.CourseID 
              INNER JOIN Professors ON Courses.ProfessorID = Professors.ProfessorID 
              WHERE Enrollments.StudentID = :studentID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->execute();

    // Check if there are any enrolled courses
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Course details
            $title = $row['Title'];
            $description = $row['Description'];
            $professorName = $row['FirstName'] . ' ' . $row['LastName'];

            // Display enrolled courses
            echo '<div class="course-card">';
            echo '<h3>' . $title . '</h3>';
            echo '<p>' . $description . '</p>';
            echo '<p>Instructor: ' . $professorName . '</p>';
            echo '</div>';
        }
    } else {
        // Display message if no enrolled courses found
        echo 'You are not enrolled in any courses.';
    }
} else {
    // Display message if student is not logged in
    echo 'Please log in to view your course progress.';
}
?>

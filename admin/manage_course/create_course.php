<?php
include '../../source/mysqlcon.php';

if (isset($_POST['create'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $professorID = $_POST['professor'];
    $subjectID = $_POST['subject'];

    // Insert new course into the database
    $sql = "INSERT INTO Courses (Title, Description, Keywords, ProfessorID, SubjectID) VALUES (:title, :description, :keywords, :professorID, :subjectID)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':keywords', $keywords);
    $stmt->bindParam(':professorID', $professorID);
    $stmt->bindParam(':subjectID', $subjectID);
    
    try {
        if ($stmt->execute()) {
            // Redirect to confirmation page
            header("Location: course_management.php");
            
        } else {
            echo "Error executing the SQL statement.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>

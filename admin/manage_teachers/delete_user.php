<?php
include '../../source/mysqlcon.php';

// Retrieve professor ID from the query string
$professorId = $_GET['id'];

try {
    // Begin transaction
    $conn->beginTransaction();

    // Delete professor and related data
    deleteProfessorData($conn, $professorId);

    // Commit transaction
    $conn->commit();

    echo "Professor and related data deleted successfully.";
} catch (PDOException $e) {
    // Rollback transaction on error
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}

// Function to delete professor and related data
function deleteProfessorData($conn, $professorId)
{
    deleteEnrollments($conn, $professorId);
    deleteAnswers($conn, $professorId);
    deleteRequests($conn, $professorId);
    deleteQuestions($conn, $professorId);
    deleteDiscussionPosts($conn, $professorId);
    deleteCourseResources($conn, $professorId);
    deleteCourseParts($conn, $professorId);
    deleteModuleResources($conn, $professorId);
    deleteCourseModules($conn, $professorId);
    deleteAnnouncements($conn, $professorId);
    deleteCourses($conn, $professorId);
    deleteProfessor($conn, $professorId);
}

// Delete enrollments
function deleteEnrollments($conn, $professorId)
{
    $query = "DELETE FROM enrollments WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete answers
function deleteAnswers($conn, $professorId)
{
    $query = "DELETE FROM answers WHERE QuestionID IN (SELECT QuestionID FROM questions WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId))";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete deletion requests
function deleteRequests($conn, $professorId)
{
    $query = "DELETE FROM profrequests WHERE ProfessorID = :professorId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete questions
function deleteQuestions($conn, $professorId)
{
    $query = "DELETE FROM questions WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete discussion posts
function deleteDiscussionPosts($conn, $professorId)
{
    $query = "DELETE FROM discussionposts WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete course resources
function deleteCourseResources($conn, $professorId)
{
    $query = "DELETE FROM courseresources WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete course parts
function deleteCourseParts($conn, $professorId)
{
    $query = "DELETE FROM courseparts WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete module resources
function deleteModuleResources($conn, $professorId)
{
    $query = "DELETE FROM moduleresources WHERE ModuleID IN (SELECT ModuleID FROM coursemodules WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId))";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete course modules
function deleteCourseModules($conn, $professorId)
{
    $query = "DELETE FROM coursemodules WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete announcements
function deleteAnnouncements($conn, $professorId)
{
    $query = "DELETE FROM announcements WHERE CourseID IN (SELECT CourseID FROM courses WHERE ProfessorID = :professorId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete courses
function deleteCourses($conn, $professorId)
{
    $query = "DELETE FROM courses WHERE ProfessorID = :professorId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}

// Delete professor
function deleteProfessor($conn, $professorId)
{
    $query = "DELETE FROM professors WHERE ProfessorID = :professorId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorId', $professorId);
    $stmt->execute();
}
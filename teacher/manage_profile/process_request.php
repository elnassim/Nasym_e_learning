<?php
// Start session if not already started
session_start();

// Include database connection file
include_once("../../source/mysqlcon.php");

// Check if the user is logged in
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to login page or display an error message
    header("Location: ../authentication/login.php");
    exit();
}


// Check if the Delete Account button is clicked
if (isset($_POST['delete_account'])) {
    // Get ProfessorID from session
    $professorID = $_SESSION['ProfessorID'];
    
    // Insert request into ProfRequest table
    $query = "INSERT INTO profrequests (ProfessorID, RequestStatus) VALUES (:professorID, 'Pending')";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':professorID', $professorID, PDO::PARAM_INT);
    $stmt->execute();
    
    // Close connection
    $conn = null;
    // Redirect to a confirmation page or display a message
    header("Location: profile.php");
    exit();
}
?>
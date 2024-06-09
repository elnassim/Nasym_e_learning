<?php
include '../../source/mysqlcon.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $lastName = $_POST['LastName'];
    $firstName = $_POST['FirstName'];
    $email = $_POST['Email'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Check if the email already exists
    $emailExists = false;
    $checkSql = "SELECT COUNT(*) FROM professors WHERE Email = :Email";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':Email', $email);
    $checkStmt->execute();
    if ($checkStmt->fetchColumn() > 0) {
        $emailExists = true;
    }

    if ($emailExists) {
        echo "Email already exists.";
    } else {
        // Validate password (example: minimum 8 characters)
        if (strlen($password) < 8) {
            echo "Password must be at least 8 characters long.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new professor into the database
            $sql = "INSERT INTO professors (LastName, FirstName, Email, Username, Password) VALUES (:LastName, :FirstName, :Email, :Username, :Password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':LastName', $lastName);
            $stmt->bindParam(':FirstName', $firstName);
            $stmt->bindParam(':Email', $email);
            $stmt->bindParam(':Username', $username);
            $stmt->bindParam(':Password', $hashedPassword);

            if ($stmt->execute()) {
                // Redirect back to the user management page
                header("Location: user_management.php");
                exit();
            } else {
                // Handle the case where the insertion fails
                echo "Error creating the user.";
            }
        }
    }
}
?>
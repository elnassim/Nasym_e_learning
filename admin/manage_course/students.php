<?php
include '../../source/mysqlcon.php';

// Retrieve administrator information
$query = "SELECT FirstName, LastName, ProfilePicture FROM Professors ";
$result = $conn->query($query);

if ($result && $result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $profilePicture = $row['ProfilePicture'];
} else {
    // Handle case where no administrator is found
    $firstName = 'Name';
    $lastName = 'Unknown';
    $profilePicture = 'default.jpg'; // Remplacez "default.jpg" par le nom de votre image de profil par défaut
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.">
    <title>Teacher Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/user_management.css">
</head>
<body>
  
<div class="container">
        <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><img class="logo-image" src="../uploads/LGG-removebg-preview.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../admin/dashboard/dashboard.php">Home</a></li>
           
            <li><a href="../../contacts/aboutus.php">About us</a></li>
            <br>
            <br>
        </ul>
        <hr>
</br>
        <div class="sidebar-profile">
        <ul class="sidebar-menu">
        <li><div class="profile-header">
                <h3 align="center">Admin</h3>
            </div></li>
           
            <div class="profile-menu">
                
                
</br>
                    <hr>
                    <ul class="sidebar-menu">
                        <br>
                        
                        <li><a href="../../index.php"><i class='bx bx-log-out'></i>log out</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .enrolled-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .enrolled-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .enrolled-table th,
        .enrolled-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .enrolled-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #333;
        }

        .enrolled-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .no-students {
            font-style: italic;
            color: #777;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        
        // Check if course ID is provided in the URL
        if (isset($_GET['course_id'])) {
            // Get the course ID from the URL
            $courseID = $_GET['course_id'];
    
            // Retrieve enrolled students for the specified course from the database
            $getEnrolledStudentsSql = "SELECT Students.* FROM Students 
                                   INNER JOIN Enrollments ON Students.StudentID = Enrollments.StudentID
                                   WHERE Enrollments.CourseID = :courseID";
            $getEnrolledStudentsStmt = $conn->prepare($getEnrolledStudentsSql);
            $getEnrolledStudentsStmt->bindParam(':courseID', $courseID);
            $getEnrolledStudentsStmt->execute();
            $enrolledStudents = $getEnrolledStudentsStmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($getEnrolledStudentsStmt->rowCount() > 0) {
                echo "<h2 class='enrolled-title'>Enrolled Students</h2>";
                echo "<table class='enrolled-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Student ID</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Email</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
    
                foreach ($enrolledStudents as $student) {
                    echo "<tr>";
                    echo "<td>" . $student['StudentID'] . "</td>";
                    echo "<td>" . $student['FirstName'] . "</td>";
                    echo "<td>" . $student['LastName'] . "</td>";
                    echo "<td>" . $student['Email'] . "</td>";
                    echo "</tr>";
                }
    
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='no-students'>No students are enrolled in this course.</p>";
            }
        } else {
            echo "<p class='no-students'>Course ID is missing.</p>";
        }
    
        $conn = null;
        ?>
    </div>
</body>
</html>

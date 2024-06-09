<?php 
// Include header
include_once("../includes/header.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASYM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href=""></head>
<body>
<div class="container">
        <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><img class="logo-image" src="../../image/LGG.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../student/dashboard/st-dashboard.php">Home</a></li>
           
            <li><a href="../../contacts/aboutus.php">About us</a></li>
            <br>
            <br>
        </ul>
        <hr>
</br>
        <div class="sidebar-profile">
        <ul class="sidebar-menu">
        <li><div class="profile-header">
                <h3 align="center"><?php echo $firstName . ' ' . $lastName; ?></h3>
            </div></li>
           
            <div class="profile-menu">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <ul class="sidebar-menu"> 
                <li><a href="../manage_profile/profile.php">profile</a></li>
                </ul>
</br>
                  
                </form>
            </div>
        </div>
    </div>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    
    .save-button {
    background-color: #0077b6;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
}

.save-button:hover {
    background-color: #00557a;
}
.sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
    .course-progress-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        margin-left: 500px

    }
    #id1{
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
    h1 {
        text-align: center;
        margin-top: 30px;
        color: #333;
        margin-right:300px;
    }

    form {
        text-align: center;
        margin-bottom: 20px;
        margin-right: 200px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"] {
        padding: 10px;
        width: 300px;
        border-radius: 25px;
        border: 1px solid #ddd;
        margin-right: 10px;
        font-size: 16px;
        transition: box-shadow 0.3s ease;
    }

    input[type="text"]:focus {
        outline: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    button[type="submit"] {
        padding: 10px 20px;
        background-color: #005388;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 25px;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    .course-card {
        border: 1px solid #ddd;
        background-color: #fff;
        padding: 20px;
        margin-top: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-left: 000px; /* Ajuster la marge gauche */
        width: 300px;
    }

    .course-card img {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .course-card h3 {
        margin: 10px 0;
        color: #333;
        font-size: 1.2em;
    }

    .course-card p {
        color: #666;
        margin: 10px 0;
        font-size: 1em;
    }

    form.view-course-form {
        margin-top: 10px;
        text-align: center;
    }
    button[type="submit"] {
        padding: 10px 20px;
        background-color: #005388;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 25px;
        transition: background-color 0.3s ease;
        margin-top: 5px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
    </style>
</head>
<body>
<div class="user-list-containerer">
<div class="course-progress-container">
    <h1>Course Progress</h1>

    <!-- Search form -->
    <form method="post">
        <label for="search"></label>
        <input type="text" id="search" name="search" placeholder="Search by course title or description">
        <button type="submit">Search</button>
    </form>

    <?php
    // Include the database connection file
    require_once('../../source/mysqlcon.php');
    // Check if the user is logged in
    
    
    

    // Get the student's ID from the session
    $studentID = $_SESSION["StudentID"];

    // Fetch enrolled courses for the student
    // Fetch enrolled courses for the student
$query = "SELECT Courses.CourseID, Courses.Title, Courses.Description, Courses.Keywords, Courses.CourseImage, Professors.FirstName, Professors.LastName
FROM Courses 
INNER JOIN Enrollments ON Courses.CourseID = Enrollments.CourseID 
INNER JOIN Professors ON Courses.ProfessorID = Professors.ProfessorID 
WHERE Enrollments.StudentID = :studentID";

// Check if search term is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
$search = $_POST['search'];
// Append search condition to the query
$query .= " AND (Courses.Title LIKE :search 
           OR Courses.Description LIKE :search 
           OR Courses.Keywords LIKE :search 
           OR Professors.FirstName LIKE :search 
           OR Professors.LastName LIKE :search)";
}

$stmt = $conn->prepare($query);
$stmt->bindParam(":studentID", $studentID, PDO::PARAM_INT);

// Bind search parameter if provided
if (isset($search)) {
$searchTerm = "%{$search}%";
$stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
}
    $stmt->execute();

    // Display enrolled courses
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Course details
            $title = $row['Title'];
            $description = $row['Description'];
            $professorName = $row['FirstName'] . ' ' . $row['LastName'];
            $courseImage = $row['CourseImage'];
            $courseID = $row['CourseID']; // Added course ID

            // Display the enrolled course
            echo '<div class="course-card">';
            echo '<img src="../../teacher/manage_cours/' . $courseImage . '" alt="' . $title . '">';
            echo '<h3>' . $title . '</h3>';
            echo '<p>' . $description . '</p>';
            echo '<p>Instructor: ' . $professorName . '</p>';
            // Add "View Course" button
            echo '<form class="view-course-form" action="view_course_details.php" method="get">';
            echo '<input type="hidden" name="id" value="' . $courseID . '">';
            echo '<button type="submit">View Course</button>';
            echo '</form>';
            echo '</div>';  
        }
    } else {
        echo 'You are not enrolled in any courses.';
    }
    ?>
     <form action="../manage_student/question.php" method="get">
            <button type="submit">Poser une question</button>
        </form>
</div>
</div>
</body>
</html>


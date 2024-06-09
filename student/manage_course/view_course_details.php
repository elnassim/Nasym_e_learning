<?php

include '../../source/mysqlcon.php';

// Retrieve administrator information
$query = "SELECT FirstName, LastName, ProfilePicture FROM Students ";
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

?><?php 
// Include header

?>
<?php
// Include database connection
include_once("../../source/mysqlcon.php");

// Check if a course ID is provided
if (!isset($_GET['id'])) {
    echo "Course ID not provided.";
    exit();
}

$courseID = $_GET['id'];

// Fetch course details
$query_course = "SELECT * FROM Courses WHERE CourseID = :courseID";
$stmt_course = $conn->prepare($query_course);
$stmt_course->bindParam(':courseID', $courseID, PDO::PARAM_INT);
$stmt_course->execute();
$course = $stmt_course->fetch(PDO::FETCH_ASSOC);

// Fetch course parts
$query_parts = "SELECT * FROM CourseParts WHERE CourseID = :courseID";
$stmt_parts = $conn->prepare($query_parts);
$stmt_parts->bindParam(':courseID', $courseID, PDO::PARAM_INT);
$stmt_parts->execute();
$parts = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);

// Fetch course resources
$query_resources = "SELECT * FROM CourseResources WHERE CourseID = :courseID";
$stmt_resources = $conn->prepare($query_resources);
$stmt_resources->bindParam(':courseID', $courseID, PDO::PARAM_INT);
$stmt_resources->execute();
$resources = $stmt_resources->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="../style/user_management.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 25px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: slide-up 0.5s ease;
            position: relative;
            margin-left: 300px
        }

        @keyframes slide-up {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2ea2cd;
        }

        h3 {
            color: #2ea2cd;
            margin-top: 20px;
        }

        img.course-image {
            max-width: 300px;
            height: auto;
            display: block;
            position: absolute;
            right: 80px;
            bottom: 300px; /* Ajoutez cette ligne pour déplacer l'image vers le bas */
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        img.course-image:hover {
            transform: scale(1.05);
        }

        embed {
            width: 100%;
            height: 400px;
        }

        .part,
        .resource {
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .part:hover,
        .resource:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        a {
            color: #2ea2cd;
            text-decoration: none;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #1d7da2;
        }

        p {
            margin: 5px 0;
        }
        .course-info {
            color: #19394d;
            position: relative;
        }
        .course-title {
            border: 2px solid #2ea2cd;
            border-radius: 8px;
            padding: 8px;
            margin: 10px ;
            animation: border-flicker 1s ease infinite alternate;
        }
        .course-title {
            border: 2px solid #2ea2cd;
            border-radius: 8px;
            padding: 8px;
            margin: 10px ;
            animation: border-flicker 1s ease infinite alternate;
        }
        .sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
        @keyframes border-flicker {
            from {
                box-shadow:   10px #2ea2cd;
            }
            to {
                box-shadow:   20px #2ea2cd;
            }
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            background-color: #2ea2cd;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: background-color .3s, transform .3s;
        }
   

        .button:hover {
            background-color: #1d7da2;
            transform: translateY(-2px);
        }

        .button:active {
            transform: translateY(1px);
        }
        .aa{
            color:white;
        }
        
    </style>
</head>
<body id="body">

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
                <h3 class="aa" align="center"><?php echo $firstName . ' ' . $lastName; ?></h3>
            </div></li>
           
            <div class="profile-menu">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <ul class="sidebar-menu"> 
                <li><a href="../manage_profile/profile.php">profile</a></li>
                </ul>
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
    
    <div class="content">
        <h2 class="course-title" >Course Details</h2>
        </br></br></br></br></br></br>
        <img class="course-image" src="../../image/cours.jpeg" alt="Course Image">
    </br></br></br></br></br>
        <div class="course-info">
            <h3><?php echo $course['Title']; ?></h3>
            <p class="course-info">Description:    <?php echo $course['Description']; ?></p>
            <p class="course-info">Keywords:    <?php echo $course['Keywords']; ?></p>
            <p class="course-info">Prerequisites:    <?php echo $course['Prerequisites']; ?></p>
            <p class="course-info">Created At:    <?php echo $course['CreatedAt']; ?></p>
            <p class="course-info">Updated At:    <?php echo $course['UpdatedAt']; ?></p>
        </div>

        <div class="course-parts">
            <h3>Course Parts</h3>
            <?php foreach ($parts as $part): ?>
                <div class="part">
                    <h4><?php echo $part['PartName']; ?></h4>
                    <p>Description: <?php echo $part['Description']; ?></p>
                    <?php 
                        if (!empty($part['FilePath'])) {
                            $fileExtension = pathinfo($part['FilePath'], PATHINFO_EXTENSION);
                            $fullFilePath = '../../teacher/manage_cours/' . $part['FilePath'];
                            
                            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo '<img src="' . $fullFilePath . '" alt="Part Image">';
                            } elseif ($fileExtension == 'pdf') {
                                echo '<embed src="' . $fullFilePath . '" type="application/pdf" width="600" height="400">';
                            }
                            echo '<a href="' . $fullFilePath . '" download>Download File</a>';
                        }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>

        
    </div>
</div>
<style>
   
</style>
</body>


</html>

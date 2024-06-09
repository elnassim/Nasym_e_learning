<?php

// Include header
include_once("../includes/header.php");



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
    <!-- Add any necessary CSS stylesheets or meta tags -->
</head>
<style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #005388;
        }

        .container {
            width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: slide-up 0.5s ease;
            position: relative;
            margin-left:350px;
        }
        .prer{
            width: 400px;
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
            color: #005388;
        }

        h3 {
            color: #005388;
            margin-top: 20px;
        }

        img.course-image {
            width: 300px;
            max-height: 190px;
            display: block;
            position: absolute;
            
            right: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-top: 100px;
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
            color: #005388;
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
        }
        .course-title {
            border: 2px solid #005388;
            border-radius: 8px;
            padding: 8px;
            margin: 10px ;
            animation: border-flicker 1s ease infinite alternate;
        }
        

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
    </style>
<body>
   
   
    <h2 class="course-title" >Course Details</h2>
    <img class="course-image" src="<?php echo $course['CourseImage']; ?>" alt="Course Image">

        <h3><?php echo $course['Title']; ?></h3>
        
        <p>Description: <?php echo $course['Description']; ?></p>
        <p>Keywords: <?php echo $course['Keywords']; ?></p>
        <div class="prer">
        <p>Prerequisites: <?php echo $course['Prerequisites']; ?></p>
        </div>
        <p>Created At: <?php echo $course['CreatedAt']; ?></p>
        <p>Updated At: <?php echo $course['UpdatedAt']; ?></p>
    
   
    <div class="course-parts">
        <h3>Course Parts</h3>
        <?php foreach ($parts as $part): ?>
            <div class="part">
                <h4><?php echo $part['PartName']; ?></h4>
                <p>Description: <?php echo $part['Description']; ?></p>
                <?php 
                    // Check if the file path is set and not empty
                    if (!empty($part['FilePath'])) {
                        $fileExtension = pathinfo($part['FilePath'], PATHINFO_EXTENSION);
                        // Check if the file is an image or PDF
                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo '<img src="' . $part['FilePath'] . '" alt="Part Image">';
                        } elseif ($fileExtension == 'pdf') {
                            echo '<embed src="' . $part['FilePath'] . '" type="application/pdf" width="600" height="400">';
                        }
                        // Provide download link for the file
                        echo '<a href="' . $part['FilePath'] . '" download>Download File</a>';
                    }
                ?>
            </div>
        <?php endforeach; ?>
   
    
</body>
</html>
<?php
// Close connection
$conn=NULL;
?>

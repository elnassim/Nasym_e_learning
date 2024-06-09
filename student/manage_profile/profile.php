<?php
// Include header
include_once("../includes/header.php");

// Include database connection file
include_once("../../source/mysqlcon.php");

// Start session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["StudentID"])) {
    header("location: ../authentication/login.php");
    exit();
}

// Fetch user's account information based on StudentID
$studentID = $_SESSION["StudentID"];
$sql_user = "SELECT * FROM Students WHERE StudentID = :studentID";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bindParam(':studentID', $studentID, PDO::PARAM_INT);
$stmt_user->execute();

// Check if user information is fetched successfully
if (!$stmt_user) {
    $error = "Error fetching user information: " . $stmt_user->errorInfo()[2];
}

$userInfo = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Fetch courses enrolled by the student
$sql_courses = "SELECT c.Title FROM Courses c INNER JOIN Enrollments e ON c.CourseID = e.CourseID WHERE e.StudentID = :studentID";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bindParam(':studentID', $studentID, PDO::PARAM_INT);
$stmt_courses->execute();

// Check if courses are fetched successfully
if (!$stmt_courses) {
    $error = "Error fetching courses: " . $stmt_courses->errorInfo()[2];
}

$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <link rel="stylesheet" type="text/CSS" href="../style/user_management.css">
</head>
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
                    <hr>
                    <ul class="sidebar-menu">
                        <br>
                        
                        <li><a href="../../index.php"><i class='bx bx-log-out'></i>log out</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <section class="register-section" id="register">
        <div class="register-container">
        <div class="register-container">
        <div class="form-container"> 
        <h2 align="center">Student Profile</h2> 
        <br/><br/>          
                    <p><strong>First Name:</strong> <?php echo $userInfo['FirstName']; ?></p>
                    <p><strong>Last Name:</strong> <?php echo $userInfo['LastName']; ?></p>
                    <p><strong>Username:</strong> <?php echo $userInfo['Username']; ?></p>
                    <p><strong>Email:</strong> <?php echo $userInfo['Email']; ?></p>
                </div>
            </div>
            <br/><br/>
            <div class="register-container">  
                <div class="form-container">         
                    <h3 align="center">Courses Enrolled</h3>
                    <br/>
                    <p>Total Courses: <?php echo count($courses); ?></p>
                    
                    <ul>
                        <?php foreach ($courses as $course): ?>
                            <li><?php echo $course['Title']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br/>
                    <div class="input-box">
                    <button type="submit" value="Register" class="ss"><a href="edit_profile.php">Edit Profile</a>

                    </div>
                </div>
            </div>
                        </div></div>
        </section>
    <?php endif; ?>
    
    <link rel="stylesheet" type="text/CSS" href="../manage_profile/profile.css">

    <?php
    $conn = null; // Close connection
    ?>
    </div>
    <style>
        .sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
    </style>
</body>
</html>

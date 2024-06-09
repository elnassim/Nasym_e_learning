<?php
// Include header
include_once("../includes/header.php");

// Include database connection file
include_once("../../source/mysqlcon.php");


// Start session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["ProfessorID"])) {
    header("location: ../authentication/login.php");
    exit();
}

// Fetch user's account information based on ProfessorID
$professorID = $_SESSION["ProfessorID"];
$sql_user = "SELECT * FROM Professors WHERE ProfessorID = :professorID";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bindParam(':professorID', $professorID, PDO::PARAM_INT);
$stmt_user->execute();

// Check if user information is fetched successfully
if (!$stmt_user) {
    $error = "Error fetching user information: " . $stmt_user->errorInfo()[2];
}

$userInfo = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Fetch courses created by the teacher
$sql_courses = "SELECT * FROM Courses WHERE ProfessorID = :professorID";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bindParam(':professorID', $professorID, PDO::PARAM_INT);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/CSS" href="../style/user_management.css"></head>
<body>
<div class="container">
        <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><img class="logo-image" src="../style//LGG-removebg-preview.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../teacher/dashboard/dashboard.php">Home</a></li>
           
            <li><a href="../../student/dashboard/aboutus.php">About us</a></li>
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
        <h2 align="center">Teacher Profile</h2> 
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
             <h3 align="center">Courses Created</h3>
             <br/>
            <p>Total Courses: <?php echo count($courses); ?></p>
            
            <ul >
                <?php foreach ($courses as $course): ?>
                    <li><?php echo $course['Title']; ?></li>
                <?php endforeach; ?>
                </ul>
                <br/>
            <div class="input-box">
 
            <button type="submit" value="Register" class="ss"><a href="edit_profile.php">Edit Profile</a></button>
            <br>
            <p>Click the button below to request account deletion.</p>
    <form action="process_request.php" method="POST">
        <input type="submit" name="delete_account" class="bb"value="Delete Account">
    </form>
        </div>
            </div>
        </div>
        <?php endif; ?>
        </div>
        </section>
        <link rel="stylesheet" type="text/CSS" href="../manage_profile/profile.css">
    </body>
</html>

<style>body{font-family: Arial, sans-serif;} 
  .bb{
   background-color: #1c7a9b;
  }
</style>
<?php
// Close connection
$conn = null;
?>

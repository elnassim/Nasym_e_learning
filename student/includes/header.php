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

?><!DOCTYPE html>
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
            <div class="logo"><img class="lgg" src="../../image/LGG.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../dashboard/st-dashboard.php">Home</a></li>
            <li><a href="user_management.php">Manage Teachers</a></li>
            <li><a href="course_management.php">Manage Courses</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="enrollment_management.php">Manage Enrollments</a></li>
            <li><a href="support_maintenance.php">Support and Maintenance</a></li>
            <li><a href="about.php">Contact</a></li>
           

        </ul>
        
        <div class="sideba">
  <div class="pro">
  <hr>
    <h3><?php echo $firstName . ' ' . $lastName; ?></h3>
    <div class="profile-photo">
    <img id="profile-image" src="../../pictures/test1.png" alt="Profile Image">
</div>
<div class="menu">
   
     <form action="../manage_profile/profile.php" method="POST" enctype="multipart/form-data">
                <label for="profile-image-upload">Change Profile Picture</label>
                <button type="submit">Save</button>
                <hr>
                
                <ul class="sidebar-menu">
                  <li><a href="about.php"><i class='bx bx-log-out'></i>log out</a></li>
                </ul>
            </form>
</div></div></div></div>
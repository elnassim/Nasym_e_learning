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
            <div class="logo"><img class="logo-image" src="../../image/LGG.png" alt="logo"></div>
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
                <h3 class="h3" align="center"><?php echo $firstName . ' ' . $lastName; ?></h3>
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
    <style>
        .h3{
            color:white;
        }
    </style>
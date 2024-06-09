<?php

include '../../source/mysqlcon.php';
session_start();
// Retrieve administrator information
$query = "SELECT FirstName, LastName, ProfilePicture FROM Admins ";
$result = $conn->query($query);

if ($result && $result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $profileImage = $row['ProfilePicture'];
} else {
    // Handle case where no administrator is found
    $firstName = 'Name';
    $lastName = 'Unknown';
    $profileImage = 'default.jpg'; // Remplacez "default.jpg" par le nom de votre image de profil par défaut
}

?><!DOCTYPE html>
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
            <h3 align="center"><?php echo $firstName . ' ' . $lastName; ?></h3>
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

<div class="content">
       
 <!-- Add your Course Overview, Course Progress, and Attendance sections here -->
 <div class="dashboard-sections">
    <div class="dashboard-section" >
       <button><a href="../manage_teachers/user_management.php">
       <img src="../../image/manage-teacher.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Manage Teachers</span>
        </div>
    </div>
    <div class="dashboard-section" >
       <button><a href="../manage_course/course_management.php">
       <img src="../../image/cours-1.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Manage Courses</span>
        </div>
    </div>
    </div>

    <div class="dashboard-sections">
    <div class="dashboard-section">
       <button><a href="../statistics/statistics.php">
       <img src="../../image/statistics.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
          <span class="text">Statistics</span>
        </div>
    </div>
    


    
    <div class="dashboard-section" >
       <button><a href="../support_maintenance/support_maintenance.php">
       <img src="../../image/support.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Support and Maintenance</span>
        </div>
    </div>
   
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<style>
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
img {
    width:600px;
    height: 250px;
}
.content {
        margin-right: 20px;
        padding: 5px;

         }
.dashboard-sections {
        margin-left: 20px;
        margin-top:  40px;
}
</style>

</body>
</html>





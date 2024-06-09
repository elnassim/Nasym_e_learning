<?php 
// Include header
include_once("../includes/header.php");
?>
<?php
include '../../source/mysqlcon.php';

// Retrieve administrator information
$query = "SELECT FirstName, LastName, ProfilePicture FROM students";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASYM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
<div class="content">
       
 <!-- Add your Course Overview, Course Progress, and Attendance sections here -->
 <div class="dashboard-sections">
    <div class="dashboard-section" >
       <button><a href="../manage_course/st-courses.php">
       <img src="../../image/st-courses.jpeg" alt="Description de l'image">
        </a></button>
        <div class="bar" align="center">
          <span class="text"  >Course Overview</span>
        </div>
    </div>
    <div class="dashboard-section" >
       <button><a href="../manage_course/st-courseprogress.php">
       <img src="../../image/st-progress.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Course Progress </span>
        </div>
    </div>
  </div>

  <div class="dashboard-sections">
    <div class="dashboard-section" >
       <button><a href="../manage_student/Announcements.php">
       <img src="../../image/st-annoucement.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Announcements</span>
        </div>
    </div>
    <div class="dashboard-section" >
       <button><a href="../manage_student/Communication.php">
       <img src="../../image/st-communication.jpeg" alt="Description de l'image">
        </a></button>
  
        <div class="bar" align="center">
    
          <span class="text"  >Communication</span>
        </div>
    </div>
  </div>
  
</div>
    <script src="script.js">document.getElementById('profile-image-upload').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('profile-image').src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        });</script>
    <!-- Your JavaScript code goes here -->
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

/* Réinitialisation des styles par défaut */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}


/* Style de la ligne horizontale */
hr {
  border-style: solid;
  border-width: 1.4px;
  /* Couleur de la bordure facultative */
}

/* Masquer le style par défaut de l'input de type fichier */
input[type="file"] {
  opacity: 0;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
  text-size-adjust: 5px;
}

.content {
  margin-left: 200px;
  flex: 1 auto;
}
img {
  width: 330px;
  heigth: 100px;
}
/* Style de base du corps */
body {
  font-family: 'Montserrat', sans-serif;
  line-height: 1.6;
  background-color: #f5f5f5;
  color: #333;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Styles de l'en-tête */
header {
  background-color: #2e5984;
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  animation: fadeIn 1s ease-out;
  color: white;
}

nav ul {
  display: flex;
  list-style-type: none;
}

nav li {
  margin-left: 2rem;
}

nav a {
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

nav a:hover {
  color: #2ea2cd;
}

.dashboard-sections {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  margin-left: 20px;
  margin-right: 20px;
  margin-top: 20px;
}

.dashboard-section,
.attendance-section {
  width: calc(50% - 10px);
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-size: cover;
  background-position: center;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.3s ease-in-out;
}
.sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
.dashboard-section:hover {
  transform: translateY(-5px);
}

.dashboard-section {
  position: relative;
}

.dashboard-section .bar {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 50px;
  background-color: #005388;
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  animation: slideIn 0.5s ease forwards;
}

.dashboard-section:hover .bar {
  opacity: 1;
}

.dashboard-section .text {
  color: white;
  font-size: 18px;
  font-family: Arial, sans-serif;
  padding: 10px;
  opacity: 0;
  animation: slideIn 0.5s ease forwards;
}

.dashboard-section:hover .text {
  opacity: 1;
}

/* Animation keyframes */
@keyframes slideIn {
  from {
    transform: translateY(50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* Réglez le délai d'animation pour chaque barre */
.course-overview-section .bar,
.course-overview-section .text {
  animation-delay: 0.2s;
}

.course-progress-section .bar,
.course-progress-section .text {
  animation-delay: 0.4s;
}

.announcements-section .bar,
.announcements-section .text {
  animation-delay: 0.6s;
}

.communication-section .bar,
.communication-section .text {
  animation-delay: 0.8s;
}

/* Animation de l'en-tête */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>

</body>
</html>

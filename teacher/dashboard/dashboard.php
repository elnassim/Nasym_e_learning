<?php
session_start();
// Include header
include_once("../includes/header.php");
// Check if the user is logged in as a teacher
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

$query = "SELECT FirstName, LastName, ProfilePicture FROM Professors";
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
    <title>Teacher Dashboard</title>>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/header_footer.css">
    <!-- Insert any styles or links to stylesheets here -->
</head>

<body>
<div class="container">
        <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><img class="logo-image" src="../../image/LGG.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../../teacher/dashboard/dashboard.php">Home</a></li>
           
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
                <button>
                    <a href='../manage_cours/cours.php'><img src="../../image/LGG.png" alt="Description de l'image"></a> <!-- Link to view all courses -->   
                </button>
                <div class="bar" align="center">
                    <span class="text">Course Overview</span>
                </div>
            </div>
        
            <div class="dashboard-section">
                <button>
                    <a href='../manage_cours/create_cours.php'><img src="../../image/create-courses.jpeg" alt="Description de l'image"></a> <!-- Link to create course -->
                </button>
                <div class="bar" align="center">
                    <span class="text">creat new course</span>
                </div>
            </div>
        </div>
        <div class="dashboard-sections">
                 <div class="dashboard-section"> 
                <button>
                    <a href='../manage_student/annoucements.php'><img src="../../image/te-announcement.jpeg" alt="Description de l'image"></a> <!-- Link to announcements -->
                </button>
                <div class="bar" align="center">
                    <span class="text"  >annoucement</span>
                </div>
            </div>
        
            <div class="dashboard-section">
                <button>
                    <a href='../manage_student/student_overview.php'><img src="../../image/find-cours.jpeg" alt="Description de l'image"></a> <!-- Link to students enrollements -->
                </button>
                <div class="bar" align="center">
                    <span class="text">student Overview</span>
                </div>
            </div>
        </div> 
        <div class="dashboard-sections">
                 <div class="dashboard-section"> 
                <button>
                    <a href='../manage_student/comunication.php'><img src="../../image/te-communication.jpeg" alt="Description de l'image"></a> <!-- Link to announcements -->
                </button>
                <div class="bar" align="center">
                    <span class="text"  >communication</span>
                </div>
            </div>
        </div>   
        </div>
</div>
</body>
</html>


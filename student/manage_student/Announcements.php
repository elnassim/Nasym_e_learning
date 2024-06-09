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
// dashboard_announcements.php

include ('../../source/mysqlcon.php');

session_start();

// Placeholder StudentID - replace this with the actual logged-in student's ID
$studentID = $_SESSION['StudentID'] ?? null;

// Query to fetch announcements for courses where the student is enrolled
$query = "SELECT Announcements.AnnouncementText, Announcements.DatePosted, Courses.Title
          FROM Announcements
          JOIN Courses ON Announcements.CourseID = Courses.CourseID
          JOIN Enrollments ON Courses.CourseID = Enrollments.CourseID
          WHERE Enrollments.StudentID = :studentID
          ORDER BY Announcements.DatePosted DESC";

$stmt = $conn->prepare($query);
$stmt->bindParam(':studentID', $studentID, PDO::PARAM_INT);
$stmt->execute();
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="../style/user_management.css">
    <style>
      /* Reset CSS */
/* General Reset */
* {
    margin: ;
    padding: ;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body, html {
    height: 100%;
    font-smooth: always;
    -webkit-font-smoothing: antialiased;
}


body {
    background-color: #f4faff; /* light sky blue background */
    line-height: 1.6;
    color: #666;
    font-size: 16px;
}

.container {
    max-width: 800px;
    margin:  auto;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #005388; /* Dark sky blue theme for headers */
    padding: 20px ;
    margin-bottom: 30px;
}

.announcements {
    list-style: none;
}

.announcement {
    background: white;
    border-left: 4px solid #5cacee; /* Edge border */
    margin-bottom: 20px;
    padding: 20px 25px;
    border-radius: 5px;
    box-shadow:  5px 15px -5px rgba(0, 0, 0, .1);
    transition: all .25s ease-out;
}

.announcement:hover {
    box-shadow:  5px 15px -2px rgba(0, 0, 0, .2);
    border-left: 4px solid #01799b; /* Darker border edge */
    transform: scale(1.02);
}

.announcement h2 {
    color: #005388; /* Dark sky blue for announcement titles */
    margin-top: 0;
}

.announcement time {
    font-size: .875rem;
    color: #999;
    margin-top: 5px;
}
.sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
.announcement p {
    color: #333;
    line-height: 1.75;
    margin-top: 10px;
}

/* Responsive behavior */
@media screen and (max-width: 768px) {
    .container {
        width: 95%;
        padding: ;
    }
}
    </style>
    <!-- Add your stylesheet links here -->
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
<div class="container">
  <h1>Course Announcements</h1>

  <!-- Check if there are any announcements -->
  <?php if (!empty($announcements)): ?>
    <section class="announcements">
      <?php foreach ($announcements as $announcement): ?>
        <article class="announcement">
          <h2><?php echo htmlspecialchars($announcement['Title']); ?></h2>
          <p><?php echo nl2br(htmlspecialchars($announcement['AnnouncementText'])); ?></p>
          <time datetime="<?php echo htmlspecialchars($announcement['DatePosted']); ?>">
            Posted on: <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($announcement['DatePosted']))); ?>
          </time>
        </article>
      <?php endforeach; ?>
    </section>
  <?php else: ?>
    <p>No announcements available.</p>
  <?php endif; ?>
</div>

</body>
</html>
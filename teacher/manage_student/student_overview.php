<?php 
// Include header
include_once("../includes/header.php");
?>
<?php
session_start();


// Check if the user is logged in as a teacher
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

// Include database connection
include_once("../../source/mysqlcon.php");

// Fetch courses created by the teacher
$professorID = $_SESSION['ProfessorID'];
$query = "SELECT CourseID, Title FROM Courses WHERE ProfessorID = :professorID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':professorID', $professorID, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch student enrollments and count for each course
$enrollments = [];
foreach ($courses as $course) {
    $courseID = $course['CourseID'];
    $query = "SELECT COUNT(*) AS EnrollmentCount FROM Enrollments WHERE CourseID = :courseID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
    $stmt->execute();
    $enrollmentCount = $stmt->fetchColumn();
    $enrollments[$courseID] = $enrollmentCount;
}

// Fetch student information for enrolled students in each course
$enrolledStudents = [];
foreach ($courses as $course) {
    $courseID = $course['CourseID'];
    $query = "SELECT Students.StudentID, Students.FirstName, Students.LastName, Students.Email, Enrollments.EnrolledAt 
              FROM Students 
              INNER JOIN Enrollments ON Students.StudentID = Enrollments.StudentID 
              WHERE Enrollments.CourseID = :courseID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
    $stmt->execute();
    $enrolledStudents[$courseID] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Overview</title>
    <link rel="stylesheet" href="../style/user_management.css">
    <style>
    /* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin-left: 250px;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    width: 100px;
}

nav ul {
    list-style-type: none;
}

nav ul li {
    display: inline-block;
    margin-right: 20px;
}

.menu-toggle {
    display: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}

.menu-toggle i {
    cursor: pointer;
}

.register-section {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 50px;
    border-radius: 10px;
    margin-top: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: none;
}

.form-container {
    width: 70%;
}

.input-box {
    position: relative;
    margin-bottom: 20px;
}

.input-box i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.input-box input[type="text"],
.input-box input[type="file"],
.input-box select {
    width: 100%;
    padding: 10px;
    padding-left: 40px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.input-box input[type="checkbox"] {
    width: auto;
    margin-right: 10px;
}
input[type="submit"]{
    background-color: #0077b6;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
}
button {
    background-color: #0077b6;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
}

button:hover {
    background-color: #555;
}
.register-section {
    max-width: 900px; /* Ajustez la largeur maximale selon vos besoins */
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
.search-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-input {
            padding: 10px;
            width: 300px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
            
            font-size: 16px;
        }


        /* Hover effect for the search button */
 .user-list-container {
  margin-bottom: 40px;
  animation: fadeIn 0.5s ease-in-out;
  width: 140%;

}

.user-list-container h2 {
  font-size: 20px;
  margin-bottom: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead th {
  background-color: #DCDCDC;
  padding: 10px;
  text-align: left;
  color:#0077b6;
}

tbody td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}
.table-container {
            display: flex;
            justify-content: center;
        }
        .course-container {
            border: 1px solid #ccc; /* Bordure grise de 1 pixel */
            border-radius: 10px; /* Coins arrondis */
            padding: 20px; /* Espace intérieur */
            margin-bottom: 20px; /* Marge en bas */
        }
    </style>
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
    <br>
    <br>
    
    <h2 align="center">Student Overview</h2><br><br>
    <section class="register-section" id="register">
    <div class="register-container">
      
            <div class="form-container">
    <div>
    <form method="get">
    <div class="search-container">
        <input type="text" id="course_search" class="search-input" name="course_search" placeholder="Search...">
        <button type="submit" class="search-button">Search</button>
    </form>
    </div>
    </div>
    <br><br>
    <?php foreach ($courses as $course): ?>
        <!-- Check if course title matches the search query, if set -->
        <?php if (isset($_GET['course_search']) && stripos($course['Title'], $_GET['course_search']) === false) continue; ?>
        <div class="course-container"> 
        <h2><?php echo htmlspecialchars($course['Title']); ?></h2><br>
        <p>Total Enrollments: <?php echo $enrollments[$course['CourseID']]; ?></p><br><br>
        <div class="table-container">
        <div class="user-list-container">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Enrolled At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolledStudents[$course['CourseID']] as $student): ?>
                    <tr>
                        <td><?php echo $student['StudentID']; ?></td>
                        <td><?php echo htmlspecialchars($student['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($student['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($student['Email']); ?></td>
                        <td><?php echo $student['EnrolledAt']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        </div>
                </div>
                </div>
    <?php endforeach; ?>
    </div>
        </div>
    </section>
</body>
</html>


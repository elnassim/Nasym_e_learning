<?php 
// Include header
include_once("../includes/header.php");
?>
<?php
// Include header


// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

// Include database connection
include_once("../../source/mysqlcon.php");

// Fetch courses
$query = "SELECT Courses.*, Subjects.SubjectName FROM Courses INNER JOIN Subjects ON Courses.SubjectID = Subjects.SubjectID";
$params = array();

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search query
    $search = $_POST['search'];
    
    // Append search condition to the query
    $query .= " WHERE (Title LIKE ? OR SubjectName LIKE ? OR Keywords LIKE ?)";
    // Add wildcard % to search for partial matches
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separate courses created by the logged-in teacher
$teacher_courses = [];
$other_courses = [];

foreach ($courses as $course) {
    if ($course['ProfessorID'] == $_SESSION['ProfessorID']) {
        $teacher_courses[] = $course;
    } else {
        $other_courses[] = $course;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin-left: 250px;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #333;
    }
    h2{
        text-align: center;
        margin-top: 30px;
        color: #333;
    }

    .courses {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
    }

    .course {
        flex-basis: calc(33.33% - 20px);
        border: 1px solid #ddd;
        background-color: #fff;
        padding: 20px;
        text-align: center;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .course:hover {
        transform: translateY(-5px);
    }

    .course img {
        width: 290px;
        height: 190px;
        object-fit: cover;
        border-radius: 8px;
    }


    .course p {
        color: #666;
        margin: 10px 0;
    }

.modifier:hover {
        background-color: #1d7da2;
    }

    form {
        margin-top: 10px;
        text-align: center;
    }

    input[type="text"] {
        padding: 10px;
        width: 300px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-right: 10px;
    }
    input[type="submit"] {
        padding: 10px 20px;
        background-color: #005388;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button[type="submit"] {
        padding: 10px 20px;
        background-color: #005388;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
  
    </style>
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
    <h1>View Courses</h1>
    
    <!-- Search form -->
    <form method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Search by course name, subject, or keywords">
        <button type="submit">Search</button>
    </form>
    <section>
    <h2>Courses created by you</h2>
    <div class="courses">
        <!-- Display courses created by the teacher -->
       
       
       
        <?php foreach ($teacher_courses as $course): ?>
            <div class="course">
                <img src="<?php echo $course['CourseImage']; ?>" alt="Course Image">
                <h3><?php echo $course['Title']; ?></h3>
                <p><?php echo $course['SubjectName']; ?></p>
                <button type="submit" onclick="location.href='modify_cours.php?id=<?php echo $course['CourseID']; ?>'">Modify Course</button>
                <button type="submit" onclick="location.href='view_cours_details.php?id=<?php echo $course['CourseID']; ?>'">View Course</button>
                <form method="post" action="delete_cours.php">
                    <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                    <input type="submit" name="delete_course" value="Delete Course" onclick="return confirm('Are you sure you want to delete this course?')">
                </form>
            </div>
        <?php endforeach; ?>

        <!-- Display other courses -->
       
        </section>
         <section>   
       <h2>All courses</h2>
       <div class="courses">
        <?php foreach ($other_courses as $course): ?>
            
            <div class="course">
           
                <img src="<?php echo $course['CourseImage']; ?>" alt="Course Image">
                <h3><?php echo $course['Title']; ?></h3>
                <p><?php echo $course['SubjectName']; ?></p>
                <button  type="submit"  onclick="location.href='view_cours_details.php?id=<?php echo $course['CourseID']; ?>'">View Course</button>
            </div>
        <?php endforeach; ?>
    </div>
        </section>
</body>
</html>



<?php
// Close connection
$conn = null;
?>

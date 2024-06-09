<?php 
// Include header
include_once("../includes/header.php");
?>
<?php
// Include database connection
include_once("../../source/mysqlcon.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'course_id' key is set in the $_POST array
    if(isset($_POST['course_id'])) {
        // Assuming the student ID is stored in a session variable named 'StudentID'
        session_start();
        if (isset($_SESSION['StudentID'])) {
            $studentID = $_SESSION['StudentID'];
            
            // Get the course ID from the POST data
            $courseID = $_POST['course_id'];
            
            // Check if the student is already enrolled in the course
            $query = "SELECT * FROM Enrollments WHERE StudentID = ? AND CourseID = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$studentID, $courseID]);
            
            if ($stmt->rowCount() > 0) {
                // Student is already enrolled in the course
                echo "alreadyEnrolled";
            } else {
                // Student is not enrolled, enroll them in the course
                $insertQuery = "INSERT INTO Enrollments (StudentID, CourseID) VALUES (?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                if ($insertStmt->execute([$studentID, $courseID])) {
                    echo "success";
                } else {
                    echo "error";
                }
            }
        } else {
            // Student is not logged in
            echo "loginRequired";
        }
    } else {
        
    }
}

// Fetch courses
$query = "SELECT Courses.*, Subjects.SubjectName FROM Courses INNER JOIN Subjects ON Courses.SubjectID = Subjects.SubjectID";
$params = array();

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search query if 'search' key is set
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    
    // Append search condition to the query if search query is not empty
    if(!empty($search)) {
        $query .= " WHERE (Title LIKE ? OR SubjectName LIKE ? OR Keywords LIKE ?)";
        // Add wildcard % to search for partial matches
        $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
    }
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }
    h1 {
    text-align: center; /* Centrer le titre */
    margin-left: 90px; /* Décaler le titre vers la droite */
    color: #333;
    margin-top: 30px;
    }
    p {
    text-align: center; /* Centrer le paragraphe */
    margin-left: 20px; /* Décaler le paragraphe vers la droite */
    color: #666;
    }
    .sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;}
    .courses {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
        margin-left: 200px;
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
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .course h2 {
        margin: 10px 0;
        color: #333;
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
    margin-left: 20px; /* Ajoutez cette ligne pour décaler le formulaire vers la droite */
}
    input[type="text"] {
    padding: 10px;
    width: 300px;
    border-radius: 5px;
    border: 1px solid #ddd;
    margin-right: 10px;
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
    margin-left: 10px; /* Ajoutez cette ligne pour décaler le bouton vers la droite */
}

    button[type="submit"]:hover {
        background-color: #45a049;
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
    <h1>View Courses</h1>
    
    <!-- Search form -->
    <form method="post">
        <label for="search"></label>
        <input type="text" id="search" name="search" placeholder="Search by course name, subject, or keywords">
        <button type="submit">Search</button>
    </form>
    
    <div class="courses">
        <?php foreach ($courses as $course): ?>
            <div class="course">
                <img src="../professor/manage_cours/<?php echo $course['CourseImage']; ?>" alt="Course Image">
                <h2><?php echo $course['Title']; ?></h2>
                <p><?php echo $course['SubjectName']; ?></p>
                <!-- Add registration form -->
                <form method="post">
                    <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                    <button type="submit" class="modifier" onclick="registerCourse(event)">Register</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<script>
function registerCourse(event) {
    // Empêcher le comportement par défaut du formulaire
    event.preventDefault();

    // Soumettre le formulaire via AJAX
    var form = event.target.closest('form');
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Vérifier la réponse du serveur
            var response = xhr.responseText;
            if (response.includes(" enrolled in this course successesfuly.")) {
                // Afficher une boîte de dialogue avec le message
                alert("enrolled in this course successesfuly.");
            } else {
                // Recharger la page pour afficher les changements
                window.location.reload();
            }
        } else {
            // En cas d'erreur, afficher un message d'erreur générique
            alert('Error occurred while processing your request.');
        }
    };
    xhr.send(formData);
}
</script>
</html>

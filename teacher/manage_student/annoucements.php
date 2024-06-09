
<?php
include_once("../includes/header.php");
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

// Include database connection
include_once("../../source/mysqlcon.php");
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
// Fetch courses created by the teacher
$professorID = $_SESSION['ProfessorID'];
$query = "SELECT * FROM Courses WHERE ProfessorID = :professorID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':professorID', $professorID, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch announcements made by the teacher
$query = "SELECT Announcements.*, Courses.Title AS CourseTitle FROM Announcements 
          INNER JOIN Courses ON Announcements.CourseID = Courses.CourseID 
          WHERE Announcements.ProfessorID = :professorID";

// Check if search query is set
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " AND Courses.Title LIKE :search";
}

$query .= " ORDER BY Announcements.DatePosted DESC";

$stmt = $conn->prepare($query);
$stmt->bindParam(':professorID', $professorID, PDO::PARAM_INT);

// Bind search parameter if set
if (isset($search)) {
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}

$stmt->execute();
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseID = $_POST['course_id'];
    $announcementText = $_POST['announcement_text'];

    // Insert announcement into the database
    $query = "INSERT INTO Announcements (CourseID, ProfessorID, AnnouncementText) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$courseID, $professorID, $announcementText]);

    if ($stmt->rowCount() > 0) {
        // Announcement added successfully
        echo "<p>Announcement added successfully.</p>";
    } else {
        // Error adding announcement
        echo "<p>Error adding announcement.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/header_footer.css">
    <title>Manage Announcements</title>
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
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
           
        }

        .register-section {
            margin-bottom: 40px;
            text-align: center;
            /* Aligner le contenu au centre */
        }

        .register-container {
             max-width: 800px;
             margin: 0 auto;
             padding: 20px;
             border-radius: 10px;
             text-align: left;
             margin-right: 100px;
        }

        .form-container {
            width: 70%;
            margin: 0 auto;
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box input[type="text"],
        .input-box select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],
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
            background-color: #00557a;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            width: 300px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
            border-right: none;
            font-size: 16px;
        }

        .search-button {
            background-color: #0077b6;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        

        .search-button:hover {
            background-color: #00557a;
        }

        .user-list-container {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #DCDCDC;
            padding: 10px;
            text-align: left;
            color: #0077b6;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .table-container {
            display: flex;
            justify-content: center;
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <section class="register-section" id="register">
    
     
        <div class="register-container">
        <h1 align="center">Add Announcement</h1><br><br>
            <div class="form-container">
                <div class="input-box">
                    <select id="course_id" name="course_id" required>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['CourseID']; ?>"><?php echo $course['Title']; ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                </div>
                <div class="input-box">
                    <input type="text" id="announcement_text" name="announcement_text" rows="4" cols="50" placeholder="Announcement Text" class="input-field" required><br><br>
                </div>
                <input type="submit" value="Add Announcement">
            </div>
        </div>
        </div>
    </section>
</form>
<section class="register-section" id="register">
    <div class="content">
    <div class="register-container">
    <h2 align="center">Your Announcements</h2><br><br>
        <div class="form-container">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="search-container">
                    <input type="text" class="search-input"   name="search" placeholder="Search...">
                    <button type="submit" class="search-button">Search</button>
                </div>
            </form>
            <br><br>
            <?php if (count($announcements) > 0): ?>
                <div class="table-container">
                    <div class="user-list-container">
                        <table>
                            <thead>
                            <tr>
                                <th>Course</th>
                                <th>Announcement</th>
                                <th>Date Posted</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                    <td><?php echo $announcement['CourseTitle']; ?></td>
                                    <td><?php echo $announcement['AnnouncementText']; ?></td>
                                    <td><?php echo $announcement['DatePosted']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p>No announcements made yet.</p>
            <?php endif; ?>
        </div>
    </div>
    </div>
</section>
</body>
</html>

<?php
include_once("../includes/header.php");
?>
<?php
// Close connection
$conn = null;
?>


?>

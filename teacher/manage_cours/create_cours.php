<?php

// Include header
include_once("../includes/header.php");

// Include database connection
include_once("../../source/mysqlcon.php");

// Check if the user is logged in as a teacher
session_start();
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

// Fetch subjects from the database
$query = "SELECT * FROM Subjects";
$stmt = $conn->prepare($query);
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $courseName = $_POST['course_name'];
    $subjectID = $_POST['subject_id'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords']; // Retrieve keywords
    $prerequisites = $_POST['prerequisites']; // Retrieve prerequisites

    // Handle file upload for course image if it's set
    if (isset($_FILES['course_image'])) {
        $imageFileName = $_FILES['course_image']['name'];
        $imageTmpName = $_FILES['course_image']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowedExtensions)) {
            $targetDirectory = "uploads/";
            $targetFilePath = $targetDirectory . basename($imageFileName);
            // Move the uploaded image to the uploads directory
            if (move_uploaded_file($imageTmpName, $targetFilePath)) {
                // Image uploaded successfully, save the file path to the database
                $courseImage = $targetFilePath;
            } else {
                // Error uploading image
                echo "<p>Error uploading course image.</p>";
            }
        } else {
            // Invalid file format
            echo "<p>Only JPG, JPEG, PNG, and GIF files are allowed.</p>";
        }
    } else {
        // No course image uploaded
        $courseImage = null;
    }

    // Perform validation here if needed

    // Insert course into the database
    $query = "INSERT INTO Courses (ProfessorID, SubjectID, Title, Description, Keywords, Prerequisites, CourseImage) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['ProfessorID'], $subjectID, $courseName, $description, $keywords, $prerequisites, $courseImage ?? null]);

    if ($stmt->rowCount() > 0) {
        // Course created successfully
        $courseID = $conn->lastInsertId();

        // Insert parts of the course into the database
        if (isset($_POST['part_name'])) {
            $partNames = $_POST['part_name'];
            $partDescriptions = $_POST['part_description'];
            $fileNames = $_FILES['course_materials']['name']; // Get uploaded file names

            // Loop through each part
            foreach ($partNames as $key => $partName) {
                $partDescription = $partDescriptions[$key];
                $fileName = $fileNames[$key];

                // Move uploaded file to uploads directory
                $targetDirectory = "uploads/";
                $targetFilePath = $targetDirectory . basename($fileName);
                move_uploaded_file($_FILES['course_materials']['tmp_name'][$key], $targetFilePath);

                // Insert part into the database with file name
                $query = "INSERT INTO CourseParts (CourseID, PartName, Description, FilePath, Visible) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                // By default, set parts to visible
                $visible = isset($_POST['part_visibility'][$key]) ? 1 : 0;
                $stmt->execute([$courseID, $partName, $partDescription, $targetFilePath, $visible]);
            }
        }
        echo "<script>";
        echo "alert('Course created successfully.!');";
        echo "</script>";
    } else {
        // Error creating course
        echo "<p>Error creating course.</p>";
    }
}
?>
<script>
        // Fonction pour afficher le message "Course created successfully!" en tant que popup
        function displaySuccessMessage() {
            alert('Course created successfully!');
        }

        // Vérifiez si l'URL contient le paramètre de succès
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        if (success === 'true') {
            // Appelez la fonction pour afficher le message de succès
            displaySuccessMessage();
        }
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Professor Registration</title>
    
</head>

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
    padding: 20px;
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
    max-width: 600px; /* Ajustez la largeur maximale selon vos besoins */
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
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
           
            <li><a href="../../teachers/dashboard/aboutus.php">About us</a></li>
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
    
   


    <!-- Student registration form -->
   
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <section class="register-section" id="register">
        <div class="register-container">
            
            <div class="form-container">
                <div><h1 align="center" id="cs">Create Course</h1></div>
                <br/>
                <br/>
                <div class="input-box">
                 
                    <input type="text" id="course_name" name="course_name" class="input-field" placeholder="course name" required>
                </div>
                <select id="subject_id" name="subject_id" required>
            
         <?php foreach ($subjects as $subject): ?>
                <option value="<?php echo $subject['SubjectID']; ?>"><?php echo $subject['SubjectName']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>
                <div class="input-box">
                   
                    <input type="text" id="description" class="input-field" name="description" placeholder="description" required>
                </div>
                <div class="input-box">
                  
                    <input type="text" id="password" class="input-field" name="keywords" placeholder="keywords" required>
                </div>
                <div class="input-box">
                    
                    <input type="text" id="prerequisites" class="input-field" name="prerequisites" placeholder="prerequisites" required>
                </div>
                <div  class="input-box">
                <button for="profile-image" class="choose-file-btn">add image</button>
                    <input type="file" id="course_image" class="input-field" name="course_image" placeholder="image" accept="image/*" required>
                </div>
                
                <div id="course_parts">
            <div class="course_part">
                
            <div class="input-box">
                   
                   <input type="text" name="part_name[]" placeholder="part name" class="input-field" required>
               </div>
               <div class="input-box">
                  
                   <input type="text" name="part_description[]" placeholder="part description" class="input-field" required>
               </div>
               <div class="input-box">
               <button for="profile-image" class="choose-file-btn">add file</button>

                   <input type="file" name="course_materials[]"  multiple>
               </div>
               <div class="input-box">
                   <label>visible :</label>
                   <input type="checkbox" id="part_visibility" name="part_visibility[]" value="visible" checked>
               </div>
            </div>
        </div>
        <button type="button" id="add_part">Add Part</button><br><br>
                <button class="but" type="submit" value="Login">Create course</button>
               
            </div>
        </div>
    </section>
    </form>
    <script>
        // Script to add multiple parts of the course dynamically
        document.getElementById('add_part').addEventListener('click', function() {
            var courseParts = document.getElementById('course_parts');
            var newPart = document.createElement('div');
            newPart.innerHTML = `
                <div class="course_part">
                <div class="input-box">
                   
                   <input type="text" name="part_name[]" placeholder="part name" class="input-field" required>
               </div>
               <div class="input-box">
                  
                   <input type="text" name="part_description[]" placeholder="part description" class="input-field" required>
               </div>
               <div class="input-box">
                  
                   <input type="file" name="course_materials[]"  multiple>
               </div>
               <div class="input-box">
                   <label>visible :</label>
                   <input type="checkbox" id="part_visibility" name="part_visibility[]" value="visible" checked>
               </div>
                </div>
            `;
            courseParts.appendChild(newPart);
        });
    </script>
    
   
     
</body>
</html>
<?php
// Close connection
$conn = null;
?>
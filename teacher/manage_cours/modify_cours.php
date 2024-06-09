<?php
session_start();

// Include header
include_once("../includes/header.php");



// Include database connection
require_once("../../source/mysqlcon.php");

// Check if the user is logged in as a teacher
if (!isset($_SESSION['ProfessorID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../authentication/login.php");
    exit();
}

// Check if course ID is provided and not empty
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to error page or display error message
    exit("Course ID not provided.");
}

// Sanitize the course ID
$courseID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// Fetch course details
$query = "SELECT * FROM Courses WHERE CourseID = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$courseID]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch parts of the course
$query = "SELECT * FROM CourseParts WHERE CourseID = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$courseID]);
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle modifications (deleting parts, adding files/text to parts, etc.)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Deleting parts
    if (isset($_POST['delete_part']) && is_array($_POST['delete_part'])) {
        foreach ($_POST['delete_part'] as $partID) {
            // Delete the part from the database
            $query = "DELETE FROM CourseParts WHERE PartID = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$partID]);
            // Optionally, you may also need to delete associated files from storage
        }
    }

    // Adding files/text to parts
    // Example: Loop through each part to check for text/file updates
    foreach ($parts as $part) {
        // Check if there's any text update for this part
        if (isset($_POST['edit_part'][$part['PartID']])) {
            $updatedText = $_POST['edit_part'][$part['PartID']];
            // Update the part's description in the database
            $query = "UPDATE CourseParts SET Description = ? WHERE PartID = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$updatedText, $part['PartID']]);
        }

        // Check if there's any file uploaded for this part
        if (isset($_FILES['edit_part_file'][$part['PartID']])) {
            $uploadedFile = $_FILES['edit_part_file'][$part['PartID']];
            // Handle file upload logic here (e.g., move uploaded file to desired directory, update file path in database)
        }
    }

    // Optionally, you may need to handle adding new parts here if you have a mechanism for that
}


    // Example: Deleting parts
    if (isset($_POST['delete_part']) && is_array($_POST['delete_part'])) {
        foreach ($_POST['delete_part'] as $partID) {
            $query = "DELETE FROM CourseParts WHERE PartID = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$partID]);
        }
    }

    // Redirect after processing form data
    header("Location: modify_cours.php?id=$courseID");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Course: <?php echo htmlspecialchars($course['Title']); ?></title>
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
    max-width: 600px; /* Ajustez la largeur maximale selon vos besoins */
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
}
.course-info {
            color: #19394d;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #005388;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: slide-up 0.5s ease;
            position: relative;
        }
</style>
<body>
  
    <!-- Form for modifying course -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $courseID); ?>" enctype="multipart/form-data">
        <!-- Add fields and controls for modifying course details (title, description, image, etc.) -->

        <!-- Display existing parts of the course -->
        <section class="register-section" id="register">
        <div class="container">
        <h1>Modify Course: <?php echo htmlspecialchars($course['Title']); ?></h1>
        
            
          
        <?php foreach ($parts as $part): ?>
            <div class="container">
            <div class="course-info">
                <!-- Display existing part details -->
                <p><?php echo htmlspecialchars($part['PartName']); ?></p><br>
                <p><?php echo htmlspecialchars($part['Description']); ?></p><br><br>
                </div>
                <div class="input-box">
                <!-- Checkbox to delete this part -->
                <input type="checkbox" name="delete_part[]" class="input-field" value="<?php echo htmlspecialchars($part['PartID']); ?>"> Delete this part<br>
        </div>
        </div>
                <!-- Add controls for modifying this part (edit content, replace file, etc.) -->
                
                <div class="input-box">
                <input type="text"  class="input-field" id="edit_part_<?php echo htmlspecialchars($part['PartID']); ?>" name="edit_part[<?php echo htmlspecialchars($part['PartID']); ?>]" placeholder="Edit part"></textarea><br><br>
        </div>
        <div class="input-box">
                <input type="file" class="input-field"  id="edit_part_file_<?php echo htmlspecialchars($part['PartID']); ?>" name="edit_part_file[<?php echo htmlspecialchars($part['PartID']); ?>]" placeholder="Replace File" multiple><br><br>
            </div>
        <?php endforeach; ?>

        <!-- Container for dynamically added parts -->
        <div id="new_parts_container"></div>

        <!-- Add button to add new part -->
        <div class="input-box">
        <button type="button" id="add_part_button">Add Part</button>
        </div>
        <!-- Submit button for saving modifications -->
        <div class="input-box">
        <input type="submit" value="Save Changes">
        </div>        
        </div>
        </div>
        </section>
    </form>

    <!-- Script to add new part dynamically -->
    <script>
        document.getElementById('add_part_button').addEventListener('click', function() {
            var container = document.getElementById('new_parts_container');
            var newIndex = container.children.length + 1;

            var newPartDiv = document.createElement('div');
            newPartDiv.innerHTML = `
                <h2>New Part ${newIndex}</h2>
                <div class="input-box">
                <input type="text" class="input-field" id="new_part_name_${newIndex}" name="new_part_name[]" placeholder="Part Name" required><br><br>
                </div>
                <div class="input-box">
                <input type="text" class="input-field" id="new_part_description_${newIndex}" name="new_part_description[]" rows="4" cols="50" placeholder="Part Description" required></textarea><br><br>
                </div>
                <div class="input-box">
                <input type="file" class="input-field" id="new_part_file_${newIndex}" name="new_part_file[]"  placeholder="Upload File" multiple><br><br>
                </div>
            `;

            container.appendChild(newPartDiv);
        });
    </script>
</body>
</html>


<?php
// Close connection
$conn=null;
?>

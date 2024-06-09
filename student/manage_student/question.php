<?php
session_start();
require_once ('../../source/mysqlcon.php');

// Check if the user is logged in
if (!isset($_SESSION['StudentID'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: ../authentication/login.php");
    exit(); // Stop script execution
}

$studentID = $_SESSION['StudentID'];
$userRole = $_SESSION['userRole'] ?? 'student';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    
   
    // Get the form data
    $courseID = $_POST["CourseID"];
    $questionText = $_POST["QuestionText"];

    // Insert the question into the Questions table
    $questionInsertQuery = "INSERT INTO Questions (CourseID, StudentID, QuestionText) VALUES (:courseID, :studentID, :questionText)";
    $questionInsertStmt = $conn->prepare($questionInsertQuery);
    $questionInsertStmt->bindParam(':courseID', $courseID);
    $questionInsertStmt->bindParam(':studentID', $studentID);
    $questionInsertStmt->bindParam(':questionText', $questionText);

    $questionInsertStmt->execute();
}

// Retrieve courses from the database
$coursesQuery = "SELECT CourseID, Title FROM Courses";
$coursesResult = $conn->query($coursesQuery);

// Initialize courseID with a default value
$courseID = 0;

if (isset($_POST["courseID"])) {
    $courseID = $_POST["courseID"];
}

$questionsQuery = "SELECT Q.QuestionText, S.FirstName, S.LastName
                   FROM Questions Q
                   INNER JOIN Students S ON Q.StudentID = S.StudentID
                   WHERE Q.CourseID = :courseID";
$questionsStmt = $conn->prepare($questionsQuery);
$questionsStmt->bindParam(':courseID', $courseID);
$questionsStmt->execute();
$questionsResult = $questionsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Communication between Professors and Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }
        .discussion-area {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            padding: 15px;
        }
        .question, .answer {
            background-color: #fff;
            border-radius: 15px;
            padding: 10px 15px;
            margin-bottom: 8px;
            display: block;
            max-width: 75%;
            width: calc(100% - 30px);
            box-shadow:  2px 5px rgba(0,0,0,.2);
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #005388;
        }
        form {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select, textarea, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #005388;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 5px;
        }
        p {
            margin: 0;
        }
        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .course-list {
            margin-top: 20px;
        }
        .course-list li {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
        }
        .questions-section {
            margin-top: 20px;
        }
        .question {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .question strong {
            color: #005388;
        }
        .view-answers-btn {
            background-color: #005388;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .view-answers-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
    <h1>Communication between Professors and Students</h1>

    <div class="content">
        <h2>New Question</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="studentID" value="<?php echo $studentID; ?>"> <!-- Automatically include studentID -->
            <label for="courseID">Select a Course:</label>
            <select name="CourseID" id="courseID">
                <?php foreach ($coursesResult as $row) { ?>
                    <option value="<?php echo $row["CourseID"]; ?>"><?php echo $row["Title"]; ?></option>
                <?php } ?>
            </select>

            <label for="questionText">Question:</label>
            <textarea name="QuestionText" id="questionText" rows="4" cols="50"></textarea>

            <input type="submit" value="Post Question" onclick="registerCourse(event)">
        </form>
        <a href="communication.php" class="view-answers-btn">View Answers</a>
    </div>

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

   
</body>
</html>

<?php
// Include header
include_once("../includes/header.php");

session_start();

require_once '../../source/mysqlcon.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $questionID = $_POST["questionID"];
    $answerText = $_POST["answerText"];

    // Retrieve the ProfessorID from session
    $professorID = $_SESSION["ProfessorID"];

    // Check if the provided ProfessorID exists in the Professors table
    $checkProfessorQuery = "SELECT ProfessorID FROM Professors WHERE ProfessorID = ?";
    $checkProfessorStmt = $conn->prepare($checkProfessorQuery);
    $checkProfessorStmt->execute([$professorID]);

    if ($checkProfessorStmt->rowCount() == 0) {
        echo "Error: ProfessorID does not exist in Professors table.";
        exit(); // or handle the error appropriately
    }

    // Insert the answer into the Answers table
    $answerInsertQuery = "INSERT INTO Answers (QuestionID, ProfessorID, AnswerText) VALUES (:questionID, :professorID, :answerText)";
    $answerInsertStmt = $conn->prepare($answerInsertQuery);
    $answerInsertStmt->bindParam(':questionID', $questionID);
    $answerInsertStmt->bindParam(':professorID', $professorID);
    $answerInsertStmt->bindParam(':answerText', $answerText);

    if ($answerInsertStmt->execute()) {
        echo "<script>";
    echo "alert('Your answer has been posted successfully!');";
    echo "</script>";
    } else {
        echo "Error posting answer: " . $answerInsertStmt->errorInfo()[2];
    }
}

// Retrieve questions and related information from the database
$questionsQuery = "SELECT Q.QuestionID, Q.QuestionText, S.FirstName, S.LastName, C.Title AS CourseTitle
                   FROM Questions Q
                   INNER JOIN Students S ON Q.StudentID = S.StudentID
                   INNER JOIN Courses C ON Q.CourseID = C.CourseID";
$questionsStmt = $conn->prepare($questionsQuery);
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
            background-color: #f0f5f9;
            color: #333;
        }

        h1 {
            color: #005388;
        }

        h2 {
            color: #005388;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border-radius: 5px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #005388;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #007acc;
        }

        .hidden {
            display: none;
        }

        .success-message {
            color: #007acc;
            font-weight: bold;
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
<div class="content">
        
    <h1>Communication between Professors and Students</h1>

    <h2>Answer Questions</h2>
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Student Name</th>
                <th>Question</th>
                <th>Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questionsResult as $row) { ?>
                <tr>
                    <td><?php echo $row["CourseTitle"]; ?></td>
                    <td><?php echo $row["FirstName"] . " " . $row["LastName"]; ?></td>
                    <td><?php echo $row["QuestionText"]; ?></td>
                    <td>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="questionID" value="<?php echo $row["QuestionID"]; ?>">
                            <textarea name="answerText" id="<?php echo 'answerText_' . $row["QuestionID"]; ?>" rows="4" cols="50"></textarea><br>
                            <input type="submit" value="Post Answer" id="<?php echo 'submitBtn_' . $row["QuestionID"]; ?>" onclick="hideTextArea(<?php echo $row["QuestionID"]; ?>)">
                            <p id="<?php echo 'postMessage_' . $row["QuestionID"]; ?>" class="hidden success-message">Your answer has been posted successfully!</p>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        function hideTextArea(questionID) {
            document.getElementById('answerText_' + questionID).style.display = 'none';
            document.getElementById('submitBtn_' + questionID).style.display = 'none';
            document.getElementById('postMessage_' + questionID).style.display = 'block';
        }
    </script>
</div>
</body>
</html>
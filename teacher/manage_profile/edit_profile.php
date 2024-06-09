<?php
// Include header
include_once("../includes/header.php");

session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["ProfessorID"])) {
    header("location: ../authentication/login.php");
    exit();
}

// Include database connection file
require_once('../../source/mysqlcon.php');

// Define variables and initialize with empty values
$firstName = $lastName = $email = $password = $confirmPassword = "";
$firstName_err = $lastName_err = $email_err = $password_err = $confirmPassword_err = "";

// Fetch current user's information
$professorID = $_SESSION["ProfessorID"];
$sql = "SELECT FirstName, LastName, Email FROM Professors WHERE ProfessorID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$professorID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process first name
    if (isset($_POST["firstName"])) {
        $firstName = trim($_POST["firstName"]);
        if (empty($firstName)) {
            $firstName_err = "Please enter your first name.";
        }
    }

    // Process last name
    if (isset($_POST["lastName"])) {
        $lastName = trim($_POST["lastName"]);
        if (empty($lastName)) {
            $lastName_err = "Please enter your last name.";
        }
    }

    // Process email
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
        if (empty($email)) {
            $email_err = "Please enter your email address.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    // Process password
    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
        if (empty($password)) {
            $password_err = "Please enter your password.";
        } elseif (strlen($password) < 6) {
            $password_err = "Password must be at least 6 characters.";
        }
    }

    // Process confirm password
    if (isset($_POST["confirmPassword"])) {
        $confirmPassword = trim($_POST["confirmPassword"]);
        if (empty($confirmPassword)) {
            $confirmPassword_err = "Please confirm your password.";
        } elseif ($password != $confirmPassword) {
            $confirmPassword_err = "Passwords do not match.";
        }
    }

    // If no errors, update database
    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($password_err) && empty($confirmPassword_err)) {
        // Update user's profile
        $sql = "UPDATE Professors SET FirstName = ?, LastName = ?, Email = ? WHERE ProfessorID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$firstName, $lastName, $email, $professorID])) {
            // Redirect back to profile page after processing form data
            header("location: profile.php");
            exit();
        } else {
            $error = "Error updating profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/CSS" href="../style/.stylecss">
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
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <section class="register-section" id="register">
        <div class="register-container">
    <div class="form-container">
                <div><h1 align="center" id="cs">Edit Profile</h1></div>
                <div><h6 align="center">Please fill in the form to edit your profile.</h6></div>
                <br/>
                <br/>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" name="firstName" class="input-field" placeholder="LastName" value="<?php echo htmlspecialchars($firstName ? $firstName : $user['FirstName']); ?>">
                </div>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lastName" class="input-field" placeholder="LastName" value="<?php echo htmlspecialchars($lastName ? $lastName : $user['LastName']); ?>">
                </div>
                <div class="input-box"> 
                    <i class="fas fa-user"></i>
                    <input type="email" name="email" class="input-field" value="<?php echo htmlspecialchars($email ? $email : $user['Email']); ?>">
                </div>
       
    
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" placeholder="First Name" name="password">
                    <span><?php echo $password_err; ?></span>

                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" placeholder="First Name" name="confirmPassword">
                    <span><?php echo $confirmPassword_err; ?></span>

                </div>
        <div class="input-box">
        <input type="submit" value="submit" class="submit" href="profile.php">    
        <br/> <br/>       
        <a href="profile.php">Cancel</a>
        </div>
    </div>
    </div>
    </section>
    </form>
    </br></br>
    <style>
        a{
            text-decoration: none;
            color: black;
        }
        body{
            font-family: Arial, sans-serif;
        }
    </style>
</body>
</html>



<?php
// Close connection
$conn=null;
?>
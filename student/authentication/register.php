<?php // teacher/authentication/register.php
session_start(); // Start session for storing user authentication status

// Include database connection file
require_once('../../source/mysqlcon.php');

// Initialize variables
$first_name = $last_name = $email = $username = $password = $confirm_password = '';
$first_name_err = $last_name_err = $email_err = $username_err = $password_err = $confirm_password_err = '';

// Process form submission when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate first name
    if (empty(trim($_POST['first_name']))) {
        $first_name_err = 'Please enter your first name.';
    } else {
        $first_name = trim($_POST['first_name']);
    }

    // Validate last name
    if (empty(trim($_POST['last_name']))) {
        $last_name_err = 'Please enter your last name.';
    } else {
        $last_name = trim($_POST['last_name']);
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter your username.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm your password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check if there are no errors before inserting new user
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare a select statement to check if the username already exists
        $sql = "SELECT StudentID FROM Students WHERE Username = :username";

        // Prepare and execute the select statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if username already exists
        if ($row) {
            $username_err = 'This username is already taken.';
        } else {
            // Prepare an insert statement
            $sql = "INSERT INTO Students (FirstName, LastName, Email, Username, Password) VALUES (:first_name, :last_name, :email, :username, :password)";

            // Prepare and execute the insert statement
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Set $stmt to null to release resources
        $stmt = null;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Student Registration</title>
    <link rel="stylesheet" type="text/CSS" href="../style/user_management.css">
</head>


<body>
<header>
    
        <nav>
            <ul class="left">
                <li><a href="../test.php">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#about">Connection</a></li>
            
            </ul>   
           
        </nav>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </header>


<body>

    
    
   

    <!-- Student registration form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <section class="register-section" id="register">
        <div class="register-container">
            
            <div class="form-container">
                <div><h1 align="center" id="cs">Student</h1></div>
                <br/>
                <br/>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" class="input-field" placeholder="FirstName" name="first_name" value="<?php echo $first_name; ?>">
                </div>
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" class="input-field" placeholder="LastName" name="last_name" value="<?php echo $last_name; ?>">
                </div>
                <div class="input-box"> 
                    <i class="fas fa-user"></i>
                    <input type="text" class="input-field" placeholder="UserName" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    
                    <input type="text" class="input-field" placeholder="Email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" placeholder="Password" name="password">
                    <span><?php echo $password_err; ?></span>

                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" placeholder="confirm_password" name="confirm_password">
                    <span><?php echo $confirm_password_err; ?></span>

                </div>
                <button type="submit" value="Register" class="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>

                
            </div>
        </div>
    </section>
    </form>
    
   <style>
   a{
            text-decoration: none;
            color: black;
        }
   </style>
   

</body>
</html>

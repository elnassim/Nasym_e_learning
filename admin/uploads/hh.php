<?php
// Include database connection
include_once("../../source/mysqlcon.php");

// Initialize variables
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // Prepare a SQL statement to query the database
    $stmt = $conn->prepare("SELECT ProfessorID, Username, Email, Password, FirstName, LastName, Active FROM Professors WHERE (Username = :usernameOrEmail OR Email = :usernameOrEmail)");
    
    // Bind parameters
    $stmt->bindParam(':usernameOrEmail', $usernameOrEmail);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        // Check if a user exists with the provided username or email
        if ($stmt->rowCount() == 1) {
            // Fetch user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user['Active'] == 1) {
                // User exists and is active, verify password
                if (password_verify($password, $user['Password'])) {
                    // Password is correct, start session and redirect to dashboard
                    session_start();
                    $_SESSION['ProfessorID'] = $user['ProfessorID'];
                    $_SESSION['FirstName'] = $user['FirstName'];
                    $_SESSION['LastName'] = $user['LastName'];
                    header("location: ../dashboard/dashboard.php");
                    exit();
                } else {
                    // Password is incorrect
                    $error = "Invalid password";
                }
            } else {
                // User is not active
                $error = "Your account is inactive. Please contact the administrator.";
            }
        } else {
            // User does not exist
            $error = "User not found";
        }
    } else {
        // Error executing query
        $error = "Internal server error. Please try again later.";
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
    <title>Professor Registration</title>
    <link rel="stylesheet" type="text/CSS" href="../style/test.css">
</head>


<body>
<header>
        <div class="logo"><img class="lggg" src="../style/LGG-removebg-preview.png" alt="logo"></div>
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
    
    
   


    <!-- Student registration form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <section class="register-section" id="register">
        <div class="register-container">
            
            <div class="form-container">
                <div><h1 align="center" id="cs">Welcome Professor</h1></div>
                <br/>
                <br/>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="input-field" id="username_or_email" name="username_or_email" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-field" id="password" name="password" placeholder="Password" required>
                </div>
                <a href="register.php"><button class="but" type="submit" value="Login">Log in</button></a>
               
            </div>
        </div>
    </section>
    </form>
    
   
    <footer>
        <p>&copy; 2024 NASMY. All rights reserved.</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <div class="copyright">
            <p>Designed and developed by NASMY team.</p>
        </div>
    </footer>

</body>
</html>

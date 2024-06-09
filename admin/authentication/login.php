<?php
// Include database connection
include_once("../../source/mysqlcon.php");
session_start();
// Initialize variables
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // Prepare a SQL statement to query the database
    $stmt = $conn->prepare("SELECT AdminID, Username, Email, Password, FirstName, LastName, Active FROM admins WHERE (Username = :usernameOrEmail OR Email = :usernameOrEmail)");
    
    // Bind parameters
    $stmt->bindParam(':usernameOrEmail', $usernameOrEmail);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        // Check if a user exists with the provided username or email
        if ($stmt->rowCount() == 1) {
            // Fetch user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user['Active'] == 1) {
                // User exists and is active, check password
                if ($password === $user['Password']) {
                    // Password is correct, start session and redirect to dashboard
                    $_SESSION['AdminID'] = $user['AdminID'];
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
                $error = "Your account is inactive. ";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style/user_management.css">
</head>
<body>
 <header>   

        <nav>
            <ul class="left">
                <li><a href="../../index.php">Home</a></li>
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
   
<?php if (!empty($error)) : ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>
<form method="post" action="login.php">
    <section class="register-section" id="register">
        <div class="register-container">
            <div class="form-container">
                <div><h1 align="center" id="cs">Welcome Admin</h1></div>
                <br/>
                <br/>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" class="input-field" id="username_or_email" name="username_or_email"  placeholder="Email" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                </br>
                    <input type="password" class="input-field" id="password" name="password" placeholder="Password" required>
                    
                </div>
                <button type="submit" value="Log in" class="submit">Log in</button>
            </div>
        </div>
    </section>
</form>

    </form>
   

</body>

</html>

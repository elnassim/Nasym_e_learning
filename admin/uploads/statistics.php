<?php
include '../../source/mysqlcon.php';

// Récupérer les informations de l'administrateur
$query = "SELECT FirstName, LastName, ProfilePicture FROM Admins";
$result = $conn->query($query);

if ($result && $result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $profileImage = $row['ProfilePicture'];
} else {
    // Gérer le cas où aucun administrateur n'est trouvé
    $firstName = 'Nom';
    $lastName = 'Inconnu';
    $profileImage = 'default.jpg'; // Remplacez "default.jpg" par le nom de votre image de profil par défaut
}
?>



?><?php include '../../source/mysqlcon.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
</head>
<body>
<div class="container">
        <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><img class="lgg" src="../style//LGG-removebg-preview.png" alt="logo"></div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php">Home</a></li>
            
            <li><a href="user_management.php">Manage Teachers</a></li>
            <li><a href="course_management.php">Manage Courses</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="enrollment_management.php">Manage Enrollments</a></li>
            <li><a href="support_maintenance.php">Support and Maintenance</a></li>
            <li><a href="about.php">Contact</a></li>
           

        </ul>
        
        <div class="sideba">
  <div class="pro">
  <hr>
    <h3><?php echo $firstName . ' ' . $lastName; ?></h3>
    <div class="profile-photo">
    <img id="profile-image" src="images/<?php echo $profileImage; ?>" alt="Profile Image">
    
</div>
<div class="menu">
   
     <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <label for="profile-image-upload">Change Profile Picture</label>
                <input type="file" id="profile-image-upload" name="profile-image-upload">
                <button type="submit">Save</button>
                <hr>
                
                <ul class="sidebar-menu">
                  <li><a href="about.php"><i class='bx bx-log-out'></i>log out</a></li>
                </ul>
            </form>
    
            
</div>
  </div>
  
</div>
    </div>

<div class="content">
<?php include '../../source/mysqlcon.php'; ?>

<link rel="stylesheet" href="styles/statistics.css">

<div class="dashboard-container">
    <h1>Statistics</h1>

    <!-- Statistics content -->
    <div class="chart-container">
        <h2>Chart</h2>
        <canvas id="chart"></canvas>
    </div>

    <div class="table-container">
        <h2>Table</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Number of Enrolled Students</th>
                    <th>Student Name</th>
                    <th>Student Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Example of retrieving data for the table from the database
                $sql = "SELECT * FROM courses";
                $result = $conn->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $courseId = $row["CourseID"];
                        $sqlCount = "SELECT COUNT(*) AS student_count FROM students WHERE CourseID = $courseId";
                        $resultCount = $conn->query($sqlCount);
                        $rowCount = $resultCount->fetch(PDO::FETCH_ASSOC);

                        echo "<tr>";
                        echo "<td>" . $row["Title"] . "</td>";
                        echo "<td>" . $rowCount["student_count"] . "</td>";

                        // Retrieve data of students enrolled in the course
                        $sqlStudents = "SELECT FirstName, LastName, Email FROM students WHERE CourseID = $courseId";
                        $resultStudents = $conn->query($sqlStudents);

                        echo "<td>";
                        while ($studentRow = $resultStudents->fetch(PDO::FETCH_ASSOC)) {
                            echo $studentRow['FirstName'] . " " . $studentRow['LastName'] . "<br>";
                        }
                        echo "</td>";

                        echo "<td>";
                        $resultStudents = $conn->query($sqlStudents); // Re-execute the query to fetch results again
                        while ($studentRow = $resultStudents->fetch(PDO::FETCH_ASSOC)) {
                            echo $studentRow['Email'] . "<br>";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Retrieve data for the chart from the database
    <?php
    $chartLabels = array();
    $chartData = array();

    $sql = "SELECT * FROM courses";
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $courseId = $row["CourseID"];
            $sqlCount = "SELECT COUNT(*) AS student_count FROM students WHERE CourseID = $courseId";
            $resultCount = $conn->query($sqlCount);
            $rowCount = $resultCount->fetch(PDO::FETCH_ASSOC);

            $chartLabels[] = $row['Title'];
            $chartData[] = $rowCount['student_count'];
        }
    }
    ?>

    // Generate the chart
    var ctx = document.getElementById('chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chartLabels); ?>,
            datasets: [{
                label: 'Number of Enrolled Students',
                data: <?php echo json_encode($chartData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });            
</script>
    </div>



</div>

   
  </div>
</div>


    
 </div>

    
  
</div >
                
   </div>
        
    <script src="script.js"></script>
    <!-- Your JavaScript code goes here -->
    
<style>
 /* user_management.css */

.dashboard-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  animation: slideIn 0.5s ease-in-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

h1 {
  font-size: 24px;
  text-align: center;
  margin-bottom: 20px;
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.user-list-container {
  margin-bottom: 40px;
  animation: fadeIn 0.5s ease-in-out;
}

.user-list-container h2 {
  font-size: 20px;
  margin-bottom: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead th {
  background-color: #f2f2f2;
  padding: 10px;
  text-align: left;
}

tbody td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.user-actions-container {
  display: flex; /* Add this line to make it a flex container */
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 4px;
  animation: slideIn 0.5s ease-in-out;
  justify-content: center; /* Center the flex items horizontally */
}

.user-actions-container h2 {
  font-size: 20px;
  margin-bottom: 10px;
}

form {
 
  margin-top: 20px;
  animation: fadeIn 0.5s ease-in-out;
}


form h3 {
  font-size: 18px;
  margin-bottom: 10px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-bottom: 10px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}


/* Ajoutez ici d'autres styles CSS selon vos besoins et votre créativité */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

body {
    display: flex;
}.bottom_content {
  position: fixed;
  bottom: 60px;
  left: 0;
  width: 200px;
  cursor: pointer;
  transition: all 0.5s ease;
}
#profile {
  margin-top: auto;
}

.bottom {
  position: absolute;
  display: flex;
  align-items: center;
  left: 0;
  justify-content: space-around;
  padding: 12px 20px;
  text-align: center;
  
  color: var(--grey-color);
  border-top: 1px solid var(--grey-color-light);
  background-color: var(--white-color);
}
.bottom i {
  font-size: 20px;
}
.bottom span {
  font-size: 18px;
}
.sidebar.close .bottom_content {
  width: 200px;
    
  left: 15px;
}
.sidebar.close .bottom span {
  display: none;
}
.sidebar.hoverable .collapse_sidebar {
  display: none;
}
.sidebar {
    width: 200px;
    height: 100vh;
    background-color: #0077b6; /* Blue background */
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    overflow-x: hidden;
    padding-top: 20px;
    border-bottom: 2px solid #fff;
}

.sidebar-header {
    padding: 10px 20px;
    text-align: center;
}

.sidebar-header .logo img {
    max-width: 100%;
    height: auto;
}

.sidebar-menu {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.sidebar-menu li a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.sidebar-menu li a:hover {
    background-color: #005388; /* Darker shade of blue on hover */
}

.content {
    margin-left: 200px;
    
    flex: 1;
}
/* Reset default styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Montserrat', sans-serif;
  line-height: 1.6;
  background-color: #f5f5f5;
  color: #333;
 
    /* Définit l'image de fond et sa position */
 
  background-size: cover; /* Ajuste la taille de l'image pour couvrir tout l'arrière-plan */

  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Header styles */
header {
  background-color: #2e5984;
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  animation: fadeIn 1s ease-out;
  color: white;
}
.menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu li {
  display: inline-block;
  margin-right: 20px; /* Espacement entre les éléments du menu */
}

.logo {
  font-size: 1.6rem;
  font-weight: 600;
  color: #fff;
}

nav ul {
  display: flex;
  list-style-type: none;
}

nav li {
  margin-left: 2rem;
}

nav a {
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

nav a:hover {
  color: #2ea2cd;
}

.menu-toggle {
  display: none;
  color: #fff;
  font-size: 1.5rem;
  cursor: pointer;
}

/* Hero section styles */
.hero {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 80vh;
  text-align: center;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  animation: fadeIn 1s ease-out;
  background-color: rgba(44, 62, 80, 0.4);
  padding: 2rem;
}

.hero h1 {
  font-size: 4rem;
  margin-bottom: 1.5rem;
}

.hero p {
  font-size: 1.8rem;
  margin-bottom: 2.5rem;
}

.hero .cta {
  display: inline-block;
  background-color: #2ea2cd;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  padding: 1.2rem 3rem;
  border-radius: 30px;
  transition: background-color 0.3s ease;
}

.hero .cta:hover {
  background-color: #2ea2cd;
}

/* About section styles */
.about {
  padding: 6rem 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: fadeIn 1s ease-out;
  flex-grow: 1;
  background-color: #2e5984;
  text-align: center;
}

.about h1 {
  font-size: 3rem;
  margin-bottom: 3rem;
  color: #ffffff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.about-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.about-box {
  width: 300px;
  background-color: rgba(255, 255, 255, 0.1);
  padding: 2rem;
  border-radius: 10px;
  margin: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}
.form-container .submit {
  width: 100%;
  padding: 1rem;
  background-color: #237c3a;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.about-box:hover {
  transform: translateY(-10px);
}

.about-box h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  color: #2ea2cd;
}

.about-box p {
  color: #e6e6e6;
}


.modifier {
  background-color: #2ea2cd;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: 1rem;
  padding: 0.5rem 1rem; /* Ajout de la propriété de padding */
  text-decoration: none;
}


.about-box .login-btn {
  background-color: #2ea2cd;
  color: #fff;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 5px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: 1rem;
}


/* Services section styles */
.services {
  padding: 6rem 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: fadeIn 1s ease-out;
  background-color: #f5f5f5;
  text-align: center;
}

.services h1 {
  font-size: 3rem;
  margin-bottom: 3rem;
  color: #2e5984;
}

.services-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.service-box {
  width: 300px;
  background-color: #fff;
  padding: 2rem;
  border-radius: 10px;
  margin: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.service-box:hover {
  transform: translateY(-10px);
}

.service-box i {
  font-size: 3rem;
  color: #2ea2cd;
  margin-bottom: 1.5rem;
}

.service-box h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  color: #2e5984;
}

.service-box p {
  color: #555;
}

/* Testimonials section styles */
.testimonials {
  padding: 6rem 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: fadeIn 1s ease-out;
  background-color: #2e5984;
  text-align: center;
}

.testimonials h1 {
  font-size: 3rem;
  margin-bottom: 3rem;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.testimonials-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.testimonial-box {
  width: 400px;
  background-color: rgba(255, 255, 255, 0.1);
  padding: 2rem;
  border-radius: 10px;
  margin: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: left;
  color: #e6e6e6;
}

.testimonial-box i {
  font-size: 2rem;
  color: #2ea2cd;
  margin-bottom: 1.5rem;
}

.sidebar-header .logo {
    border-bottom: 2px solid #fff; /* Ajout d'une bordure inférieure blanche */
    padding-bottom: 10px; /* Ajout d'un petit espacement en-dessous de la bordure */
}


.testimonial-box p {
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
}

.testimonial-box .user-info {
  display: flex;
  align-items: center;
}

.testimonial-box .user-info img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 1rem;
}

.testimonial-box .user-info h3 {
  font-size: 1.2rem;
  color: #2ea2cd;
}

.testimonial-box .user-info p {
  font-size: 0.9rem;
  margin-bottom: 0;
}

/* Register section styles */
.register-section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 6rem); /* Subtract header and footer height */
  left: 20px;
  background-color: #f5f5f5;
  animation: fadeIn 1s ease-out;
}

.register-container {
  background-color: #fff;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  width: 100%;
  justify-content: center;
}

.register-container .top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.register-container .top span {
  font-size: 0.9rem;
  color: #555;
}

.register-container .top span a {
  color: #2ea2cd;
  text-decoration: none;
  font-weight: 600;
}

.register-container .top header {
  font-size: 1.8rem;
  font-weight: 700;
  color: #2e5984;
}
.file-input-container {
  position: relative;
  display: inline-block;
}
input[type="file"] {
  opacity: 0;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  
  cursor: pointer;
  text-size-adjust: 5px;
}
.file-input-label {
  position: relative;
  top: 0;
  left: 0;
  font-size: 6px; /* Adjust the font size as needed */
  color: gray; /* Adjust the color as needed */
  pointer-events: none; /* Prevent the label from being clickable */
  padding: 2px;
}
.form-container .input-box {
  position: relative;
  margin-bottom: 1.5rem;
}

.form-container .input-box i {
  position: absolute;
  top: 50%;
  left: 1rem;
  transform: translateY(-50%);
  color: #2ea2cd;
}

.form-container .input-field {
  width: 100%;
  padding: 1rem 1rem 1rem 3rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.3s ease;
  
}

.form-container .input-field:focus {
  border-color: #2ea2cd;
}

.form-container .submit {
  width: 100%;
  padding: 1rem;
  background-color: #2ea2cd;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.form-container .submit:hover {
  background-color: #2e5984;  
}

.form-container .two-col {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1.5rem;
}

.form-container .two-col .left label {
  font-size: 0.9rem;
  color: #555;
}

.form-container .two-col .right a {
  color: #2ea2cd;
  text-decoration:  none;
  font-size: 0.9rem;
}

/* Footer styles */
footer {
  background-color:#005388;
  color: #fff;
  padding: 10px;
  text-align: center;
  margin-top: auto; /* Push footer to the bottom */
  animation: fadeIn 1s ease-out;
  
  bottom: 0;
  height: 80px;
  padding-top: 20px;
  padding-bottom: 20px;
 
  
    position: relative; /* or any other value except static */
     /* adjust the value as needed */

}



.social-icons a {
  color: #fff;
  font-size: 1.5rem;
  margin: 0 0.5rem;
  transition: color 0.3s ease;
}

.social-icons a:hover {
  color: #2ea2cd;
}

.copyright p {
  font-size: 0.9rem;
  color: #bbb;
  margin-top: 1rem;
}
.titsin {
  color: #2ea2cd;
  text-align: center;
}
.lgg{
    /* Adjust the height as needed */
    width: 90px;
    height: 90px; /* Adjust the width as needed */
  
}

/* Animations */
@keyframes fadeIn {
  0% {
      opacity: 0;
  }
  100% {
      opacity: 1;
  }
}
.nothin {
  position: relative;
  background-color: #2e5984;
  padding: 0;
  color: #f5f5f5;
  margin: 0;
  fill: #f5f5f5;
  padding: 0;
  overflow: hidden;
  background-image: linear-gradient(to bottom, #2e5984 50%, #f5f5f5 50%);
}
.nothin1 {
  fill: #2e5984;
  background-image: linear-gradient(to bottom, rgba(44, 62, 80, 0.4) 50%, #2e5984 50%);
}
.nothin2 {
  position: relative;
  background-color: #2e5984;
  padding: 0;
  color: #2e5984;
  margin: 0;
  fill: #2e5984;
  padding: 0;
  overflow: hidden;
  background-image: linear-gradient(to bottom, #f5f5f5 50%, #2e5984 50%);
}
.but {
  background-color: #2ea2cd; /* Set the background color of the buttons to green */
  color: white; /* Set the text color to white */
  border: none; /* Remove the border */
  padding: 10px 20px; /* Add padding to the buttons */
  text-decoration: none; /* Remove the underline from the links */
  display: inline-block; /* Make the buttons display as inline-block */
  cursor: pointer; /* Change cursor to pointer on hover */
  border-radius: 5px; /* Add rounded corners */
  height: 100%;
}
.but:hover {
  background-color: #2e5984; /* Change the background color on hover */
}
.left {
  display: flex; /* Use flexbox */
  justify-content: flex-start; /* Align items to the start (left) */
  padding-left: 0; /* Remove default padding */
  list-style-type: none; /* Remove default list style */
}
.home-squiggle svg path {
  fill: none;
  stroke-linecap: round;
  stroke-miterlimit: 10;
  stroke-width: 4;
  stroke: #237c3a;
}
.home-squiggle svg {
  display: block;
}
.dashboard-sections {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.dashboard-section,
.attendance-section {
    width: calc(50% - 10px);
    height: 200px; /* Set a fixed height for consistency */
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
}
.dashboard-section:hover,
.attendance-section:hover {
    transform: translateY(-5px);
}
.dashboard-card {
    background-color: rgba(255, 255, 255, 0.4); /* Semi-transparent background color for text */
    padding: 20px;
    text-align: center;
}
.dashboard-card h3 {
    margin: 0;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.dashboard-card img {
    width: 100%;
    height: auto;
}

.description {
    text-align: center;
}

.description h3 {
    margin-top: 0;
    color:#2e5984 /* Text color for the headings */
}


.container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.sidebar {
    flex-grow: 0;
    flex-shrink: 0;
    /* Add your sidebar styles here */
}

.content {
    flex-grow: 1;
    /* Add your content styles here */
}
.dashboard-section {
  position: relative;
}

.dashboard-section .bar {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 50px;
  background-color:#005388;

  display: flex;
  justify-content: center;
  align-items: center;

}

.dashboard-section .text {
  color: white;
  font-size: 18px;
  font-family: Arial, sans-serif;
  padding: 10px;
}

.sideba {
  width: 200px;
  background-color:#0077b6;
  padding: 20px;
}

.prof img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}

.prof h3 {
  margin-top: 10px;
}

.menu {
  list-style-type: none;
  padding: 0;
}

.menu li {
  margin-bottom: 10px;
}

.menu a {
  text-decoration: none;
  color: #333;
}

.menu a:hover {
  color: #666;
}
hr {
  border-style: solid;
  border-width: 1.4px;
  /* Optional: border-color */
}
.profile-photo {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  overflow: hidden;
}

.profile-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>
</body>
</html>

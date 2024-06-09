<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NASYM</title>
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        p {
            line-height: 1.6;
        }
        
        .team-members {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .member {
            width: 200px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #005388;
            border-radius: 5px;
            text-align: center;
            background-color: #005388;
            color: white;
            transition: transform 0.3s;
        }
        
        .member:hover {
            transform: scale(1.05);
        }
        
        .member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        
        .member h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .member p {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .our-mission {
            margin-top: 20px;
            padding: 10px;
            border: 2px solid #005388;
            border-radius: 5px;
            background-color: white;
        }
        
        .our-mission h2 {
            color: #005388;
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .our-mission p {
            color: #005388;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .our-values {
            margin-top: 20px;
        }
        
        .our-values h2 {
            color: #005388;
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .our-values ul {
            list-style-type: none;
            padding: 0;
        }
        
        .our-values li {
            color: #005388;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>About Us - NASYM</h1>
        <p>Welcome to NASYM! We are a team of students from École Nationale des Sciences Appliquées, passionate about providing innovative solutions and exceptional customer service.</p>
        <div class="team-members">
            <div class="member">
                <img src="g1.jpg" alt="Team Member 1">
                <h2>Krichi </h2>
                <p>Frontend Developer</p>
                <p>Email: krichi.sara@etu.uae.ac.ma</p>
            </div>
            <div class="member">
                <img src="b1.jpg" alt="Team Member 2">
                <h2>Sekkal Mohamedali</h2>
                <p>Backend Developer</p>
                <p>Email: sekkal.mohamedali@etu.uae.ac.ma</p>
            </div>
            <div class="member">
                <img src="g1.jpg" alt="Team Member 3">
                <h2>Talbi Manal</h2>
                <p>Frontend Developer</p>
                <p>Email: manal.talbi@etu.uae.ac.ma</p>
            </div>
            <div class="member">
                <img src="b1.jpg" alt="Team Member 4">
                <h2>El Kaddaoui Nassim</h2>
                <p>Lead Developer</p>
                <p>Email: elkaddaoui.nassim@etu.uae.ac.ma</p>
            </div>
            <div class="member">
                <img src="b1.jpg" alt="Team Member 5">
                <h2>Elmakoudi Younes</h2>
                <p>Backend Developer</p>
                <p>Email: elmakoudi.younes@etu.uae.ac.ma</p>
            </div>
        </div>
        <div class="our-mission">
            <h2>Our Mission</h2>
            <p>At NASYM, we believe in the transformative power of knowledge. Just like a symphony, where each instrument plays a vital role in creating a harmonious melody, we strive to orchestrate an educational experience that resonates with our learners. Our mission is to empower individuals with the skills and knowledge they need to thrive in an ever-changing world. Together, let's unlock your potential and compose a symphony of success.</p>
        </div>
        <div class="our-values">
            <h2>Our Values</h2>
            <ul>
                <li>Integrity</li>
                <li>Teamwork</li>
                <li>Innovation</li>
                <li>Customer Satisfaction</li>
            </ul>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <header>
        <div class="logo"><img class="lggg" src="LGG.png" alt="logo"></div>
        <nav>
            <ul class="left">
                <li><a href="test.php">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#about">Connection</a></li>
            
            </ul>   
           
        </nav>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </header>

    <section class="hero">
        <h1>Welcome to our website</h1>
        <p >"Education is the passport to the future, for tomorrow belongs to those who prepare for it today." - Malcolm X</p>
        <a href="#register" class="cta">Get Started</a>
    </section>
    <div class="nothin1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 45"><path d="M2000,17.26a2.6,2.6,0,0,1-.4.49C1970.2,16.56,1970.41,5,1941,5s-29.42,12.75-58.84,12.75S1852.73,5,1823.31,5s-29.42,12.75-58.83,12.75S1735.06,5,1705.64,5s-29.41,12.75-58.83,12.75S1617.39,5,1588,5s-29.41,12.75-58.83,12.75S1499.72,5,1470.3,5s-29.41,12.75-58.83,12.75S1382.05,5,1352.64,5s-29.42,12.75-58.83,12.75S1264.39,5,1235,5s-29.42,12.75-58.83,12.75S1146.73,5,1117.32,5s-29.42,12.75-58.83,12.75S1029.07,5,999.66,5s-29.42,12.75-58.84,12.75S911.41,5,882,5s-29.41,12.75-58.83,12.75S793.74,5,764.33,5,734.91,17.75,705.5,17.75,676.08,5,646.67,5s-29.42,12.75-58.84,12.75S558.42,5,529,5s-29.41,12.75-58.83,12.75S440.76,5,411.34,5s-29.41,12.75-58.83,12.75S323.1,5,293.68,5s-29.42,12.75-58.83,12.75S205.43,5,176,5,146.6,17.75,117.19,17.75,87.77,5,58.36,5C29.11,5,28.93,17.61,0,17.74V50H2000Z" transform="translate(0 -5)"></path></svg></div>
    <section class="about" id="about">
        <h1>Connection</h1>
        <div class="about-container">
            <div class="about-box">
                <h2>As a teacher</h2>
                <p>Connection as a teacher here.</p>
                <button class="login-btn" onclick="showTeacherLogin()">
                Log in
             </button>
             <button class="login-btn" onclick="showStudentLogin()">
                sign-up
                </button>
            </div>
            <div class="about-box" >
                <h2 >As an admin</h2>
                <p >Connection as an admin here.</p>
                <br/>
                <br/>
                <button class="login-btn" onclick="showAdminLogin()" >
                Log in
             </button>
            </div>
        
            <div class="about-box">
                <h2>As a student</h2>
                <p>lConnection as a student here.</p>
                <button class="login-btn" onclick="showStudentLogin()">
                Log in
                </button>
                <button class="login-btn" onclick="showStudentLogin()">
                    sign-up
                    </button>
            </div>
        </div>  
    </section>

    <div class="nothin"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 45"><path d="M2000,17.26a2.6,2.6,0,0,1-.4.49C1970.2,16.56,1970.41,5,1941,5s-29.42,12.75-58.84,12.75S1852.73,5,1823.31,5s-29.42,12.75-58.83,12.75S1735.06,5,1705.64,5s-29.41,12.75-58.83,12.75S1617.39,5,1588,5s-29.41,12.75-58.83,12.75S1499.72,5,1470.3,5s-29.41,12.75-58.83,12.75S1382.05,5,1352.64,5s-29.42,12.75-58.83,12.75S1264.39,5,1235,5s-29.42,12.75-58.83,12.75S1146.73,5,1117.32,5s-29.42,12.75-58.83,12.75S1029.07,5,999.66,5s-29.42,12.75-58.84,12.75S911.41,5,882,5s-29.41,12.75-58.83,12.75S793.74,5,764.33,5,734.91,17.75,705.5,17.75,676.08,5,646.67,5s-29.42,12.75-58.84,12.75S558.42,5,529,5s-29.41,12.75-58.83,12.75S440.76,5,411.34,5s-29.41,12.75-58.83,12.75S323.1,5,293.68,5s-29.42,12.75-58.83,12.75S205.43,5,176,5,146.6,17.75,117.19,17.75,87.77,5,58.36,5C29.11,5,28.93,17.61,0,17.74V50H2000Z" transform="translate(0 -5)"></path></svg></div>

    <section class="services" id="services">
        <h1>Our Services</h1>
        <div class="services-container">
            <div class="service-box">
                <i class="fas fa-search"></i>
                <h2>Personalized Search</h2>
                <p>We tailor your search to your unique needs and preferences.</p>
            </div>
            <div class="service-box">
                <i class="fas fa-chart-line"></i>
                <h2>Data-Driven Insights</h2>
                <p>We provide unbiased data and analysis to help you make informed decisions.</p>
            </div>
            <div class="service-box">
                <i class="fas fa-hands-helping"></i>
                <h2>Application Assistance</h2>
                <p>We guide you through the entire application process, step by step.</p>
            </div>
        </div>
    </section>

    <div class="nothin2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 45"><path d="M2000,17.26a2.6,2.6,0,0,1-.4.49C1970.2,16.56,1970.41,5,1941,5s-29.42,12.75-58.84,12.75S1852.73,5,1823.31,5s-29.42,12.75-58.83,12.75S1735.06,5,1705.64,5s-29.41,12.75-58.83,12.75S1617.39,5,1588,5s-29.41,12.75-58.83,12.75S1499.72,5,1470.3,5s-29.41,12.75-58.83,12.75S1382.05,5,1352.64,5s-29.42,12.75-58.83,12.75S1264.39,5,1235,5s-29.42,12.75-58.83,12.75S1146.73,5,1117.32,5s-29.42,12.75-58.83,12.75S1029.07,5,999.66,5s-29.42,12.75-58.84,12.75S911.41,5,882,5s-29.41,12.75-58.83,12.75S793.74,5,764.33,5,734.91,17.75,705.5,17.75,676.08,5,646.67,5s-29.42,12.75-58.84,12.75S558.42,5,529,5s-29.41,12.75-58.83,12.75S440.76,5,411.34,5s-29.41,12.75-58.83,12.75S323.1,5,293.68,5s-29.42,12.75-58.83,12.75S205.43,5,176,5,146.6,17.75,117.19,17.75,87.77,5,58.36,5C29.11,5,28.93,17.61,0,17.74V50H2000Z" transform="translate(0 -5)"></path></svg></div>

    <section class="testimonials" id="testimonials">
        <h1>What Our Clients Say</h1>
        <div class="testimonials-container">
            <div class="testimonial-box">
                <i class="fas fa-quote-left"></i>
                <p>"NASMY's personalized approach and unbiased insights were invaluable in my search process. Highly recommended!"</p>
                <div class="user-info">
                    <img src="user1.webp" alt="User 1">
                    <div>
                        <h3>John Doe</h3>
                        <p>Software Engineer</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-box">
                <i class="fas fa-quote-left"></i>
                <p>"I couldn't have navigated the application process without the guidance and support from the NASMY team. They were amazing!"</p>
                <div class="user-info">
                    <img src="user2.webp" alt="User 2">
                    <div>
                        <h3>Jane Smith</h3>
                        <p>Business Analyst</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="nothin"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2000 45"><path d="M2000,17.26a2.6,2.6,0,0,1-.4.49C1970.2,16.56,1970.41,5,1941,5s-29.42,12.75-58.84,12.75S1852.73,5,1823.31,5s-29.42,12.75-58.83,12.75S1735.06,5,1705.64,5s-29.41,12.75-58.83,12.75S1617.39,5,1588,5s-29.41,12.75-58.83,12.75S1499.72,5,1470.3,5s-29.41,12.75-58.83,12.75S1382.05,5,1352.64,5s-29.42,12.75-58.83,12.75S1264.39,5,1235,5s-29.42,12.75-58.83,12.75S1146.73,5,1117.32,5s-29.42,12.75-58.83,12.75S1029.07,5,999.66,5s-29.42,12.75-58.84,12.75S911.41,5,882,5s-29.41,12.75-58.83,12.75S793.74,5,764.33,5,734.91,17.75,705.5,17.75,676.08,5,646.67,5s-29.42,12.75-58.84,12.75S558.42,5,529,5s-29.41,12.75-58.83,12.75S440.76,5,411.34,5s-29.41,12.75-58.83,12.75S323.1,5,293.68,5s-29.42,12.75-58.83,12.75S205.43,5,176,5,146.6,17.75,117.19,17.75,87.77,5,58.36,5C29.11,5,28.93,17.61,0,17.74V50H2000Z" transform="translate(0 -5)"></path></svg></div>

    

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

    <script src="script.js"></script>
    <script>
        function showTeacherLogin() {
           
        window.location.href = "professor/professor.php";
        }
        

        function showStudentLogin() {
            // Show the student login page
            window.location.href = "student/student.php";
        }

        function showAdminLogin() {
            // Show the admin login page
            window.location.href = "admin/admin.php";
        }
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>

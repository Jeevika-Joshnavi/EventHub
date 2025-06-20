<?php
session_start();
if (!isset($_SESSION['email'])){
    header('Location: admin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - EventHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #060b20 0%, #490e85 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-links a:hover, .nav-links a.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .center-boxes {
            display: flex;
            gap: 4rem;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .user-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            padding: 3rem 2rem;
            text-align: center;
            min-width: 250px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-box:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .user-box a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            display: block;
        }

        .user-box-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .user-box-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            margin-top: 1rem;
            line-height: 1.5;
        }

        /* Footer */
        footer {
            background: #000;
            color: white;
            padding: 2rem 0;
            text-align: center;
            border-top: 1px solid #333;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 3rem;
            list-style: none;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .center-boxes {
                flex-direction: column;
                gap: 2rem;
            }
            
            .user-box {
                min-width: 200px;
                padding: 2rem 1.5rem;
            }
            
            .user-box a {
                font-size: 1.3rem;
            }
            
            .user-box-icon {
                font-size: 2.5rem;
            }
            
            .nav-links {
                gap: 1rem;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">EventHub</div>
            <ul class="nav-links">
                <li><a href="mainpage.php" onclick="handleHomeClick()">Home</a></li>
                <li><a href="#" class="active" onclick="scrollToTop()">User</a></li>
                <li><a href="admin.php" onclick="handleAdminClick()">Admin</a></li>
                <li> <a href="mainpage.php" onclick="handleLogout()"> Logout </a> <li>
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <div class="center-boxes">
            <div class="user-box" onclick="handleRegisterEventClick()">
                <div class="user-box-icon">🎫</div>
                <a href="#">Register Event</a>
                <p class="user-box-description">Browse and register for exciting events in your area</p>
            </div>
            
            <div class="user-box" onclick="handleViewYourEventsClick()">
                <div class="user-box-icon">📅</div>
                <a href="#">View Your Events</a>
                <p class="user-box-description">Manage your registered events and view event details</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <ul class="footer-links">
                <li><a href="mainpage.php" onclick="handleHomeClick()">Home</a></li>
                <li><a href="mainpage.php" onclick="scrollToAbout()">About Us</a></li>
                <li><a href="user.php" onclick="handleUserClick()">User</a></li>
                <li><a href="admin.php" onclick="handleAdminClick()">Admin</a></li>
            </ul>
            <p class="footer-text">© 2024 EventHub. All rights reserved. Bringing you the best events in the city.</p>
        </div>
    </footer>

    <script>
        // Navigation functions
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function scrollToAbout() {
            window.location.href = 'mainpage.php#about';
        }
        function handleHomeClick() {
            window.location.href = 'mainpage.php';
        }
        function handleUserClick() {
            scrollToTop();
        }

        function handleAdminClick() {
            window.location.href = 'admin.php';
        }

        function handleRegisterEventClick() {
            window.location.href = 'register-event.php';
        }

        function handleViewYourEventsClick() {
            window.location.href = 'your-events.php';
        }
        function handleLogout(){
            window.location.href='mainpage.php';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const boxes = document.querySelectorAll('.user-box');
            
            boxes.forEach(box => {
                box.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                box.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
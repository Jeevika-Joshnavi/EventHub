<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        /* Carousel Container */
        .carousel-container {
            width: 100%;
            height: calc(100vh - 80px); 
            margin: 0;
            padding: 0;
        }

        .carousel {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            width: 400%;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .carousel-slide {
            width: 25%;
            height: 85%;
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: end;
        }

        .slide-content {
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 3rem 2rem 2rem;
            width: 100%;
        }

        .slide-title {
            font-size: 3rem;
            color: white;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .slide-description {
            font-size: 1.3rem;
            opacity: 0.9;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Navigation Arrows */
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .carousel-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .prev-btn {
            left: 30px;
        }

        .next-btn {
            right: 30px;
        }

        /* About Us Section */
        .about-section {
            padding: 3rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .about-title {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            font-weight: bold;
        }

        .about-description {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Footer */
        footer {
            background: #000;
            color: white;
            padding: 2rem 0;
            text-align: center;
            border-top: 1px solid #333;
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
            .slide-title {
                font-size: 2rem;
            }  
            .slide-description {
                font-size: 1.1rem;
            }
            .nav-links {
                gap: 1rem;
            }
            nav {
                padding: 0 1rem;
            }
            .carousel-btn {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            .prev-btn {
                left: 15px;
            }
            .next-btn {
                right: 15px;
            }
            .about-section {
                padding: 2rem 1rem;
            }
            .about-title {
                font-size: 2rem;
            }
            .about-description {
                font-size: 1rem;
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
                <li><a href="#" class="active" onclick="scrollToTop()">Home</a></li>
                <li><a href="user.php" onclick="handleUserClick()">User</a></li>
                <li><a href="admin.php" onclick="handleAdminClick()">Admin</a></li>
            </ul>
        </nav>
    </header>

    <!-- Carousel Section -->
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-track" id="carouselTrack">
                
                <div class="carousel-slide" style="background-image: url('concert.jpg');">
                    <div class="slide-content">
                        <h2 class="slide-title">Concerts</h2>
                        <p class="slide-description">Experience electrifying performances by top artists in an unforgettable night of music</p>
                    </div>
                </div>
                
                <div class="carousel-slide" style="background-image: url('screening.jpg');">
                    <div class="slide-content">
                        <h2 class="slide-title">Screenings</h2>
                        <p class="slide-description">Experience captivating films and thought-provoking documentaries on the big screen</p>
                    </div>
                </div>

                <div class="carousel-slide" style="background-image: url('standup.jpg');">
                    <div class="slide-content">
                        <h2 class="slide-title">Stand-up Comedy</h2>
                        <p class="slide-description">Laugh out loud with hilarious performances by renowned comedians every weekend</p>
                    </div>
                </div>

                <div class="carousel-slide" style="background-image: url('workshop.jpg');">
                    <div class="slide-content">
                        <h2 class="slide-title">Art Workshops</h2>
                        <p class="slide-description">Unleash your creativity with hands-on art sessions led by talented artists</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="carousel-btn prev-btn" onclick="prevSlide()">❮</button>
            <button class="carousel-btn next-btn" onclick="nextSlide()">❯</button>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="about-section">
        <h2 class="about-title">Why EventHub?</h2>
        <p class="about-description">
            At EventHub, we believe in creating unforgettable experiences that bring people together. 
            Whether you're seeking the thrill of live music, the magic of cinema, the joy of laughter, 
            or the satisfaction of creative expression, we curate the finest events in the city. 
            Our platform connects passionate artists with enthusiastic audiences, fostering a vibrant 
            community where culture thrives and memories are made. Join us in celebrating the arts, 
            entertainment, and the power of shared experiences.
        </p>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <ul class="footer-links">
                <li><a href="mainpage.html" onclick="scrollToTop()">Home</a></li>
                <li><a href="#" onclick="scrollToAbout()">About Us</a></li>
                <li><a href="user.php" onclick="handleUserClick()">User</a></li>
                <li><a href="admin.php" onclick="handleAdminClick()">Admin</a></li>
            </ul>
            <p class="footer-text">© 2024 EventHub. All rights reserved. Bringing you the best events in the city.</p>
        </div>
    </footer>

    
</div>
<script>
     let currentSlideIndex = 0;
        const totalSlides = 4;
        const track = document.getElementById('carouselTrack');
        let autoSlideInterval;

        // Move to specific slide
        function goToSlide(index) {
            currentSlideIndex = index;
            const translateX = -index * 25; // 25% per slide (100% / 4 slides)
            track.style.transform = `translateX(${translateX}%)`;
        }

        // Next slide
        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
            goToSlide(currentSlideIndex);
        }

        // Previous slide
        function prevSlide() {
            currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlideIndex);
        }

        // Auto-slide functionality
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 4000); 
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Start auto-slide when page loads
        startAutoSlide();

        // Pause auto-slide on hover
        const carousel = document.querySelector('.carousel');
        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        // Touch/swipe support for mobile
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            stopAutoSlide();
        });

        carousel.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', () => {
            if (!isDragging) return;
            isDragging = false;
            
            const diffX = startX - currentX;
            if (Math.abs(diffX) > 50) { 
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            startAutoSlide();
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });

        // Navigation functions
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function scrollToAbout() {
            document.querySelector('.about-section').scrollIntoView({ behavior: 'smooth' });
        }

        function handleUserClick() {
            window.location.href = 'User.html';
        }

        function handleAdminClick() {
             window.location.href = 'Admin.html';
        }
</script>
</body>
</html>
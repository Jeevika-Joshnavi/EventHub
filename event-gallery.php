<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Album - EventHub</title>
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
            color: white;
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

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-title {
            text-align: center;
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 3rem;
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-color: transparent;
            transform: translateY(-2px);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .gallery-image {
            width: 100%;
            height: 250px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 2rem 1.5rem 1.5rem;
            color: white;
        }

        .gallery-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .gallery-description {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
        }

        .gallery-date {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Modal for enlarged view */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
        }

        .modal-content {
            position: relative;
            margin: 5% auto;
            max-width: 90%;
            max-height: 80%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1;
            background: rgba(0, 0, 0, 0.5);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .back-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            .page-title {
                font-size: 2rem;
            }
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
            .filter-buttons {
                gap: 0.5rem;
            }
            .filter-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .nav-links {
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
                <li><a href="mainpage.php">Home</a></li>
                <li><a href="user.php">User</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="#" class="active">Event Album</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-container">
        <h1 class="page-title">Event Album</h1>
        <p class="page-subtitle">Spectacular moments from our incredible events in partnership with EventHub</p>

        <div class="filter-buttons">
            <button class="filter-btn active" onclick="filterEvents('all')">All Events</button>
            <button class="filter-btn" onclick="filterEvents('concerts')">Concerts</button>
            <button class="filter-btn" onclick="filterEvents('screenings')">Screenings</button>
            <button class="filter-btn" onclick="filterEvents('comedy')">Comedy Shows</button>
            <button class="filter-btn" onclick="filterEvents('workshops')">Workshops</button>
        </div>

        <div class="gallery-grid" id="galleryGrid">
        
            <div class="gallery-item" data-category="concerts" onclick="openModal('concert1.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/rock.jpg');">
                    <div class="gallery-date">Dec 15, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Rock Night Spectacular</h3>
                        <p class="gallery-description">An electrifying evening with top rock bands that had the crowd singing along all night.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="concerts" onclick="openModal('concert2.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/jazz.jpg');">
                    <div class="gallery-date">Nov 28, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Jazz & Blues Evening</h3>
                        <p class="gallery-description">Soulful melodies and smooth rhythms created an unforgettable musical experience.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="screenings" onclick="openModal('screening1.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/filmfest.jpg');">
                    <div class="gallery-date">Dec 8, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Independent Film Festival</h3>
                        <p class="gallery-description">A showcase of brilliant independent films that captivated audiences with their storytelling.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="screenings" onclick="openModal('screening2.jpg')">
                <div class="gallery-image" style="background-image: url('https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=500');">
                    <div class="gallery-date">Nov 22, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Classic Movie Night</h3>
                        <p class="gallery-description">Revisiting timeless classics on the big screen with fellow movie enthusiasts.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="comedy" onclick="openModal('comedy1.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/standupgala.jpg');">
                    <div class="gallery-date">Dec 3, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Stand-Up Comedy Gala</h3>
                        <p class="gallery-description">Hilarious performances by top comedians that had everyone in stitches all evening.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="comedy" onclick="openModal('comedy2.jpg')">
                <div class="gallery-image" style="background-image: url('https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=500');">
                    <div class="gallery-date">Nov 18, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Open Mic Comedy Night</h3>
                        <p class="gallery-description">Fresh talent showcased their comedic skills in an intimate and entertaining setting.</p>
                    </div>
                </div>
            </div>

    
            <div class="gallery-item" data-category="workshops" onclick="openModal('workshop1.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/painting.jpg');">
                    <div class="gallery-date">Dec 12, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Painting Workshop</h3>
                        <p class="gallery-description">Creative minds came together to explore colors and techniques in a relaxing atmosphere.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="workshops" onclick="openModal('workshop2.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/photograph.jpg');">
                    <div class="gallery-date">Nov 25, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Photography Masterclass</h3>
                        <p class="gallery-description">Professional photographers shared their expertise in capturing perfect moments.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="concerts" onclick="openModal('concert3.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/electronic.jpg');">
                    <div class="gallery-date">Oct 30, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Electronic Music Festival</h3>
                        <p class="gallery-description">High-energy electronic beats kept the dance floor packed until dawn.</p>
                    </div>
                </div>
            </div>

            <div class="gallery-item" data-category="workshops" onclick="openModal('workshop3.jpg')">
                <div class="gallery-image" style="background-image: url('albumpics/pottery.jpg');">
                    <div class="gallery-date">Oct 15, 2024</div>
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">Pottery & Ceramics</h3>
                        <p class="gallery-description">Hands-on experience with clay work guided by skilled ceramic artists.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for enlarged images -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <button class="back-btn" onclick="goHome()">← Back to Home</button>

    <script>
        function filterEvents(category) {
            const items = document.querySelectorAll('.gallery-item');
            const buttons = document.querySelectorAll('.filter-btn');
          
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 100);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        }

        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImg.src = event.target.closest('.gallery-item').querySelector('.gallery-image').style.backgroundImage.slice(5, -2);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Navigation functions
        function goHome() {
            window.location.href = 'mainpage.php';
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Animation on scroll
        function animateOnScroll() {
            const items = document.querySelectorAll('.gallery-item');
            items.forEach(item => {
                const rect = item.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                
                if (isVisible) {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialize animations
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('.gallery-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                item.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime World - Home</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1c1c1e;
            color: #fff;
            overflow-x: hidden;
            animation: fadeInBody 1s ease-in-out;
        }

        /* Light Mode Styles */
        body.light-mode {
            background-color: #f0f0f0;
            color: #333;
        }

        .light-mode .header {
            background-color: #fff;
            color: #ff66c4;
        }

        .light-mode .anime-card {
            background-color: #fff;
            color: #333;
        }

        .light-mode .anime-title {
            color: #ff66c4;
        }

        .light-mode .watch-btn {
            background: linear-gradient(45deg, #ff66c4, #ff4d6d);
            color: #fff;
        }

        /* Fade-in animation for the body */
        @keyframes fadeInBody {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Header Styles */
        .header {
            background-color: #333;
            padding: 20px;
            text-align: center;
            font-size: 2em;
            color: #ff66c4;
            letter-spacing: 2px;
            text-shadow: 0 4px 8px rgba(255, 102, 196, 0.4);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background-color 0.3s ease;
        }

        .header:hover {
            background-color: #444;
        }

        /* Search Bar Styles */
        #search-bar {
            padding: 10px;
            border: 2px solid #ff66c4;
            border-radius: 20px;
            background-color: transparent;
            color: #fff;
            margin-left: 20px;
            width: 200px;
            transition: width 0.3s;
        }

        #search-bar:focus {
            width: 300px;
            outline: none;
            border-color: #ffeb3b;
        }

        /* Video Banner Styles */
        .banner {
            position: relative;
            height: 400px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffeb3b;
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 5px #000;
            animation: bannerFadeIn 1s ease-in-out;
        }

        .banner video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        /* Banner Animation */
        @keyframes bannerFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Anime Grid */
        .anime-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 50px 5%;
            animation: fadeInGrid 1s ease-in-out;
        }

        /* Grid fade-in animation */
        @keyframes fadeInGrid {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Anime Card Styles */
        .anime-card {
            position: relative;
            background-color: #2a2a2e;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .anime-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 20px rgba(255, 102, 196, 0.4);
        }

        /* Video Wrapper (Hidden by default) */
        .anime-card .video-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
        }

        /* Video element */
        .anime-card .hover-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Show video on hover */
        .anime-card:hover .video-wrapper {
            display: block;
        }

        /* Hide the thumbnail on hover */
        .anime-card:hover .anime-thumbnail {
            display: none;
        }

        /* Anime Thumbnail Styles */
        .anime-card .anime-thumbnail {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-bottom: 3px solid #ff66c4;
        }

        /* Anime Info and Button */
        .anime-info {
            padding: 15px;
            text-align: center;
        }

        .anime-title {
            font-size: 1.4em;
            color: #ff66c4;
            margin: 0;
            transition: color 0.3s;
        }
        .anime-card:hover .anime-title {
            color: #ffeb3b;
        }

        /* Watch Button Styles */
        .watch-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 28px;
            background: linear-gradient(45deg, #ff66c4, #ff4d6d);
            color: #fff;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
            box-shadow: 0px 4px 10px rgba(255, 0, 93, 0.2);
        }

        .watch-btn:hover {
            transform: scale(1.1);
            background: linear-gradient(45deg, #ff1a4e, #ff66c4);
            box-shadow: 0px 6px 15px rgba(255, 0, 93, 0.4);
        }

        /* Favorite Button Styles */
        .favorite-btn {
            background: none;
            border: none;
            color: #ff66c4;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.3s, color 0.3s;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
            color: #ffeb3b;
        }

        /* Logout Button Styles */
        .logout-btn {
            color: #ff66c4;
            font-size: 0.8em;
            font-weight: bold;
            padding: 10px 20px;
            background-color: transparent;
            border: 2px solid #ff66c4;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 20px;
            float: right;
            margin-top: -5px;
        }

        .logout-btn:hover {
            background-color: #ff66c4;
            color: #333;
        }

        /* Lightbox Styles */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .lightbox-content {
            background-color: #2a2a2e;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            width: 90%;
            text-align: center;
        }

        .lightbox video {
            width: 100%;
            border-radius: 10px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #ff66c4;
            font-size: 2em;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #ffeb3b;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        Anime World
        <button id="theme-toggle">🌙</button>
        <input type="text" id="search-bar" placeholder="Search anime...">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Video Banner Section -->
    <div class="banner">
        <video autoplay muted loop>
            <source src="win.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        Welcome to Anime World
    </div>

    <!-- Anime Grid Section -->
    <div class="anime-grid">
        <!-- Sample Anime Cards -->
        <div class="anime-card">
            <div class="video-wrapper">
                <video class="hover-video" autoplay muted loop>
                    <source src="videos\Tanjiro Vs Rui - Full Fight Scene _ Demon Slayer (CLIP 4K).mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <img class="anime-thumbnail" src="1331191.png" alt="Anime Thumbnail">
            <div class="anime-info">
                <h3 class="anime-title">Demon Slayer: Kimetsu no Yaiba</h3>
                <button class="favorite-btn">❤️ Add to Favorites</button>
                <a href="video.php?id=1" class="watch-btn">Watch Now</a>
            </div>
        </div>

        <div class="anime-card">
            <div class="video-wrapper">
                <video class="hover-video" autoplay muted loop>
                    <source src="videos\1731602954.5880451_ytshorts.savetube.me.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <img class="anime-thumbnail" src="jujutsu-kaisen-3840x2160-9277.jpg" alt="Anime Thumbnail">
            <div class="anime-info">
                <h3 class="anime-title">Jujutsu Kaisen</h3>
                <button class="favorite-btn">❤️ Add to Favorites</button>
                <a href="video.php?id=2" class="watch-btn">Watch Now</a>
            </div>
        </div>

        <div class="anime-card">
            <div class="video-wrapper">
                <video class="hover-video" autoplay muted loop>
                    <source src="videos\1731602755.4749959_ytshorts.savetube.me.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <img class="anime-thumbnail" src="dan-da-dan.jpg" alt="Anime Thumbnail">
            <div class="anime-info">
                <h3 class="anime-title">Dandadan</h3>
                <button class="favorite-btn">❤️ Add to Favorites</button>
                <a href="video.php?id=3" class="watch-btn">Watch Now</a>
            </div>
        </div>

        <div class="anime-card">
            <div class="video-wrapper">
                <video class="hover-video" autoplay muted loop>
                    <source src="videos\1731602605.1042154_ytshorts.savetube.me.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <img class="anime-thumbnail" src="goku.jpg" alt="Anime Thumbnail">
            <div class="anime-info">
                <h3 class="anime-title">Dragon Ball DAIMA</h3>
                <button class="favorite-btn">❤️ Add to Favorites</button>
                <a href="video.php?id=4" class="watch-btn">Watch Now</a>
            </div>
        </div>
    </div>

    <!-- Lightbox Container -->
    <div id="lightbox" class="lightbox">
        <span class="close-btn">&times;</span>
        <div class="lightbox-content">
            <video id="lightbox-video" controls autoplay muted loop>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <h2 id="lightbox-title"></h2>
            <p id="lightbox-description"></p>
        </div>
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
        // Lightbox functionality
        const lightbox = document.getElementById('lightbox');
        const lightboxVideo = document.getElementById('lightbox-video');
        const lightboxTitle = document.getElementById('lightbox-title');
        const closeBtn = document.querySelector('.close-btn');

        // Open lightbox when an anime card is clicked
        document.querySelectorAll('.anime-card').forEach(card => {
            card.addEventListener('click', () => {
                const videoSrc = card.querySelector('.hover-video source').src;
                const title = card.querySelector('.anime-title').textContent;

                lightboxVideo.src = videoSrc;
                lightboxTitle.textContent = title;
                lightbox.style.display = 'flex';
            });
        });

        // Close lightbox
        closeBtn.addEventListener('click', () => {
            lightbox.style.display = 'none';
            lightboxVideo.pause();
        });

        // Close lightbox when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                lightbox.style.display = 'none';
                lightboxVideo.pause();
            }
        });

        // Search functionality
        const searchBar = document.getElementById('search-bar');
        const animeCards = document.querySelectorAll('.anime-card');

        searchBar.addEventListener('input', () => {
            const searchTerm = searchBar.value.toLowerCase();

            animeCards.forEach(card => {
                const title = card.querySelector('.anime-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Favorites functionality
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.textContent = button.textContent.includes('Add') ? '❤️ Added to Favorites' : '❤️ Add to Favorites';
            });
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            themeToggle.textContent = body.classList.contains('light-mode') ? '🌞' : '🌙';
        });
    </script>
</body>
</html>
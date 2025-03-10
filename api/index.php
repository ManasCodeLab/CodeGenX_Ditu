<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeGenX - DIT University's Premier Technical Club</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script src="script.js"></script>
</head>
<body>
    <section class="hero" id="home">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="https://raw.githubusercontent.com/ManasCodeLab/CodeGenX/refs/heads/main/assets/code-bg.mp4" type="video/mp4">
        </video>
        <div class="hero-content">
            <h1>CodeGenX</h1>
            <p class="hero-subtitle">DIT University's Technical Community Since 2012</p>
            <div class="cta-buttons" style="margin-top: 2rem;">
                <a href="#contact"><button class="btn-primary">Join Now</button></a>
                <a href="#events"><button class="btn-primary">Upcoming Events</button></a>
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <h2 class="section-title">About Us</h2>
        <div class="about-content">
            <div class="history">
                <h3>Pioneering Tech Education Since 2012</h3>
                <p>Founded in 2012, CodeGenX has been at the forefront of fostering technical innovation at DIT University...</p>
            </div>
            <div class="mission">
                <h3>Our Mission</h3>
                <p>Empowering students to transform ideas into technological solutions through collaborative learning and innovation.</p>
            </div>
        </div>
    </section>
    <?php 
    include 'leader.php';
    include 'events.php'; 
    ?>
    
    <section class="section" id="blog">
        <h2 class="section-title">Latest Posts</h2>
        <div class="blog-grid">
            <div class="instagram-card">
                <div class="instagram-header">
                    <i class="fab fa-instagram"></i>
                    <h3>Follow Our Journey</h3>
                </div>
                <p>See event highlights and behind-the-scenes:</p>
                <a href="https://instagram.com/codegenx_ditu" target="_blank" class="instagram-handle">@codegenx_ditu</a>
                <div class="event-highlights">
                    <span>Live Updates</span>
                    <span>Winner Stories</span>
                    <span>Event Archives</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <h2 class="section-title">Get in Touch</h2>
        <div class="contact-container">
            <form id="contactForm" class="contact-form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                
                <div class="form-group">
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                </div>
                
                <button type="submit" class="btn-primary">Send Message</button>
            </form>
            
            <div id="responseMessage"></div>
            <div class="social-links">
                <a href="https://instagram.com/codegenx_ditu" class="social-icon" target="_blank" rel="noopener">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://in.linkedin.com/company/codegenx-ditu" class="social-icon" target="_blank" rel="noopener">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="social-icon" target="_blank" rel="noopener">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
<header>
  <nav class="navbar">
    <div class="logo-container">
      <a href="index.php">
        <img src="https://github.com/ManasCodeLab/CodeGenX/blob/main/assets/logo.png?raw=true" alt="CodeGenX Logo" class="logo">
      </a>
    </div>
    <div class="menu-toggle" id="mobile-menu" aria-label="Toggle navigation menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <ul class="nav-menu" id="nav-menu">
      <li><a href="../index.php" aria-label="Home">Home</a></li>
      <li><a href="../index.php#about" aria-label="About">About</a></li>
      <li><a href="../team.php" aria-label="Our Team">Team</a></li>
      <li><a href="../index.php#events" aria-label="Events">Events</a></li>
      <li><a href="../index.php#blog" aria-label="Blog">Blog</a></li>
      <li><a href="../index.php#contact" aria-label="Contact">Contact</a></li>
    </ul>
  </nav>
</header>

<script>
  // Add mobile menu toggle functionality
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');
    
    mobileMenu.addEventListener('click', function() {
      navMenu.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
  });
</script>
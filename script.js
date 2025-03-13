document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(target) {
                window.scrollTo({
                    top: target.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Contact Form
    const contactForm = document.getElementById('contactForm');
    if(contactForm) {
        // Fetch CSRF token from server
        const getCsrfToken = async () => {
            try {
                const response = await fetch('https://codegenx-ditu.vercel.app/contact.php', {
                    method: 'GET',
                    credentials: 'include'
                });
                return await response.json();
            } catch (error) {
                console.error('CSRF token fetch failed:', error);
                return { csrf_token: '' };
            }
        };

        // Initialize form with CSRF token
        (async () => {
            const { csrf_token } = await getCsrfToken();
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = 'csrf_token';
            tokenInput.value = csrf_token;
            contactForm.appendChild(tokenInput);
        })();

        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = contactForm.querySelector('button');
            const responseDiv = document.getElementById('responseMessage');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner"></span>
                Sending...
            `;

            try {
                // Get fresh CSRF token
                const { csrf_token } = await getCsrfToken();
                contactForm.querySelector('input[name="csrf_token"]').value = csrf_token;

                const formData = new FormData(contactForm);
                const response = await fetch('https://code.manas.eu.org/contact.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(Object.fromEntries(formData)),
                    credentials: 'include'
                });

                const result = await response.json();
                
                responseDiv.textContent = result.message;
                responseDiv.className = result.success ? 'success' : 'error';
                
                if(result.success) {
                    contactForm.reset();
                    setTimeout(() => {
                        responseDiv.textContent = '';
                        responseDiv.className = '';
                    }, 5000);
                }

            } catch (error) {
                responseDiv.textContent = 'Network error - please try again later';
                responseDiv.className = 'error';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Message';
            }
        });
    }

    // Auto-hide messages
    setInterval(() => {
        const messages = document.querySelectorAll('.success, .error');
        messages.forEach(msg => {
            if(Date.now() - msg.timestamp > 5000) {
                msg.remove();
            }
        });
    }, 1000);
});


// In your mobile menu JavaScript
document.querySelector('.menu-toggle').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('active');
})

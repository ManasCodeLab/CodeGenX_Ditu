<?php
include '../header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://code.manas.eu.org/assets/style.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden; /* Prevent scrollbar */
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100vh;
            background: var(--dark);
        }

        .hero-content {
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            color: #fff;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="hero-content">
            <h1>404</h1>
            <p>Page Not Found</p>
            <p>Sorry, the page you are looking for does not exist.</p>
            <div class="cta-buttons" style="margin-top: 2rem;">
                <a href="https://code.manas.eu.org/index.php"><button class="btn-primary">Go to Home</button></a>
            </div>
        </div>
    </section>

<?php
include '../footer.php';
?>
</body>
</html>
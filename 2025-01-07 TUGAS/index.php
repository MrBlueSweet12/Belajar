<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RestoranGacor - Delicious Food Delivered to Your Doorstep">
    <title>RestoranGacor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #343a40;
            line-height: 1.6;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            padding: 1rem 0;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        header h1 {
            font-size: 1.5rem;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffc107;
        }

        .hero {
            text-align: center;
            padding: 4rem 1rem;
            background: url('images/hero.jpg') no-repeat center center/cover;
            color: #ffffff;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #343a40;
        }

        .hero .btn {
            padding: 0.75rem 1.5rem;
            background-color: #ffc107;
            color: #343a40;
            text-decoration: none;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .hero .btn:hover {
            background-color: #e0a800;
        }

        .features, .menu-preview {
            padding: 2rem 1rem;
        }

        .features h3, .menu-preview h3 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.75rem;
        }

        .feature-item {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            padding: 1rem 0;
        }

        .menu-preview .menu-item {
            display: inline-block;
            text-align: center;
            margin: 1rem;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .menu-preview .menu-item img {
            width: 100%;
            height: auto;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .menu-preview .menu-item h4 {
            margin: 0.5rem 0;
            font-size: 1.25rem;
        }

        .menu-preview .menu-item p {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .menu-preview .btn {
            display: block;
            width: fit-content;
            margin: 2rem auto 0;
            padding: 0.75rem 1.5rem;
            background-color: #ffc107;
            color: #343a40;
            text-decoration: none;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .menu-preview .btn:hover {
            background-color: #e0a800;
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>RestoranGacor</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="hero">
            <h2>Delicious Food Delivered to Your Doorstep</h2>
            <a href="menu.php" class="btn">Order Now</a>
        </div>

        <section class="features">
            <div class="container">
                <h3>Why Choose Us?</h3>
                <div class="feature-item">
                    <h4>Fresh Ingredients</h4>
                    <p>We use only the freshest ingredients to prepare your meals.</p>
                </div>
                <div class="feature-item">
                    <h4>Fast Delivery</h4>
                    <p>Get your food delivered hot and fresh in no time.</p>
                </div>
                <div class="feature-item">
                    <h4>Variety of Choices</h4>
                    <p>Explore a wide range of delicious dishes.</p>
                </div>
            </div>
        </section>

        <section class="menu-preview">
            <div class="container">
                <h3>Our Menu</h3>
                <div class="menu-item">
                    <img src="images/pizza.jpg" alt="Pizza - Delicious and freshly baked">
                    <h4>Pizza</h4>
                    <p>$10.00</p>
                </div>
                <div class="menu-item">
                    <img src="images/burger.jpg" alt="Burger - Juicy and flavorful">
                    <h4>Burger</h4>
                    <p>$8.00</p>
                </div>
                <div class="menu-item">
                    <img src="images/pasta.jpg" alt="Pasta - Creamy and delightful">
                    <h4>Pasta</h4>
                    <p>$5.00</p>
                </div>
                <div class="menu-item">
                    <img src="images/steak.jpg" alt="Steak - Tender and perfectly cooked">
                    <h4>Steak</h4>
                    <p>$20.00</p>
                </div>
                <div class="menu-item">
                    <img src="images/soup.jpg" alt="Soup - Warm and comforting">
                    <h4>Soup</h4>
                    <p>$6.00</p>
                </div>
                <a href="menu.php" class="btn">View Full Menu</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 RestoranGacor. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

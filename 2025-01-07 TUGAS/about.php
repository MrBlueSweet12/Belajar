<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - RestoranGacor</title>
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
        }

        .about-section {
            text-align: center;
            padding: 4rem 1rem;
            background-color: #ffffff;
        }

        .about-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .about-section p {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }

        .about-values {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 2rem 1rem;
            background-color: #f8f9fa;
        }

        .value-item {
            flex: 1 1 300px;
            margin: 1rem;
            padding: 1.5rem;
            text-align: center;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .value-item h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .value-item p {
            font-size: 1rem;
            line-height: 1.6;
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
                    <li><a href="cart.php">Cart <span id="cart-total"></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="about-section">
            <h2>About RestoranGacor</h2>
            <p>At RestoranGacor, we believe that great food brings people together. Established in 2025, our mission is to serve delicious, high-quality meals made from the freshest ingredients. Whether you’re dining in or enjoying our food from the comfort of your home, we strive to deliver an exceptional culinary experience every time.</p>
            <p>Our team of passionate chefs and dedicated staff work tirelessly to create a menu that caters to diverse tastes and preferences. From classic comfort food to innovative new dishes, RestoranGacor is the perfect place for food lovers of all kinds.</p>
        </section>

        <section class="about-values">
            <div class="value-item">
                <h3>Our Mission</h3>
                <p>To provide a memorable dining experience with high-quality food, excellent service, and a welcoming atmosphere.</p>
            </div>
            <div class="value-item">
                <h3>Our Vision</h3>
                <p>To be the leading choice for food enthusiasts by consistently delivering outstanding meals and fostering a sense of community.</p>
            </div>
            <div class="value-item">
                <h3>Our Values</h3>
                <p>Quality, innovation, and customer satisfaction are at the heart of everything we do.</p>
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

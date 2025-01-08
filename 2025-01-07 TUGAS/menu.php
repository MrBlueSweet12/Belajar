<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - RestoranGacor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

.menu-section {
    padding: 2rem 1rem;
    text-align: center;
}

.menu-items {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
}

.menu-item {
    width: 250px;
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
}

.menu-item img {
    width: 100%; /* Gunakan lebar penuh dari container */
    height: 200px; /* Tetapkan tinggi gambar */
    object-fit: cover; /* Pangkas gambar agar sesuai dengan dimensi */
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}


.menu-item h4 {
    margin: 0.5rem 0;
    font-size: 1.25rem;
}

.menu-item p {
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.add-to-cart {
    padding: 0.75rem 1.5rem;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart:hover {
    background: #218838;
}

footer {
    background-color: #343a40;
    color: #ffffff;
    text-align: center;
    padding: 1rem 0;
}

#cart-message {
    display: none;
    color: green;
    margin-bottom: 1rem;
}

    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Daftar Menu</h1>
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
        <section class="menu-section">
            <div id="cart-message"></div>
            <h2>Our Delicious Menu</h2>
            <div class="menu-items">
                <?php
$menuItems = [
    ['name' => 'Pizza', 'price' => 10, 'image' => 'images/pizza.jpg'],
    ['name' => 'Burger', 'price' => 8, 'image' => 'images/burger.jpg'],
    ['name' => 'Pasta', 'price' => 5, 'image' => 'images/pasta.jpg'],
    ['name' => 'Salad', 'price' => 7, 'image' => 'images/salad.jpg'],
    ['name' => 'Sushi', 'price' => 15, 'image' => 'images/sushi.jpg'],
    ['name' => 'Steak', 'price' => 20, 'image' => 'images/steak.jpg'],
    ['name' => 'Ice Cream', 'price' => 5, 'image' => 'images/icecream.jpg'],
    ['name' => 'Soup', 'price' => 6, 'image' => 'images/soup.jpg'],
    ['name' => 'Fried Chicken', 'price' => 12, 'image' => 'images/friedchicken.jpg'],
    ['name' => 'Tacos', 'price' => 9, 'image' => 'images/tacos.jpg'],
];


                foreach ($menuItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?= $item['image']; ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                        <h3><?= htmlspecialchars($item['name']); ?></h3>
                        <p>$<?= number_format($item['price'], 2); ?></p>
                        <button class="add-to-cart" data-name="<?= htmlspecialchars($item['name']); ?>" data-price="<?= htmlspecialchars($item['price']); ?>">Add to Cart</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 RestoranGacor. All rights reserved.</p>
        </div>
    </footer>

    <script>
        $(document).ready(function () {
            $('.add-to-cart').on('click', function () {
                const itemName = $(this).data('name');
                const itemPrice = $(this).data('price');

                $.ajax({
                    url: 'add_to_cart.php',
                    type: 'POST',
                    data: { name: itemName, price: itemPrice },
                    success: function (response) {
                        $('#cart-message').text(response).fadeIn().delay(2000).fadeOut();
                        // Update total items
                        $.get('cart.php', function (data) {
                            $('#cart-total').text(data.totalItems);
                        });
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat menambahkan ke keranjang.');
                    }
                });
            });
        });
    </script>
</body>
</html>

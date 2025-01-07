<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah item ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filter input POST
    $itemName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $itemPrice = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    if ($itemName && $itemPrice) {
        $item = [
            'name' => $itemName,
            'price' => $itemPrice,
            'quantity' => 1, // Default 1
        ];

        // Periksa apakah item sudah ada di keranjang
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['name'] === $item['name']) {
                $cartItem['quantity']++; // Tambah kuantitas
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item; // Tambahkan item baru
        }

        // Tampilkan pesan sukses
        $_SESSION['message'] = "Item '{$itemName}' berhasil ditambahkan ke keranjang!";
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat menambahkan item ke keranjang.";
    }

    // Redirect kembali ke halaman menu
    header("Location: menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - RestoranGacor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Anda tetap tidak berubah */
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

        .menu-section {
            padding: 2rem 1rem;
            text-align: center;
        }

        .menu-section h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .menu-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
        }

        .menu-item {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: hidden;
        }

        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .menu-item h3 {
            margin: 1rem 0 0.5rem;
            font-size: 1.5rem;
        }

        .menu-item p {
            margin-bottom: 1rem;
            color: #28a745;
            font-weight: bold;
        }

        .menu-item .btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background-color: #ffc107;
            color: #343a40;
            text-decoration: none;
            font-weight: bold;
            border-radius: 0.5rem;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            margin: 1rem auto;
            max-width: 600px;
            border: 1px solid #c3e6cb;
            border-radius: 0.25rem;
            text-align: center;
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
            <h1>Daftar Menu</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="cart.php">Cart (<?= count($_SESSION['cart']); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="menu-section">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message">
                    <?= $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

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
                ];

                foreach ($menuItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?= $item['image']; ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                        <h3><?= htmlspecialchars($item['name']); ?></h3>
                        <p>$<?= number_format($item['price'], 2); ?></p>
                        <form action="" method="POST">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']); ?>">
                            <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']); ?>">
                            <button type="submit" class="btn">Add to Cart</button>
                        </form>
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
</body>
</html>

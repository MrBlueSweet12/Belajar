<?php
session_start();
require 'db.php'; // File koneksi ke database

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);

    // Detail pesanan
    $orderDetails = json_encode($_SESSION['cart']);
    $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['cart']));

    // Simpan ke database
    try {
        $stmt = $pdo->prepare("
            INSERT INTO orders (name, email, address, phone, order_details, total)
            VALUES (:name, :email, :address, :phone, :order_details, :total)
        ");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':address' => $address,
            ':phone' => $phone,
            ':order_details' => $orderDetails,
            ':total' => $total,
        ]);

        // Kosongkan keranjang setelah checkout
        unset($_SESSION['cart']);

        // Redirect ke halaman sukses
        header("Location: success.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - RestoranGacor</title>
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
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }

        header h1 {
            font-size: 1.5rem;
        }

        main {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .btn {
            background-color: #28a745;
            color: #ffffff;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }

        .summary {
            margin: 1rem 0;
        }

        .summary p {
            font-size: 1.1rem;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Checkout</h1>
        </div>
    </header>

    <main>
        <h2>Billing Information</h2>

        <?php if (!empty($error)) : ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" required></textarea>

            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>

            <div class="summary">
                <h3>Order Summary</h3>
                <?php foreach ($_SESSION['cart'] as $item) : ?>
                    <p><?= htmlspecialchars($item['name']); ?> x <?= htmlspecialchars($item['quantity']); ?> - $<?= number_format($item['price'] * $item['quantity'], 2); ?></p>
                <?php endforeach; ?>
                <p><strong>Total: $<?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['cart'])), 2); ?></strong></p>
            </div>

            <button type="submit" class="btn">Place Order</button>
        </form>
    </main>
</body>
</html>

<?php
session_start();

// Periksa apakah keranjang sudah ada dan tidak kosong
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - RestoranGacor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            padding: 2rem;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 1rem 0;
        }

        header h1 {
            font-size: 1.5rem;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        table th, table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #343a40;
            color: #ffffff;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background-color: #ffc107;
            color: #343a40;
            text-decoration: none;
            font-weight: bold;
            border-radius: 0.5rem;
            text-align: center;
            display: inline-block;
            margin: 0.5rem 0;
        }

        .btn:hover {
            background-color: #e0a800;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 1.25rem;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bersedia Untuk Membayar?</h1>
    </header>
    <div class="container">
        <h2>Your Cart</h2>
        <?php if (!empty($cart)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $id => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <form method="POST" action="update_cart.php">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width: 60px;">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td><a href="remove_item.php?id=<?= $id ?>" class="btn">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total">Total: $<?= number_format($total, 2) ?></div>
            <a href="checkout.php" class="btn">Checkout</a>
        <?php else: ?>
            <p>Your cart is empty. <a href="menu.php" class="btn">Go to Menu</a></p>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2025 RestoranGacor. All rights reserved.</p>
    </footer>
</body>
</html>

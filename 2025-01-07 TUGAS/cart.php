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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            color: #343a40;
            line-height: 1.6;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #ffc107;
        }

        .container {
            flex: 1;
            max-width: 1000px;
            width: 90%;
            margin: 6rem auto 2rem;
            background: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
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

        .quantity-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-wrapper button {
            background-color: #ffc107;
            border: none;
            color: white;
            font-size: 1.25rem;
            padding: 0.5rem;
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-wrapper button:hover {
            background-color: #e0a800;
        }

        .quantity-wrapper input {
            width: 60px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            text-align: center;
            font-size: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background-color: #ffc107;
            color: #343a40;
            text-decoration: none;
            font-weight: bold;
            border-radius: 0.5rem;
            display: inline-block;
            margin: 0.5rem 0;
            transition: background-color 0.3s;
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
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

        .empty-cart-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 350px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <h1>RestoranGacor</h1>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
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
                            <div class="quantity-wrapper" data-id="<?= $id ?>">
                                <button class="decrease">-</button>
                                <input type="number" value="<?= $item['quantity'] ?>" readonly>
                                <button class="increase">+</button>
                            </div>
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
        <div class="empty-cart-message">
            <p>Your cart is empty. <a href="menu.php" class="btn">Go to Menu</a></p>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 RestoranGacor. All rights reserved.</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.quantity-wrapper').forEach(item => {
            item.querySelector('.increase').addEventListener('click', function() {
                updateQuantity(item, 1);
            });
            item.querySelector('.decrease').addEventListener('click', function() {
                updateQuantity(item, -1);
            });
        });
    });

    function updateQuantity(item, delta) {
        const id = item.getAttribute('data-id');
        const input = item.querySelector('input');
        const currentQuantity = parseInt(input.value);

        if (currentQuantity + delta < 1) return;

        const newQuantity = currentQuantity + delta;
        input.value = newQuantity;

        // Send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Update the subtotal dynamically
                const subtotalCell = item.closest('tr').querySelector('td:nth-child(4)');
                const price = parseFloat(item.closest('tr').querySelector('td:nth-child(2)').textContent.replace('$', ''));
                subtotalCell.textContent = '$' + (price * newQuantity).toFixed(2);

                // Update the total dynamically
                const totalCell = document.querySelector('.total');
                totalCell.textContent = 'Total: $' + calculateTotal();
            }
        };

        xhr.send(`id=${id}&quantity=${newQuantity}`);
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('tr').forEach(row => {
            const quantityInput = row.querySelector('td:nth-child(3) input');
            const priceCell = row.querySelector('td:nth-child(2)');
            if (quantityInput && priceCell) {
                const quantity = parseInt(quantityInput.value);
                const price = parseFloat(priceCell.textContent.replace('$', ''));
                total += price * quantity;
            }
        });
        return total.toFixed(2);
    }
</script>

</body>
</html>

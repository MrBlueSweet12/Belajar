<?php
session_start();

// Periksa apakah parameter 'id' dan 'quantity' dikirim melalui POST
if (isset($_POST['id'], $_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = (int) $_POST['quantity'];

    // Validasi: Pastikan jumlah adalah bilangan positif
    if ($quantity > 0 && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }

    // Redirect kembali ke cart.php
    header("Location: cart.php");
    exit;
}

// Jika data tidak valid, kembali ke cart.php
header("Location: cart.php");
exit;
?>

<?php
session_start();

// Periksa apakah keranjang sudah ada
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Periksa apakah ID item dikirim melalui URL (GET)
if (isset($_GET['id'])) {
    $itemId = intval($_GET['id']); // Validasi ID item menjadi integer

    // Hapus item dari keranjang jika ID-nya ada di sesi
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]);
    }
}

// Redirect kembali ke halaman keranjang
header("Location: cart.php");
exit;
?>

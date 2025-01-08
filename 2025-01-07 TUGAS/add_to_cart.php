<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tangkap data dari AJAX
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

    // Kembalikan pesan sukses ke AJAX
    echo "Item '{$itemName}' berhasil ditambahkan ke keranjang!";
} else {
    echo "Terjadi kesalahan, item tidak valid.";
}

<?php
session_start();

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if ($id && isset($_SESSION['cart'][$id])) {
        $item = $_SESSION['cart'][$id];

        // Update the quantity
        $item['quantity'] = $quantity;
        $_SESSION['cart'][$id] = $item;

        // Respond with success
        echo json_encode(['success' => true]);
    }
}
?>

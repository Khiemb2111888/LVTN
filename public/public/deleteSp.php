<?php
session_start();

if (isset($_GET['product_id'])) {
    $productId = (int) $_GET['product_id'];

    // Xóa sản phẩm khỏi giỏ hàng
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

    // Chuyển hướng trở lại trang giỏ hàng
    header('Location: cart_view.php');
    exit;
}

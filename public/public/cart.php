<?php
session_start();

// Kiểm tra nếu có product_id được gửi
if (isset($_POST['product_id'])) {
    $productId = (int) $_POST['product_id'];

    // Giả sử bạn có giỏ hàng lưu trong session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Thêm sản phẩm vào giỏ hàng
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1; // Số lượng mặc định là 1
    } else {
        $_SESSION['cart'][$productId]++; // Tăng số lượng sản phẩm nếu đã tồn tại trong giỏ
    }

    // Chuyển hướng người dùng đến trang giỏ hàng
    header('Location: product.php');
    exit;
}

// Nếu không có product_id, chuyển hướng trở lại trang sản phẩm
header('Location: product.php');

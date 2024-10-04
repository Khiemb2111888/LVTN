<?php
session_start();

// Kiểm tra nếu form đã gửi và kiểm tra giá trị
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Kiểm tra xem sản phẩm có trong giỏ hàng không
    if (isset($_SESSION['cart'][$productId])) {
        // Cập nhật số lượng
        if ($quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        } else {
            // Nếu số lượng bằng 0 thì xóa sản phẩm khỏi giỏ hàng
            unset($_SESSION['cart'][$productId]);
        }
    }

    // Chuyển hướng lại giỏ hàng
    header('Location: cart_view.php');
    exit();
}

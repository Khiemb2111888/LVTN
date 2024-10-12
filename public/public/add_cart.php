<?php
session_start(); // Bắt đầu session
require_once __DIR__ . '/../src/bootstrap.php'; // Nạp các tệp cần thiết
use CT275\Labs\Product;
// Kiểm tra nếu form đã gửi
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Kiểm tra nếu giỏ hàng (cart) chưa được khởi tạo
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Khởi tạo giỏ hàng như là một mảng rỗng
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$productId])) {
        // Nếu đã có, cộng thêm số lượng
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
        $product = new Product($PDO); // Tạo đối tượng Product
        $productDetails = $product->getProductById($productId); // Lấy thông tin sản phẩm từ CSDL

        if ($productDetails) {
            // Thêm sản phẩm mới vào giỏ hàng
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $productDetails->name, // Lưu tên sản phẩm
                'price' => $productDetails->price, // Lưu giá sản phẩm
                'quantity' => $quantity
            ];
        }
    }

    // Chuyển hướng lại trang chi tiết hoặc giỏ hàng
    header('Location: cart_view.php');
    exit();
}

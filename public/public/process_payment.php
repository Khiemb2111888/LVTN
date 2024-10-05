<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Order;

// Kiểm tra nếu giỏ hàng trống
if (empty($_SESSION['cart'])) {
    header("Location: /public/payment.php");
    exit();
}

// Tạo đối tượng Order
$order = new Order($PDO);

// Thu thập thông tin từ form thanh toán
$name_customer = $_POST['name_customer'];
$address = $_POST['address'];
$total_price = 0;

// Tính tổng giá trị đơn hàng
foreach ($_SESSION['cart'] as $productId => $item) {
    $total_price += $item['price'] * $item['quantity']; // Đảm bảo bạn đã lưu 'price' khi thêm vào giỏ hàng
}

// Thêm đơn hàng vào cơ sở dữ liệu
$orderCreated = $order->create($name_customer, $productId, $address, $total_price, 'pending'); // 'pending' là trạng thái ban đầu

if ($orderCreated) {
    // Xóa giỏ hàng sau khi thanh toán thành công
    unset($_SESSION['cart']);
    header("Location: /public/success.php"); // Chuyển hướng đến trang thành công
    exit();
} else {
    echo "Đã có lỗi xảy ra khi tạo đơn hàng.";
}

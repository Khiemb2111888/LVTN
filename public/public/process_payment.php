<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Order;
use CT275\Labs\OrderItem;

// Kiểm tra giỏ hàng có sản phẩm không
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>";
    header('Location: cart_view.php');
    exit;
}

// Lấy dữ liệu từ form thanh toán
if (isset($_POST['name_customer'], $_POST['address'])) {
    $nameCustomer = $_POST['name_customer'];
    $address = $_POST['address'];

    // Tính tổng tiền
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Tạo đối tượng Order
    $order = new Order($PDO);

    // Lưu thông tin đơn hàng vào bảng orders
    if ($order->create($nameCustomer, $address, $totalPrice, 'pending')) {
        $orderId = $PDO->lastInsertId(); // Lấy ID của đơn hàng vừa tạo

        // Lưu chi tiết sản phẩm vào bảng order_items
        foreach ($_SESSION['cart'] as $productId => $item) {
            $orderItem = new OrderItem($PDO);
            $orderItem->create($orderId, $productId, $item['quantity'], $item['price']);
        }

        // Xóa giỏ hàng sau khi xử lý
        unset($_SESSION['cart']);

        header('Location: success.php');
        exit;
    } else {
        echo "<p>Đã xảy ra lỗi khi tạo đơn hàng. Vui lòng thử lại.</p>";
    }
} else {
    echo "<p>Vui lòng điền đầy đủ thông tin thanh toán.</p>";
    header('Location: checkout.php');
    exit;
}

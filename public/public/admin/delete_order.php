<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Order;
use CT275\Labs\OrderItem;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra nếu có ID đơn hàng
    if (isset($_POST['order_id'])) {
        $orderId = $_POST['order_id'];

        // Tạo đối tượng Order và OrderItem
        $order = new Order($PDO);
        $orderItem = new OrderItem($PDO);

        // Xóa các sản phẩm thuộc đơn hàng này trước
        $orderItem->deleteItemsByOrderId($orderId);

        // Sau đó xóa đơn hàng
        if ($order->delete($orderId)) {
            $_SESSION['success'] = "Đơn hàng đã được xóa thành công.";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa đơn hàng.";
        }
    }
}

// Chuyển hướng về trang quản lý đơn hàng
header("Location: manage_orders.php");
exit();

<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Order;

// Kiểm tra yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Tạo đối tượng Order
    $order = new Order($PDO);

    // Cập nhật trạng thái đơn hàng
    $order->updateStatus($orderId, $newStatus);

    // Chuyển hướng lại trang quản lý đơn hàng
    header("Location: manage_orders.php");
    exit();
}

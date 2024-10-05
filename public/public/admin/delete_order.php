<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Order;

$order = new Order($PDO);

// Kiểm tra nếu ID đơn hàng được truyền qua URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /admin/manage_orders.php");
    exit();
}

$orderId = (int)$_GET['id'];

// Xóa đơn hàng
if ($order->delete($orderId)) {
    // Chuyển hướng về trang quản lý đơn hàng
    header("Location: /public/admin/manage_orders.php");
    exit();
} else {
    echo "Xóa đơn hàng không thành công.";
}

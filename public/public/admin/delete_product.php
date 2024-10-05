<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Product;

// Kiểm tra nếu ID sản phẩm được truyền qua URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /public/admin/manage_products.php?message=ID sản phẩm không hợp lệ");
    exit();
}

$productId = (int)$_GET['id'];
$product = new Product($PDO);

// Xóa sản phẩm
if ($product->delete($productId)) {
    // Chuyển hướng về trang quản lý sản phẩm với thông báo thành công
    header("Location: /public/admin/manage_products.php?message=Sản phẩm đã được xóa thành công");
} else {
    // Chuyển hướng về trang quản lý sản phẩm với thông báo thất bại
    header("Location: /public/admin/manage_products.php?message=Có lỗi xảy ra khi xóa sản phẩm");
}
exit();

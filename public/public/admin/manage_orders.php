<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Order;

$order = new Order($PDO);
$orders = $order->getAllOrders(); // Lấy tất cả đơn hàng

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Quản Lý Đơn Hàng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>ID Sản Phẩm</th>
                    <th>Địa Chỉ</th>
                    <th>Tổng Giá</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $ord) : ?>
                    <tr>
                        <td><?= htmlspecialchars($ord->id) ?></td>
                        <td><?= htmlspecialchars($ord->customer_name) ?></td>
                        <td><?= htmlspecialchars($ord->product_id) ?></td>
                        <td><?= htmlspecialchars($ord->address) ?></td>
                        <td><?= number_format($ord->total_price, 0, ',', '.') ?> VND</td>
                        <td><?= htmlspecialchars($ord->status) ?></td>
                        <td><?= htmlspecialchars($ord->created_at) ?></td>
                        <td><?= htmlspecialchars($ord->updated_at) ?></td>
                        <td>
                            <a href="edit_order.php?id=<?= htmlspecialchars($ord->id) ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/public/admin/delete_order.php?id=<?= htmlspecialchars($ord->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
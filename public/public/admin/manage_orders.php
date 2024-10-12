<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Order;
use CT275\Labs\OrderItem;

// Tạo đối tượng Order và OrderItem
$order = new Order($PDO);
$orderItem = new OrderItem($PDO);

// Lấy danh sách đơn hàng
$orders = $order->getAllOrders();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Quản Lý Đơn Hàng</h1>
        <a href="/public/admin/index.php" class="btn btn-primary mb-3">Quay về admin</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Đơn Hàng</th>
                    <th>Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Sản Phẩm</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Tiền</th>
                    <th>Ngày Tạo</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <?php
                        // Lấy chi tiết sản phẩm cho mỗi đơn hàng
                        $orderItems = $orderItem->getOrderItemsByOrderId($order->id);
                        ?>
                        <tr>
                            <td class="align-middle"><?= htmlspecialchars($order->id) ?></td>
                            <td class="align-middle" style="width: 10rem;"><?= htmlspecialchars($order->customer_name) ?></td>
                            <td class="align-middle" style="width: 7rem;"><?= htmlspecialchars($order->address) ?></td>
                            <td class="align-middle">
                                <ul class="list-unstyled align-middle">
                                    <?php foreach ($orderItems as $item): ?>
                                        <li><?= htmlspecialchars($item->product_name) ?>
                                            (<?= htmlspecialchars($item->quantity) ?> x <?= number_format($item->price, 0, ',', '.') ?> VND)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="align-middle"><?= htmlspecialchars($order->status) ?></td>
                            <td class="align-middle"><?= number_format($order->total_price, 0, ',', '.') ?> VND</td>
                            <td class="align-middle"><?= htmlspecialchars($order->created_at) ?></td>
                            <td>
                                <!-- Thao tác cập nhật trạng thái -->
                                <form action="update_order_status.php" method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Đang xử lý</option>
                                        <option value="completed" <?= $order->status == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                                        <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Hủy bỏ</option>
                                    </select>
                                </form>

                                <!-- Nút xóa đơn hàng -->
                                <form action="delete_order.php" method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Không có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
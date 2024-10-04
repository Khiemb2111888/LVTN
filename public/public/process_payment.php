<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php'; // Nạp tệp kết nối CSDL

// Kiểm tra nếu form đã gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin thanh toán từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Tạo đối tượng Product để lấy thông tin sản phẩm
    $product = new CT275\Labs\Product($PDO);

    // Lấy chi tiết các sản phẩm trong giỏ hàng
    $orderDetails = [];
    $totalPrice = 0;

    foreach ($_SESSION['cart'] as $productId => $item) {
        $quantity = $item['quantity'];
        $productDetails = $product->getProductById($productId);

        if ($productDetails) {
            $productDetails->quantity = $quantity;
            $productDetails->totalPrice = $productDetails->price * $quantity;
            $orderDetails[] = [
                'product_id' => $productDetails->id,
                'quantity' => $quantity,
                'total_price' => $productDetails->totalPrice,
            ];
            $totalPrice += $productDetails->totalPrice;
        }
    }

    // Lưu thông tin đơn hàng vào CSDL
    $stmt = $PDO->prepare("INSERT INTO orders (customer_name, customer_email, customer_address, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $address, $totalPrice]);

    // Lấy ID đơn hàng vừa được tạo
    $orderId = $PDO->lastInsertId();

    // Lưu thông tin sản phẩm trong đơn hàng vào CSDL
    foreach ($orderDetails as $detail) {
        $stmt = $PDO->prepare("INSERT INTO order_details (order_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $detail['product_id'], $detail['quantity'], $detail['total_price']]);
    }

    // Xóa giỏ hàng sau khi thanh toán
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang admin (ví dụ là admin/orders.php)
    header('Location: /public/product.php');
    exit();
}

<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Product;

// Kiểm tra giỏ hàng có sản phẩm không
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>";
    exit;
}

// Tạo đối tượng Product để lấy thông tin sản phẩm
$product = new Product($PDO);

// Lấy chi tiết các sản phẩm trong giỏ hàng
$cartProducts = [];
$totalPrice = 0;

foreach ($_SESSION['cart'] as $productId => $item) {
    $quantity = $item['quantity'];
    $productDetails = $product->getProductById($productId);

    if ($productDetails) {
        $productDetails->quantity = $quantity;
        $productDetails->totalPrice = $productDetails->price * $quantity;
        $cartProducts[] = $productDetails;
        $totalPrice += $productDetails->totalPrice;
    }
}

require_once __DIR__ . '/../src/partials/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center">Thanh Toán</h1>

    <h2>Thông tin sản phẩm</h2>
    <?php if (!empty($cartProducts)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartProducts as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product->name) ?></td>
                        <td><?= $product->quantity ?></td>
                        <td><?= number_format($product->price, 0, ',', '.') ?> VND</td>
                        <td><?= number_format($product->totalPrice, 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Tổng: <?= number_format($totalPrice, 0, ',', '.') ?> VND</h3>

        <h2>Thông tin thanh toán</h2>
        <form action="process_payment.php" method="POST">
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ giao hàng:</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
        </form>
    <?php else: ?>
        <p>Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>
    <?php endif; ?>
</div>

<?php
// require_once __DIR__ . '/../src/partials/footer.php';
?>
<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Product;

// Kiểm tra giỏ hàng có sản phẩm không
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Giỏ hàng của bạn trống.</p>";
    header('Location: /public/product.php');
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
    <h1 class="text-center">Giỏ Hàng Của Bạn</h1>

    <?php if (!empty($cartProducts)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartProducts as $product): ?>
                    <tr>
                        <td> <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="img-thumbnail" style="width: 100px; object-fit: cover;"><?= htmlspecialchars($product->name) ?></td>
                        <td>
                            <form action="update_cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <input type="number" name="quantity" value="<?= $product->quantity ?>" min="1" class="form-control" style="width: 80px; display: inline;">
                                <button type="submit" class="btn btn-warning btn-sm">Cập nhật</button>
                            </form>
                        </td>
                        <td><?= number_format($product->price, 0, ',', '.') ?> VND</td>
                        <td><?= number_format($product->totalPrice, 0, ',', '.') ?> VND</td>
                        <td>
                            <a href="delete_cart.php?product_id=<?= $product->id ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-right">
            <h3>Tổng: <?= number_format($totalPrice, 0, ',', '.') ?> VND</h3>
            <a href="checkout.php" class="btn btn-success">Tiến hành thanh toán</a>
        </div>
    <?php else: ?>
        <p>Giỏ hàng của bạn trống.</p>
    <?php endif; ?>
</div>

<?php
// require_once __DIR__ . '/../src/partials/footer.php';
?>
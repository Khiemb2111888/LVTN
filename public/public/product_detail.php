<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Product;

// Kiểm tra ID sản phẩm
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = new Product($PDO);
    $productDetails = $product->getProductById($productId);

    if (!$productDetails) {
        echo "Sản phẩm không tồn tại.";
        exit();
    }
} else {
    echo "Không tìm thấy sản phẩm.";
    exit();
}
require_once __DIR__ . '/../src/partials/header.php';

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <img src="<?= htmlspecialchars($productDetails->image) ?>" alt="<?= htmlspecialchars($productDetails->name) ?>" class="img-fluid">
        </div>
        <div class="col-md-9">
            <h2><?= htmlspecialchars($productDetails->name) ?></h2>
            <p><?= htmlspecialchars($productDetails->description) ?></p>
            <p>Giá: <?= number_format($productDetails->price, 0, ',', '.') ?> VND</p>

            <!-- Form thêm vào giỏ hàng -->
            <form action="/public/add_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $productDetails->id ?>">

                <!-- Input để chỉnh số lượng -->
                <div class="form-group">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;">
                </div>

                <!-- Nút thêm vào giỏ hàng -->
                <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>
</div>
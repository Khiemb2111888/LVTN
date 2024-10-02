<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Product;
use CT275\Labs\Category;

// Khởi tạo đối tượng Product và Category
$product = new Product($PDO);
$category = new Category($PDO);

// Lấy danh sách tất cả danh mục
$categories = $category->getAllCategories();

// Kiểm tra nếu danh mục được chọn
$selectedCategory = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Lấy các sản phẩm theo danh mục
$products = $selectedCategory ? $product->getProductsByCategory($selectedCategory) : [];
require_once __DIR__ . '/../src/partials/header.php';
?>


<div class="conatiner mt-5">
    <h1 class="text-center">Danh Sách Sản Phẩm</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <h5>Danh Mục</h5>
            <div class="list-group">
                <?php foreach ($categories as $cat): ?>
                    <a href="product.php?category_id=<?= $cat->id ?>" class="list-group-item <?= $selectedCategory == $cat->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3 mb-4"> <!-- Chia thành 4 cột -->
                            <div class="card">
                                <img src="<?= htmlspecialchars($product->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($product->name) ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                                    <p class="card-text">Giá: <?= number_format($product->price, 0, ',', '.') ?> VND</p>
                                    <p class="card-text">Mô tả: <?= htmlspecialchars($product->description) ?></p>
                                    <a href="product_detail.php?id=<?= $product->id ?>" class="btn btn-primary">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>Không có sản phẩm nào thuộc danh mục này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
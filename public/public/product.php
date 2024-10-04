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
$products = $selectedCategory ? $product->getProductsByCategory($selectedCategory) : $product->getAllProducts();
require_once __DIR__ . '/../src/partials/header.php';
?>

<div class="mx-2 mt-5">
    <h1 class="text-center">Danh Sách Sản Phẩm</h1>

    <div class="row mb-4 ">
        <div class="col-md-3 pr-0">
            <div class="list-group">
                <a href="product.php" class="list-group-item <?= !$selectedCategory ? 'active' : '' ?>">Tất cả</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="product.php?category_id=<?= $cat->id ?>" class="list-group-item <?= $selectedCategory == $cat->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-9 ">
            <div class="row">
                <?php if ($products === false): ?>
                    <p>Có lỗi xảy ra khi lấy sản phẩm.</p>
                <?php elseif (empty($products)): ?>
                    <p>Không có sản phẩm nào thuộc danh mục này.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3 mb-4 d-flex"> <!-- Thay đổi ở đây -->
                            <div class="card product-card flex-fill">
                                <img src="<?= htmlspecialchars($product->image) ?>" class="card-img-top product-image" alt="<?= htmlspecialchars($product->name) ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($product->name) ?></h5>
                                    <p class="card-text product-price">Giá: <?= number_format($product->price, 0, ',', '.') ?> VND</p>
                                    <a href="product_detail.php?id=<?= $product->id ?>" class="btn btn-primary mt-auto">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<?php
// require_once __DIR__ . '/../src/partials/footer.php';
?>
</body>

</html>
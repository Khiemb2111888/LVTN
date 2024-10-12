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

<div class="  mx-2 mt-2">
    <div class="row mb-4 ">
        <div class="col-md-3 pr-0 pl-5 ml-5">
            <div class="list-group">
                <a href="product.php" class="list-group-item <?= !$selectedCategory ? 'active' : '' ?>">CATEGORY</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="product.php?category_id=<?= $cat->id ?>" class="list-group-item <?= $selectedCategory == $cat->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-8 ">
            <div class="image-container d-flex justify-content-center  pb-3">
                <img class="banner" id="image" src="/public/assets/img/baner1.jpg" alt="Image" style="width: 100%; height: 25em;">
            </div>
            <script>
                // Danh sách các hình ảnh để thay đổi
                const images = [
                    "/public/assets/img/baner1.jpg",
                    "/public/assets/img/baner2.jpg",
                    "/public/assets/img/baner3.jpg",
                    "/public/assets/img/baner4.jpg",
                ];

                let currentIndex = 0; // Chỉ số của hình ảnh hiện tại

                const imageElement = document.getElementById("image");

                function changeImage() {
                    currentIndex = (currentIndex + 1) % images.length; // Cập nhật chỉ số hình ảnh
                    imageElement.src = images[currentIndex]; // Thay đổi nguồn hình ảnh
                }

                // Thay đổi hình ảnh ngay khi tải trang
                changeImage();

                // Thay đổi hình ảnh mỗi 3 giây
                setInterval(changeImage, 5000);
            </script>
            <div class="row">
                <?php if ($products === false): ?>
                    <p>Có lỗi xảy ra khi lấy sản phẩm.</p>
                <?php elseif (empty($products)): ?>
                    <p>Không có sản phẩm nào thuộc danh mục này.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3 mb-4 d-flex px-0"> <!-- Thay đổi ở đây -->
                            <div class="card product-card flex-fill">
                                <img src="<?= htmlspecialchars($product->image) ?>" class="card-img-top product-image" alt="<?= htmlspecialchars($product->name) ?>" style="height: 150px; object-fit: contain;">
                                <div class="card-body d-flex flex-column">
                                    <p class="card-title"><?= htmlspecialchars($product->name) ?></p>
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
require_once __DIR__ . '/../src/partials/footer.php';
?>
</body>

</html>
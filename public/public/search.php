<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\Product;

$keyword = ''; // Từ khóa tìm kiếm
$productDetails = null; // Chi tiết sản phẩm nếu tìm thấy

// Kiểm tra nếu có từ khóa tìm kiếm
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']); // Lấy từ khóa từ form và loại bỏ khoảng trắng

    // Tạo đối tượng Product để truy vấn cơ sở dữ liệu
    $product = new Product($PDO);

    // Truy vấn sản phẩm theo tên
    $stmt = $PDO->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute(['%' . $keyword . '%']);
    $productDetails = $stmt->fetch(PDO::FETCH_OBJ);

    // Nếu tìm thấy sản phẩm, chuyển hướng đến trang chi tiết sản phẩm
    if ($productDetails) {
        header('Location: product_detail.php?id=' . $productDetails->id);
        exit(); // Ngừng thực hiện tiếp sau khi chuyển hướng
    }
}

require_once __DIR__ . '/../src/partials/header.php'; // Nạp phần header
?>

<div class="container mt-5">
    <h2>Kết Quả Tìm Kiếm cho "<?= htmlspecialchars($keyword) ?>"</h2>

    <?php if (!$productDetails): ?>
        <p>Không tìm thấy sản phẩm nào với từ khóa "<?= htmlspecialchars($keyword) ?>"</p>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../src/partials/footer.php'; // Nạp phần footer
?>
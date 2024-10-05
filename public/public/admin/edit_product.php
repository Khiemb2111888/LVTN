<?php
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Product;

// Kiểm tra nếu ID sản phẩm được truyền qua URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /admin/manage_products.php");
    exit();
}

$productId = (int)$_GET['id'];
$product = new Product($PDO);

// Lấy thông tin sản phẩm
$productDetails = $product->getProductById($productId);
if (!$productDetails) {
    echo "Không tìm thấy sản phẩm!";
    exit();
}

// Xử lý form khi người dùng gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity']; // Thêm số lượng vào đây
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $productDetails->image; // Giữ nguyên hình ảnh cũ nếu không tải lên hình mới

    // Xử lý upload hình ảnh
    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/public/uploads/" . $image);
    }

    // Cập nhật thông tin sản phẩm
    $product->setProductDetails($productId, $name, $price, $description, $category_id, $quantity, $image);

    // Chuyển hướng về trang quản lý sản phẩm
    header("Location: /public/admin/manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Cập Nhật Sản Phẩm</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($productDetails->name) ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($productDetails->price) ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Số Lượng</label>
                <input type="number" class="form-control" name="quantity" value="<?= htmlspecialchars($productDetails->quantity) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea class="form-control" name="description" required><?= htmlspecialchars($productDetails->description) ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Danh Mục</label>
                <select class="form-control" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    <?php
                    // Lấy danh sách danh mục từ CSDL
                    $categories = $product->getCategories();
                    foreach ($categories as $category) {
                        $selected = $category->id == $productDetails->category_id ? 'selected' : '';
                        echo "<option value=\"{$category->id}\" $selected>{$category->name}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Hình Ảnh</label>
                <input type="file" class="form-control-file" name="image">
                <small class="form-text text-muted">Hình ảnh hiện tại: <img src="/public/uploads/<?= htmlspecialchars($productDetails->image) ?>" alt="Current Image" width="100"></small>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="/admin/manage_products.php" class="btn btn-secondary">Trở Về</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
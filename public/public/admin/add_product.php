<?php
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Product;

// Khởi tạo đối tượng Product
$product = new Product($PDO);

// Xử lý form khi người dùng gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity']; // Thêm số lượng
    $image = $_FILES['image']['name'];

    // Xử lý upload hình ảnh
    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../public/uploads/" . $image);
    }

    // Thiết lập thông tin sản phẩm
    $product->setProductData($name, $price, $description, $category_id, $image, $quantity);
    $product->create(); // Thêm sản phẩm mới vào cơ sở dữ liệu

    // Chuyển hướng về trang quản lý sản phẩm
    header("Location: /public/admin/manage_products.php");
    exit();
}

// Lấy danh sách danh mục
$categories = $product->getCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Thêm Sản Phẩm Mới</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Danh Mục</label>
                <select class="form-control" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category->id) ?>"><?= htmlspecialchars($category->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Số Lượng</label>
                <input type="number" class="form-control" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="image">Hình Ảnh</label>
                <input type="file" class="form-control-file" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
            <a href="/admin/manage_products.php" class="btn btn-secondary">Trở Về</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
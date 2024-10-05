<?php
session_start();
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\Product;

$product = new Product($PDO);
$products = $product->getAllProducts(); // Giả sử phương thức này tồn tại và lấy tất cả sản phẩm

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Quản Lý Sản Phẩm</h2>
        <a href="/public/admin/add_product.php" class="btn btn-primary mb-3">Thêm Sản Phẩm Mới</a>
        <a href="/public/admin/index.php" class="btn btn-primary mb-3">Quay về admin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Danh Mục</th>
                    <th>Mô Tả</th>
                    <th>Hình Ảnh</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $prod) : ?>
                    <tr>
                        <td><?= htmlspecialchars($prod->id) ?></td>
                        <td><?= htmlspecialchars($prod->name) ?></td>
                        <td><?= htmlspecialchars($prod->price) ?></td>
                        <td><?= htmlspecialchars($prod->quantity) ?></td>
                        <td><?= htmlspecialchars($prod->category_id) ?></td> <!-- Giả sử bạn đã có phương thức để lấy tên danh mục -->
                        <td><?= htmlspecialchars($prod->description) ?></td>
                        <td><img src="/uploads/<?= htmlspecialchars($prod->image) ?>" alt="<?= htmlspecialchars($prod->name) ?>" style="width: 100px;"></td>
                        <td>
                            <a href="edit_product.php?id=<?= htmlspecialchars($prod->id) ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/public/admin/delete_product.php?id=<?= htmlspecialchars($prod->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
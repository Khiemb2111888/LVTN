<?php
require_once '../includes/config.php';

// Khai báo các biến để lưu thông tin sản phẩm
$product_id = $name = $price = $description = $category_id = $category_id = $image = '';
$edit_mode = false;

// Xử lý khi người dùng gửi form (thêm hoặc sửa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // Xử lý hình ảnh (nếu có)
    $image = $_FILES['image']['name'];
    $target_dir = "../assets/img/";
    $target_file = $target_dir . basename($image);
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    // Kiểm tra nếu là sửa sản phẩm
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $product_id = $_POST['id'];
        // Cập nhật sản phẩm
        if ($image) {
            $sql = "UPDATE products SET name=?, price=?, description=?, category_id=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdisssi", $name, $price, $description, $category_id, $category_id, $image, $product_id);
        } else {
            $sql = "UPDATE products SET name=?, price=?, description=?, category_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdissi", $name, $price, $description, $category_id, $category_id, $product_id);
        }
    } else {
        // Thêm sản phẩm mới
        $sql = "INSERT INTO products (name, price, description, category_id, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdisss", $name, $price, $description, $category_id, $category_id, $image);
    }
    $stmt->execute();
    $stmt->close();
    header('Location: admin.php');
    exit;
}

// Kiểm tra nếu là chỉnh sửa
if (isset($_GET['edit'])) {
    $product_id = $_GET['edit'];
    $edit_mode = true;

    // Lấy thông tin sản phẩm để chỉnh sửa
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Gán giá trị vào form
    $name = $product['name'];
    $price = $product['price'];
    $description = $product['description'];
    $category_id = $product['category_id'];
    $image = $product['image'];
    $stmt->close();
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
    header('Location: product.php');
    exit;
}

// Truy vấn danh sách các danh mục
$sql = "SELECT * FROM categories";
$categories = $conn->query($sql);

// Truy vấn danh sách sản phẩm
$sql = "SELECT * FROM products";
$products = $conn->query($sql);
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
        <h2><?php echo $edit_mode ? 'Sửa Sản Phẩm' : 'Thêm Sản Phẩm'; ?></h2>
        <form action="edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="name">Tên Sản Phẩm:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" class="form-control" name="price" value="<?php echo $price; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô Tả:</label>
                <textarea class="form-control" name="description" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Danh Mục:</label>
                <select class="form-control" name="category_id" required>
                    <?php while ($row = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $category_id) ? 'selected' : ''; ?>>
                            <?php echo $row['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Hình Ảnh:</label>
                <input type="file" class="form-control" name="image">
                <small>Để trống nếu không muốn thay đổi hình ảnh.</small>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $edit_mode ? 'Cập Nhật' : 'Thêm'; ?></button>
        </form>
        <h2 class="mt-5">Danh Sách Sản Phẩm</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Danh Mục</th>
                    <th>Hình Ảnh</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['category_id']; ?></td>
                        <td><img src="../assets/img/<?php echo $row['image']; ?>" alt="Image" width="50"></td>
                        <td>
                            <a href="product.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                            <a href="product.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
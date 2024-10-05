<?php
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\User;

// Khởi tạo đối tượng User
$user = new User($PDO);

// Kiểm tra xem yêu cầu GET có chứa ID người dùng hay không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // Tìm người dùng theo ID
    $userToEdit = $user->find($userId);

    if (!$userToEdit) {
        $_SESSION['error'] = "Người dùng không tồn tại.";
        redirect('/public/admin.php');
    }
} else {
    // Chuyển hướng nếu không có ID
    redirect('/public/admin.php');
}

// Xử lý khi biểu mẫu được gửi (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $userToEdit->username = $_POST['username'];
    $userToEdit->email = $_POST['email'];
    $userToEdit->role = $_POST['role'];

    // Nếu mật khẩu được cung cấp, mã hóa và cập nhật nó
    if (!empty($_POST['password'])) {
        $userToEdit->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // Xử lý upload avatar nếu có tệp mới
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . '/../public/uploads/';
        $fileName = basename($_FILES['avatar']['name']);
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        // Kiểm tra định dạng tệp hợp lệ
        if (in_array($fileExt, $allowedExts)) {
            $newFileName = uniqid() . '.' . $fileExt;
            $targetFilePath = $targetDir . $newFileName;

            // Di chuyển tệp ảnh đã upload vào thư mục đích
            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $userToEdit->avatar = $newFileName; // Lưu tên file vào database
            } else {
                $_SESSION['error'] = "Có lỗi khi upload ảnh.";
            }
        } else {
            $_SESSION['error'] = "Định dạng ảnh không hợp lệ.";
        }
    }

    // Lưu thay đổi
    if ($userToEdit->save()) {
        $_SESSION['success'] = "Thông tin người dùng đã được cập nhật.";
        // Chuyển hướng về trang quản lý sau khi chỉnh sửa
        redirect('/public/admin/manage_users.php');
    } else {
        $_SESSION['error'] = "Cập nhật thông tin thất bại. Vui lòng thử lại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Người Dùng</title>
</head>

<body>
    <h2>Chỉnh Sửa Người Dùng</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" value="<?= html_escape($userToEdit->username) ?>" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= html_escape($userToEdit->email) ?>" required>
        <br><br>

        <label for="password">Mật khẩu (để trống nếu không thay đổi):</label>
        <input type="password" id="password" name="password">
        <br><br>

        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="customer" <?= $userToEdit->role === 'customer' ? 'selected' : '' ?>>Customer</option>
            <option value="admin" <?= $userToEdit->role === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <br><br>

        <label for="avatar">Avatar (để trống nếu không thay đổi):</label>
        <input type="file" id="avatar" name="avatar">
        <br><br>

        <input type="submit" value="Lưu">
    </form>
</body>

</html>
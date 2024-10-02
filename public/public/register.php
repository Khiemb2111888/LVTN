<?php
session_start();
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\User;
use CT275\Labs\Paginator;

$User = new User($PDO);
$limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ? (int)$_GET['limit'] : 5;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
$paginator = new Paginator(
    totalRecords: $User->count(),
    recordsPerPage: $limit,
    currentPage: $page
);
$Users = $User->paginate($paginator->recordOffset, $paginator->recordsPerPage);
$pages = $paginator->getPages(length: 3);

// Xử lý khi biểu mẫu được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Tạo một đối tượng User
    $user = new User($PDO);
    $user->fill([
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role,
    ]);

    // Kiểm tra lỗi
    $errors = $user->validate($_POST);

    // Kiểm tra xem email đã tồn tại chưa
    if ($user->emailExists($email)) {
        $errors['email'] = "Email này đã được đăng ký. Vui lòng sử dụng email khác.";
    }

    // Nếu có lỗi, hiển thị thông báo
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu
        $user->fill([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role,
        ]);

        if ($user->save()) {
            $_SESSION['success'] = "Đăng ký thành công! Bạn có thể đăng nhập.";
            header("Location: /public/index.php");
            exit();
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>

<body>
    <h2>Đăng Ký Người Dùng</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    ?>

    <form action="" method="post">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
        <br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <input type="submit" value="Đăng Ký">
    </form>
</body>

</html>
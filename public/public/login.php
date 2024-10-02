<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\User;

// Xử lý khi biểu mẫu được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUsername = trim($_POST['email_or_username']);
    $password = trim($_POST['password']);

    // Tạo đối tượng User
    $user = new User($PDO);

    // Tìm kiếm người dùng
    $userRecord = $user->findByEmailOrUsername($emailOrUsername);

    // Nếu tìm thấy người dùng
    if ($userRecord) {
        // Kiểm tra mật khẩu
        if (password_verify($password, $userRecord->password)) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $userRecord->id;
            $_SESSION['username'] = $userRecord->username;

            // Chuyển hướng theo vai trò
            if ($userRecord->role === 'admin') {
                // Chuyển hướng đến trang admin nếu role là admin
                header("Location: /public/admin.php");
            } elseif ($userRecord->role === 'customer') {
                // Chuyển hướng đến trang index chung nếu không phải admin 
                header("Location: /public/index.php");
            }

            exit();
        } else {
            // Mật khẩu sai
            $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng.";
            if ($userRecord) {
                echo "User found: " . htmlspecialchars($userRecord->username); // In ra tên người dùng
                echo "<br>Password Hash: " . htmlspecialchars($userRecord->password); // In ra hash mật khẩu
                echo "<br>Password Hash: " . htmlspecialchars($password); // In ra hash mật khẩu
                echo "<br>Password Hash: " . htmlspecialchars($emailOrUsername); // In ra hash mật khẩu
            } else {
                echo "No user found.";
            }
        }
    } else {
        // Người dùng không tồn tại
        $_SESSION['error'] = "Người dùng không tồn tại.";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
</head>

<body>
    <h2>Đăng Nhập</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>

    <form action="" method="post">
        <label for="email_or_username">Tên đăng nhập hoặc Email:</label>
        <input type="text" id="email_or_username" name="email_or_username" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" required>
        <br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <input type="submit" value="Đăng Nhập">
    </form>
</body>

</html>
<?php
require_once __DIR__ . '/../../src/bootstrap.php';

use CT275\Labs\User;

// Khởi tạo đối tượng User
$user = new User($PDO);

// Kiểm tra xem yêu cầu có phải là POST và ID có được cung cấp hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Tìm người dùng theo ID
    $userToDelete = $user->find($userId);

    // Nếu tìm thấy người dùng, thực hiện xóa
    if ($userToDelete !== null) {
        $userToDelete->delete();
        // Thiết lập thông báo thành công
        $_SESSION['success'] = "Người dùng đã được xóa thành công.";
    } else {
        // Thiết lập thông báo lỗi nếu không tìm thấy người dùng
        $_SESSION['error'] = "Người dùng không tồn tại.";
    }

    // Chuyển hướng về trang quản lý người dùng
    redirect('/public/admin/manage_users.php');
}

// Nếu không có yêu cầu xóa, chuyển hướng về trang quản lý người dùng
redirect('/public/admin/manage_users.php');

<?php
require_once __DIR__ . '/../../src/bootstrap.php'; // Nạp tệp kết nối CSDL
use CT275\Labs\User;

// Thông tin tài khoản admin
$admin_username = "admin";
$admin_password = "admin123"; // Mật khẩu gốc của bạn
$role = "admin";
$email = "admin@123.com";
// Tạo đối tượng User
$user = new User($PDO);

$user->fill([
    'username' => $admin_username,
    'email' => $email,
    'password' => $admin_password,
    'role' => $role,
]);
// Thêm tài khoản admin vào bảng users
if ($user->save()) {
    echo "Tài khoản admin được tạo thành công.";
} else {
    echo "Lỗi: Không thể tạo tài khoản admin.";
}

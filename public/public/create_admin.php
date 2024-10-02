<?php
require_once __DIR__ . '/../includes/config.php';


// Thông tin tài khoản admin
$admin_username = "admin";
$admin_password = "admin123"; // Mật khẩu gốc của bạn

// Mã hóa mật khẩu
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Chèn tài khoản admin vào bảng users
$sql = "INSERT INTO users (username, password, role) VALUES ('$admin_username', '$hashed_password', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Tài khoản admin được tạo thành công.";
} else {
    echo "Lỗi: " . $conn->error;
}

// Đóng kết nối
$conn->close();

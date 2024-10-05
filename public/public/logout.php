<?php
session_start(); // Bắt đầu phiên làm việc

// Xóa tất cả các biến phiên
$_SESSION = [];

// Nếu muốn hủy cookie phiên (nếu có)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy phiên
session_destroy();

// Chuyển hướng về trang chính hoặc trang đăng nhập
header("Location: /public/index.php");
exit();

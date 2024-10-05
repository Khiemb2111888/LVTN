<?php
// Bắt đầu session và kiểm tra nếu người dùng đã đăng nhập và có quyền admin
session_start();

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: /public/login.php"); // Nếu không phải admin, chuyển hướng đến trang đăng nhập
//     exit();
// }

require_once __DIR__ . '/../../src/bootstrap.php'; // Kết nối CSDL

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Quản Lý Người Dùng</h3>
                        <a href="/public/admin/manage_users.php" class="btn btn-primary">Xem Người Dùng</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Quản Lý Sản Phẩm</h3>
                        <a href="/public/admin/manage_products.php" class="btn btn-primary">Xem Sản Phẩm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Quản Lý Đơn Hàng</h3>
                        <a href="/public/admin/manage_orders.php" class="btn btn-primary">Xem Đơn Hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
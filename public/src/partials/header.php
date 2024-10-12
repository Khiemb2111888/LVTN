<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Web Của Tôi</title>
  <link rel="stylesheet" href="/public/assets/css/style.css">
  <link rel="stylesheet" href="/public/assets/css/all.min.css">
  <script src="/public/assets/js/all.min.js"></script>
  <script src="/public/assets/js/script.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <header>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    use CT275\Labs\User;
    use CT275\Labs\Paginator;

    $User = new User($PDO);
    $limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ?
      (int)$_GET['limit'] : 5;
    $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ?
      (int)$_GET['page'] : 1;
    $paginator = new Paginator(
      totalRecords: $User->count(),
      recordsPerPage: $limit,
      currentPage: $page
    );
    $Users = $User->paginate($paginator->recordOffset, $paginator->recordsPerPage);
    $pages = $paginator->getPages(length: 3);

    ?>

    <div class="container">
      <div class="row">
        <div class="col-md-3 d-flex align-items-center justify-content-start">
          <a class="navbar-brand" href="#">Computer</a>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
          <form id="searchForm" action="/public/search.php" method="GET" class="form-inline d-flex w-100 position-relative">
            <input type="text" name="keyword" class="form-control w-100" placeholder="Nhập tên sản phẩm..." required>
            <span class="position-absolute search-icon" style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">
              <i class="fa fa-search"></i>
            </span>
          </form>
        </div>
        <script>
          document.querySelector('.search-icon').addEventListener('click', function() {
            document.getElementById('searchForm').submit();
          });
        </script>
        <div class="col-md-3 d-flex align-items-center justify-content-end">
          <a href="/public/cart_view.php" class="text-dark d-flex align-items-center">
            <i class="fa-solid fa-cart-shopping fa-2x mr-2"></i>
            <span>Mở Giỏ Hàng</span>
          </a>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
      <div class="container">
        <a class="navbar-brand" href="product.php">Trang Chủ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="/public/about.php">Giới Thiệu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/public/services.php">Dịch Vụ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/public/contact.php">Liên Hệ</a>
            </li>
          </ul>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tài Khoản
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php if (!isset($_SESSION['user_id'])): ?>
                  <a class="dropdown-item" href="/public/register.php">Đăng Ký</a>
                  <a class="dropdown-item" href="/public/login.php">Đăng Nhập</a>
                <?php else: ?>
                  <h6 class="dropdown-header">Xin chào, <?= htmlspecialchars($_SESSION['username'] ?? ''); ?>!</h6>
                  <a class="dropdown-item" href="/profile.php">Thông Tin Tài Khoản</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/public/logout.php">Đăng Xuất</a>
                <?php endif; ?>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>


  </header>
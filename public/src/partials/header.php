<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Web Của Tôi</title>
  <link rel="stylesheet" href="../assets/css/product.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/header.css">
  <link rel="stylesheet" href="../assets/css/all.min.css">
  <script src="../assets/js/all.min.js"></script>
  <script src="../assets/js/script.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <header>
    <?php
    session_start();

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
    <div class="">
      <div class="logo my-3">
        <div class="container text-center">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Thời Trang</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tài Khoản
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                      <a class="dropdown-item" href="register.php">Đăng Ký</a>
                      <a class="dropdown-item" href="login.php">Đăng Nhập</a>
                    <?php else: ?>
                      <h6 class="dropdown-header">Xin chào, <?= htmlspecialchars($_SESSION['emailOrUsername']) ?>!</h6>
                      <a class="dropdown-item" href="profile.php">Thông Tin Tài Khoản</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="logout.php">Đăng Xuất</a>
                    <?php endif; ?>
                  </div>
                </li>
              </ul>
            </div>
          </nav>

          <div class="row">
            <div class="col-3">
              <h2>Fashion Store</h2>
            </div>
            <div class="col-2"><i class="fa-solid fa-phone"></i>HOTLINE <br>123456789</div>
            <div class="col-3"><i class="fa-solid fa-truck-fast"></i>MIỄN PHÍ GIAO HÀNG <br> Tận nơi - Toàn Quốc</div>
            <div class="col-2"><i class="fa-solid fa-credit-card"></i>THANH TOÁN ONLINE</div>
            <div class="col-2"><i class="fa-solid fa-cart-shopping mt-3"></i> <a href="../page/cart.php">Mở Giỏ Hàng</a></div>
          </div>
        </div>
      </div>
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
        <div class="container">
          <a class="navbar-brand" href="index.php">Trang Chủ</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="about.php">Giới Thiệu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="services.php">Dịch Vụ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../page/contact.php">Liên Hệ</a>
              </li>
            </ul>
          </div>
          <form class="d-flex mb-0 ">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </nav>
      <div class="image-container  d-flex justify-content-center border border-0">
        <img class="banner" id="image" src="../assets/img/banner4.jpg" alt="Image">
      </div>
      <script>
        // Danh sách các hình ảnh để thay đổi
        const images = [
          "../assets/img/banner1.jpg",
          "../assets/img/banner2.jpg",
          "../assets/img/banner3.jpg",
          "../assets/img/banner4.jpg",
        ];

        let currentIndex = 0; // Chỉ số của hình ảnh hiện tại

        const imageElement = document.getElementById("image");

        function changeImage() {
          currentIndex = (currentIndex + 1) % images.length; // Cập nhật chỉ số hình ảnh
          imageElement.src = images[currentIndex]; // Thay đổi nguồn hình ảnh
        }

        // Thay đổi hình ảnh ngay khi tải trang
        changeImage();

        // Thay đổi hình ảnh mỗi 3 giây
        setInterval(changeImage, 5000);
      </script>

  </header>
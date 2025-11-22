<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAPTOP PRO - Laptop Chính Hãng Giá Tốt Nhất Việt Nam</title>
    <meta name="description" content="Mua laptop chính hãng Asus, Dell, MSI, Acer, Lenovo, MacBook giá tốt. Bảo hành đầy đủ, trả góp 0%, giao hàng nhanh toàn quốc." />
    <meta name="keywords" content="laptop chính hãng, mua laptop giá rẻ, laptop gaming, macbook, asus rog, dell xps" />
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5.3 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Be+Vietnam+Pro:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .navbar-brand { font-family: 'Be Vietnam Pro', sans-serif; font-weight: 700; font-size: 1.8rem; }
        .btn-primary { background: #0d6efd; border: none; }
        .btn-danger { background: #dc3545; }
        .badge-cart { font-size: 0.75rem; top: -8px; right: -8px; }
        .nav-link { font-weight: 500; transition: all 0.3s; }
        .nav-link:hover { color: #ffc107 !important; }
        footer a { text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: #ffc107 !important; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-laptop-fill text-warning me-2" style="font-size: 2rem;"></i>
            <span class="text-white">LAPTOP PRO</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Hãng laptop
                    </a>
                    <ul class="dropdown-menu border-0 shadow">
                        <?php foreach ($hangs as $h): ?>
                            <li><a class="dropdown-item" href="index.php?action=hang&id=<?php echo $h['id']; ?>">
                                <i class=""></i> <?php echo htmlspecialchars($h['tenhang']); ?>
                            </a></li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-primary fw-bold" href="index.php">
                            <i class="bi bi-grid-3x3-gap"></i> Xem tất cả
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#!">Khuyến mãi</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Liên hệ</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION["khachhang"])): ?>
                    <div class="dropdown">
                        <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-md-inline">Xin chào, <?php echo explode(' ', $_SESSION["khachhang"]["hoten"])[0]; ?>!</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="index.php?action=thongtin"><i class="bi bi-person"></i> Thông tin tài khoản</a></li>
                            <li><a class="dropdown-item" href="index.php?action=donhang"><i class="bi bi-box-seam"></i> Đơn hàng của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=dangxuat"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="index.php?action=dangnhap" class="btn btn-outline-light">
                        <i class="bi bi-person"></i> Đăng nhập
                    </a>
                <?php endif; ?>

                <!-- Giỏ hàng -->
                <a href="index.php?action=giohang" class="btn btn-outline-warning position-relative">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-cart">
                        <?php echo demsoluongtronggio(); ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content Area -->
<main class="min-vh-100">
    <div class="container-fluid px-4 px-lg-5 py-4">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CryptoWeb System</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="login.php">💰 CryptoWeb</a>

        <div class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['username'])): ?>
                <span class="nav-link text-warning">👤 <?php echo $_SESSION['username']; ?></span>

                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a class="nav-link text-danger" href="admin.php">Admin</a>
                <?php endif; ?>

                <a class="nav-link" href="payment.php">Thanh toán</a>
                <a class="nav-link text-danger" href="logout.php">Đăng xuất</a>
            <?php else: ?>
                <a class="nav-link" href="register.php">Đăng ký</a>
                <a class="nav-link" href="login.php">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-5">

<div class="alert alert-warning text-center">
⚠ SQL Injection Lab - chỉ dùng học tập
</div>
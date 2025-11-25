<?php include("inc/top.php"); ?>
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=tintuc">Tin tức</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $tintuc['tieude']; ?></li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mb-3 text-info fw-bold"><?php echo $tintuc['tieude']; ?></h1>
            <p class="text-muted"><i class="bi bi-calendar3"></i> Đăng ngày: <?php echo date('d/m/Y H:i', strtotime($tintuc['ngaydang'])); ?></p>
            <hr>
            <div class="content mt-4" style="line-height: 1.8; font-size: 1.1rem;">
                <p class="fw-bold"><?php echo $tintuc['tomtat']; ?></p>
                <div class="text-center my-4">
                     <img src="../images/news/<?php echo $tintuc['hinhanh']; ?>" class="img-fluid rounded shadow" alt="">
                </div>
                <?php echo $tintuc['noidung']; ?>
            </div>
        </div>
    </div>
</div>
<?php include("inc/bottom.php"); ?>

<?php include("inc/top.php"); ?>
<div class="container py-5">
    <h2 class="text-center mb-4 text-primary">Tin Tức Công Nghệ</h2>
    <div class="row">
        <?php foreach($dstintuc as $tt): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="../images/news/<?php echo $tt['hinhanh'] ? $tt['hinhanh'] : 'default_news.jpg'; ?>" class="card-img-top" alt="<?php echo $tt['tieude']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><a href="index.php?action=chitiettintuc&id=<?php echo $tt['id']; ?>" class="text-decoration-none text-dark"><?php echo $tt['tieude']; ?></a></h5>
                    <p class="card-text text-muted"><?php echo substr($tt['tomtat'], 0, 100) . '...'; ?></p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="index.php?action=chitiettintuc&id=<?php echo $tt['id']; ?>" class="btn btn-outline-primary btn-sm">Xem thêm</a>
                    <small class="text-muted float-end"><?php echo date('d/m/Y', strtotime($tt['ngaydang'])); ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include("inc/bottom.php"); ?>

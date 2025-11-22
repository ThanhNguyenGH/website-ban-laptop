<?php include("inc/top.php"); ?>

<!-- Tiêu đề hãng (ví dụ: Asus, Dell, MSI...) -->
<h3 class="text-info fw-bold mb-4">
    <?php echo htmlspecialchars($tenhang); ?> 
    <small class="text-muted">(<?php echo count($laptops); ?> sản phẩm)</small>
</h3>

<!-- Danh sách laptop theo hãng -->
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    <?php 
    if (!empty($laptops)) {
        foreach ($laptops as $lt): 
    ?>
        <div class="col mb-5">
            <div class="card h-100 shadow border-0 hover-shadow">
                <!-- Badge khuyến mãi -->
                <?php if ($lt["khuyenmai"] == 1 || $lt["giaban"] < $lt["giagoc"]): ?>
                    <div class="badge bg-danger text-white position-absolute rounded-0" 
                         style="top: 0.5rem; right: 0.5rem; font-size: 0.9rem;">
                        Giảm giá
                    </div>
                <?php endif; ?>

                <!-- Hình ảnh laptop -->
                <a href="index.php?action=chitiet&id=<?php echo $lt["id"]; ?>" class="text-decoration-none">
                    <img class="card-img-top p-3" 
                         src="../images/laptops/<?php echo $lt["id"]; ?>-1.jpg" 
                         alt="<?php echo htmlspecialchars($lt["tenlaptop"]); ?>"
                         style="height: 220px; object-fit: contain; background:#f8f9fa;">
                </a>

                <!-- Nội dung card -->
                <div class="card-body p-4 d-flex flex-column">
                    <div class="text-center flex-grow-1">
                        <!-- Tên laptop -->
                        <a href="index.php?action=chitiet&id=<?php echo $lt["id"]; ?>" 
                           class="text-decoration-none">
                            <h5 class="fw-bolder text-info line-clamp-2">
                                <?php echo htmlspecialchars($lt["tenlaptop"]); ?>
                            </h5>
                        </a>

                        <!-- Đánh giá sao (sẽ nâng cấp sau bằng trung bình từ bảng danhgia) -->
                        <div class="d-flex justify-content-center small text-warning mb-2">
                            <div class="bi-star-fill"></div>
                            <div class="bi-star-fill"></div>
                            <div class="bi-star-fill"></div>
                            <div class="bi-star-fill"></div>
                            <div class="bi-star-fill"></div>
                        </div>

                        <!-- Giá bán -->
                        <div class="price mt-2">
                            <?php if ($lt["giagoc"] > $lt["giaban"]): ?>
                                <span class="text-muted text-decoration-line-through fs-7">
                                    <?php echo number_format($lt["giagoc"]); ?>đ
                                </span>
                                <br>
                            <?php endif; ?>
                            <span class="text-danger fw-bolder fs-4">
                                <?php echo number_format($lt["giaban"]); ?>đ
                            </span>
                        </div>
                    </div>

                    <!-- Nút chọn mua -->
                    <div class="card-footer bg-transparent border-0 pt-3 text-center">
                        <a class="btn btn-outline-info w-100" 
                           href="index.php?action=chovaogio&id=<?php echo $lt["id"]; ?>">
                            <i class="bi bi-cart-plus"></i> Chọn mua
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        endforeach; 
    } else {
        echo '<div class="col-12 text-center py-5">
                <p class="text-muted fs-4">Hiện chưa có sản phẩm nào thuộc hãng <strong>' . htmlspecialchars($tenhang) . '</strong>.</p>
                <a href="index.php" class="btn btn-outline-primary mt-3">Quay về trang chủ</a>
              </div>';
    }
    ?>
</div>

<!-- Phân trang (tạm thời để mẫu, bạn sẽ làm thật sau khi có phân trang) -->
<div class="text-center my-5">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    </ul>
</div>

<?php include("inc/bottom.php"); ?>
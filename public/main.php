<?php
include("inc/top.php");
?>

<!-- Danh sách các hãng (thay cho danh mục cũ) -->
<?php 
// $hangs: danh sách hãng được truyền từ controller (ví dụ: $hangs = (new HANG())->layhang(); )
foreach ($hangs as $hang) { 
    $i = 0; // đếm số laptop hiển thị trong mỗi hãng (tối đa 4)
?>
    <h3>
        <a class="text-decoration-none text-info" href="index.php?action=hang&id=<?php echo $hang["id"]; ?>">
            <?php echo htmlspecialchars($hang["tenhang"]); ?>
        </a>
    </h3>

    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php 
        // $laptops: danh sách tất cả laptop (đã JOIN tên hãng) được truyền từ controller
        foreach ($laptops as $lt) { 
            // Chỉ hiển thị laptop thuộc hãng hiện tại và tối đa 4 sản phẩm
            if ($lt["hang_id"] == $hang["id"] && $i < 4) { 
                $i++;
        ?>
                <div class="col mb-5">
                    <div class="card h-100 shadow">
                        <!-- Badge khuyến mãi -->
                        <?php if ($lt["khuyenmai"] == 1 || $lt["giaban"] < $lt["giagoc"]) { ?>
                            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                                Giảm giá
                            </div>
                        <?php } ?>

                        <!-- Hình ảnh chính (lấy ảnh đầu tiên từ bảng laptop_hinhanh hoặc ảnh mặc định) -->
                        <a href="index.php?action=chitiet&id=<?php echo $lt["id"]; ?>">
                            <?php 
                            // Nếu bạn đã có ảnh trong bảng laptop_hinhanh thì nên lấy từ đó
                            // Ở đây tạm dùng ảnh chính từ trường trong laptop (có thể bạn vẫn giữ 1 ảnh chính)
                            $anh = !empty($lt["hinhanh_chinh"]) ? $lt["hinhanh_chinh"] : "images/laptops/laptop-" . $lt["id"] . "-1.jpg";
                            ?>
                            <img class="card-img-top" src="../<?php echo $anh; ?>" alt="<?php echo htmlspecialchars($lt["tenlaptop"]); ?>" />
                        </a>

                        <!-- Thông tin sản phẩm -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Tên laptop -->
                                <a class="text-decoration-none" href="index.php?action=chitiet&id=<?php echo $lt["id"]; ?>">
                                    <h5 class="fw-bolder text-info"><?php echo htmlspecialchars($lt["tenlaptop"]); ?></h5>
                                </a>

                                <!-- Đánh giá sao -->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>

                                <!-- Giá -->
                                <?php if ($lt["giagoc"] > $lt["giaban"]) { ?>
                                    <span class="text-muted text-decoration-line-through">
                                        <?php echo number_format($lt["giagoc"]); ?>đ
                                    </span>
                                <?php } ?>
                                <span class="text-danger fw-bolder fs-5">
                                    <?php echo number_format($lt["giaban"]); ?>đ
                                </span>
                            </div>
                        </div>

                        <!-- Nút chọn mua -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-info mt-auto" href="index.php?action=chovaogio&id=<?php echo $lt["id"]; ?>">
                                    Chọn mua
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            } // end if
        } // end foreach laptop
        ?>
    </div>

    <!-- Thông báo nếu không có sản phẩm hoặc nút Xem thêm -->
    <?php 
    if ($i == 0) {
        echo "<p class='text-muted'>Hãng này hiện chưa có sản phẩm nào.</p>";
    } else { 
    ?>
        <div class="text-end mb-5">
            <a class="text-warning text-decoration-none fw-bolder" href="index.php?action=hang&id=<?php echo $hang["id"]; ?>">
                Xem tất cả <?php echo htmlspecialchars($hang["tenhang"]); ?> 
            </a>
        </div>
    <?php 
    } 
    ?>
    <hr class="my-5">
<?php 
} // end foreach hãng 
?>

<?php
include("inc/bottom.php");
?>
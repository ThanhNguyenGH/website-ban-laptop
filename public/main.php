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
        <div class="d-flex justify-content-end mb-3">
    <div class="d-flex justify-content-end mb-3 gap-2">
    <div class="dropdown">
        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-funnel"></i> Lọc theo giá
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?action=locgia&min=0&max=10000000">Dưới 10 triệu</a></li>
            <li><a class="dropdown-item" href="index.php?action=locgia&min=10000000&max=20000000">Từ 10 - 20 triệu</a></li>
            <li><a class="dropdown-item" href="index.php?action=locgia&min=20000000&max=100000000">Trên 20 triệu</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php">Tất cả mức giá</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-sort-numeric-down"></i> Sắp xếp giá
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?sort=ASC">Giá: Thấp đến Cao</a></li>
            <li><a class="dropdown-item" href="index.php?sort=DESC">Giá: Cao đến Thấp</a></li>
        </ul>
    </div>
</div>
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
                        <?php if ($lt["noibat"] == 1) { ?>
                        <div class="badge bg-warning text-dark position-absolute shadow-sm" style="top: 0.5rem; left: 0.5rem">
                            <i class="bi bi-fire"></i> HOT
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
                            <div class="text-center d-flex justify-content-center gap-2">
                                <a class="btn btn-outline-secondary mt-auto" href="index.php?action=chitiet&id=<?php echo $lt["id"]; ?>">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                                
                                <a class="btn btn-info mt-auto text-white" href="index.php?action=chovaogio&id=<?php echo $lt["id"]; ?>&soluong=1">
                                    <i class="bi bi-cart-plus"></i> Mua ngay
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

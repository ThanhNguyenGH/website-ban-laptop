<?php include("inc/top.php"); ?>
    
  <div class="row">
    <div class="col-sm-9">      

      <h3 class="text-info"><?php echo $laptop["tenlaptop"]; ?></h3>
      
      <div>
        <?php 
        // Lấy ảnh chính từ bảng laptop_hinhanh
        $db = DATABASE::connect();
        $sql = "SELECT hinhanh FROM laptop_hinhanh WHERE laptop_id = :id AND anhchinh = 1 LIMIT 1";
        $cmd = $db->prepare($sql);
       

 $cmd->bindValue(':id', $laptop['id']);
        $cmd->execute();
        $anh = $cmd->fetchColumn();
        if (!$anh) $anh = "images/laptops/default.jpg";  // nếu chưa có ảnh nào đánh dấu anhchinh
        ?>
        <img width="500px" src="../<?php echo $anh; ?>">
      </div>

      
      <div>
      <h4 class="text-primary">Giá bán: 
        <span class="text-danger"><?php echo number_format($laptop["giaban"]); ?> đ</span>
      </h4>
  		<form method="post" class="form-inline">
    		<input type="hidden" name="action" value="chovaogio">
    		<input type="hidden" name="id" value="<?php echo $laptop["id"]; ?>">
        <div class="row">
          <div class="col">
            <input type="number" class="form-control" name="soluong" value="1">
          </div>
          <div class="col">
            <input type="submit" class="btn btn-primary" value="Chọn mua">
          </div>
			<div class="card mt-4 border-success">
			    <div class="card-header bg-success text-white fw-bold">
			        <i class="bi bi-gift-fill"></i> Ưu đãi & Cam kết
			    </div>
			    <div class="card-body">
			        <ul class="list-unstyled mb-0">
			            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Bảo hành chính hãng 12-24 tháng</li>
			            <li class="mb-2"><i class="bi bi-arrow-repeat text-success me-2"></i>1 đổi 1 trong 15 ngày nếu lỗi</li>
			            <li class="mb-2"><i class="bi bi-truck text-success me-2"></i>Miễn phí vận chuyển toàn quốc</li>
			            <li><i class="bi bi-tools text-success me-2"></i>Hỗ trợ cài đặt phần mềm trọn đời</li>
			        </ul>
			    </div>
			</div>
        </div>		
    	</form>  	  
  	  </div>
	  
      <div>
        <h4 class="text-primary">Mô tả sản phẩm: </h4>
        <p><?php echo $laptop["mota_chitiet"]; ?></p>
      </div>
      <br>
    </div>
    <div class="col-sm-3"> 
      
      <h3 class="text-warning">Cùng danh mục:</h3>

      <?php
      foreach($laptop_cung_hang as $m):  
        if($m["id"] != $laptop["id"]){
      ?>
      <div>
        <div class="col mb-5">
        <div class="card h-100 shadow">
            <!-- Sale badge-->
            <?php if ($m["giaban"] != $m["giagoc"]){ ?>
            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Giảm giá</div>
            <?php } ?>
            <!-- Product image-->
            <a href="?action=chitiet&id=<?php echo $m["id"]; ?>">
                <?php 
                // Lấy ảnh chính cho từng laptop gợi ý
                $sql2 = "SELECT hinhanh FROM laptop_hinhanh WHERE laptop_id = :id AND anhchinh = 1 LIMIT 1";
                $cmd2 = $db->prepare($sql2);
                $cmd2->bindValue(':id', $m['id']);
                $cmd2->execute();
                $anh_m = $cmd2->fetchColumn();
                if (!$anh_m) $anh_m = "images/laptops/default.jpg";
                ?>
                <img class="card-img-top" src="../<?php echo $anh_m; ?>" alt="<?php echo $m["tenlaptop"]; ?>" />
            </a>
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <a class="text-decoration-none" href="?action=chitiet&id=<?php echo $m["id"]; ?>"><h5 class="fw-bolder text-info"><?php echo $m["tenlaptop"]; ?></h5></a>
                    <!-- Product reviews-->
                    <div class="d-flex justify-content-center small text-warning mb-2">
                        <div class="bi-star-fill"></div>
                        <div class="bi-star-fill"></div>
                        <div class="bi-star-fill"></div>
                        <div class="bi-star-fill"></div>
                        <div class="bi-star-fill"></div>
                    </div>
                    <!-- Product price-->
                    <?php if ($m["giaban"] != $m["giagoc"]){ ?>
                    <span class="text-muted text-decoration-line-through"><?php echo number_format($m["giagoc"]); ?>đ</span>
                    <?php } ?>
                    <span class="text-danger fw-bolder"><?php echo number_format($m["giaban"]); ?>đ</span>
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-info mt-auto" href="index.php?action=chovaogio&id=<?php echo $m["id"]; ?>">Chọn mua</a></div>
            </div>
        </div>
    </div>

      </div>
      <?php 
        }
      endforeach; 
      ?>

    </div>    
  </div>
  

<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-star-fill"></i> Đánh giá sản phẩm</h5>
            </div>
            <div class="card-body">
                <?php if(isset($_SESSION['khachhang'])): ?>
                <form action="index.php?action=guidanhgia" method="post" class="mb-4 border-bottom pb-4">
                    <input type="hidden" name="laptop_id" value="<?php echo $laptop['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn mức độ hài lòng:</label>
                        <select name="diem" class="form-select w-auto">
                            <option value="5">⭐⭐⭐⭐⭐ (Tuyệt vời)</option>
                            <option value="4">⭐⭐⭐⭐ (Tốt)</option>
                            <option value="3">⭐⭐⭐ (Bình thường)</option>
                            <option value="2">⭐⭐ (Tệ)</option>
                            <option value="1">⭐ (Rất tệ)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhận xét của bạn:</label>
                        <textarea name="noidung" class="form-control" rows="3" placeholder="Chia sẻ cảm nhận về sản phẩm..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Gửi đánh giá</button>
                </form>
                <?php else: ?>
                    <div class="alert alert-info">Vui lòng <a href="index.php?action=dangnhap">đăng nhập</a> để viết đánh giá.</div>
                <?php endif; ?>

                <?php 
                // Lấy danh sách đánh giá
                $dsdanhgia = (new DANHGIA())->laydanhgia($laptop['id']);
                if(count($dsdanhgia) > 0): 
                    foreach($dsdanhgia as $dg):
                ?>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <img src="../images/users/<?php echo $dg['hinhanh'] ?? 'default_user.png'; ?>" class="rounded-circle" width="50" height="50">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fw-bold mb-0"><?php echo $dg['hoten']; ?></h6>
                        <div class="text-warning small">
                            <?php for($k=1; $k<=5; $k++) echo $k <= $dg['diem'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                        </div>
                        <p class="mb-1"><?php echo $dg['noidung']; ?></p>
                        <small class="text-muted"><?php echo date('d/m/Y', strtotime($dg['ngaydanhgia'])); ?></small>
                    </div>
                </div>
                <hr>
                <?php endforeach; else: ?>
                    <p class="text-center text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include("inc/bottom.php"); ?>

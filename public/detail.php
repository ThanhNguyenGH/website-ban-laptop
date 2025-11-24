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
  


<?php include("inc/bottom.php"); ?>

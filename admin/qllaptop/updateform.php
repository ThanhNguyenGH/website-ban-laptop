<?php include("../inc/top.php"); ?>
<div>
<h3>Cập nhật Laptop</h3>
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="xulysua">
<input type="hidden" name="txtid" value="<?php echo $m["id"]; ?>">
<div class="my-3">    
	<label>Hãng laptop</label>    
	<select class="form-control" name="opthang">
		<?php foreach ($hangs as $h ) { ?>
			<option value="<?php echo $h["id"]; ?>" <?php if($h["id"] == $m["hang_id"]) echo "selected"; ?>><?php echo $h["tenhang"]; ?></option>
		<?php } ?>
	</select>
</div>
<div class="my-3">    
	<label>Tên laptop</label>    
	<input class="form-control" type="text" name="txttenlaptop" required value="<?php echo $m["tenlaptop"]; ?>">
</div>
<div class="row">
	<div class="col-md-6 my-3">    
		<label>CPU</label>    
		<input class="form-control" type="text" name="txtcpu" value="<?php echo $m["cpu"] ?? ""; ?>">
	</div>
	<div class="col-md-6 my-3">    
		<label>RAM</label>    
		<input class="form-control" type="text" name="txtram" value="<?php echo $m["ram"] ?? ""; ?>">
	</div>
</div>
<div class="row">
	<div class="col-md-6 my-3">    
		<label>Ổ cứng</label>    
		<input class="form-control" type="text" name="txto_cung" value="<?php echo $m["o_cung"] ?? ""; ?>">
	</div>
	<div class="col-md-6 my-3">    
		<label>Card màn hình</label>    
		<input class="form-control" type="text" name="txtcard_man_hinh" value="<?php echo $m["card_man_hinh"] ?? ""; ?>">
	</div>
</div>
<div class="my-3">    
	<label>Màn hình</label>    
	<input class="form-control" type="text" name="txtman_hinh" value="<?php echo $m["man_hinh"] ?? ""; ?>">
</div>
<div class="my-3">    
	<label>Mô tả chi tiết</label>    
	<textarea class="form-control" name="txtmota" id="txtmota" rows="5"><?php echo $m["mota_chitiet"] ?? ""; ?></textarea>
</div> 
<div class="row">
	<div class="col-md-6 my-3">    
		<label>Giá gốc</label>    
		<input class="form-control" type="number" name="txtgiagoc" value="<?php echo $m["giagoc"]; ?>" required>
	</div> 
	<div class="col-md-6 my-3">    
		<label>Giá bán</label>    
		<input class="form-control" type="number" name="txtgiaban" value="<?php echo $m["giaban"]; ?>" required>
	</div>
</div>
<div class="row">
	<div class="col-md-4 my-3">    
		<label>Số lượng tồn</label>    
		<input class="form-control" type="number" name="txtsoluongton" value="<?php echo $m["soluongton"]; ?>" required>
	</div> 
	<div class="col-md-4 my-3">    
		<label>Lượt xem</label>    
		<input class="form-control" type="number" name="txtluotxem" value="<?php echo $m["luotxem"]; ?>" required>
	</div> 
	<div class="col-md-4 my-3">    
		<label>Lượt mua</label>    
		<input class="form-control" type="number" name="txtluotmua" value="<?php echo $m["luotmua"]; ?>" required>
	</div>
</div>
<div class="my-3">
	<label>Hình ảnh</label><br>
	<input type="hidden" name="txthinhcu" value="<?php echo isset($m["hinhanh"]) ? $m["hinhanh"] : ""; ?>">
	<?php 
	$hinhanh_hientai = isset($m["hinhanh"]) && !empty($m["hinhanh"]) ? $m["hinhanh"] : "images/laptops/default.jpg";
	?>
	<img src="../../<?php echo $hinhanh_hientai; ?>" width="100" class="img-thumbnail">	
	<a data-bs-toggle="collapse" data-bs-target="#demo">Đổi hình ảnh</a>
	<div id="demo" class="collapse m-3">
	  <input type="file" class="form-control" name="filehinhanh">
	</div>
</div>

<div class="my-3">
<input class="btn btn-primary"  type="submit" value="Lưu">
<a href="index.php" class="btn btn-warning">Hủy</a>
</div>
</form>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#txtmota' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<?php include("../inc/bottom.php"); ?>

<?php include("../inc/top.php"); ?>

<h3>Thêm Laptop</h3> 
<br>
<form method="post" enctype="multipart/form-data" action="index.php">
<input type="hidden" name="action" value="xulythem">
<div class="mb-3 mt-3">
	<label for="opthang" class="form-label">Hãng laptop</label>
	<select class="form-select" name="opthang" required>
	<?php
	foreach($hangs as $h):
	?>
		<option value="<?php echo $h["id"]; ?>"><?php echo $h["tenhang"]; ?></option>
	<?php
	endforeach;
	?>
	</select>
</div>
<div class="mb-3 mt-3">
	<label for="txttenlaptop" class="form-label">Tên laptop</label>
	<input class="form-control" type="text" name="txttenlaptop" placeholder="Nhập tên laptop" required>
</div>
<div class="row">
	<div class="col-md-6 mb-3">
		<label for="txtcpu" class="form-label">CPU</label>
		<input class="form-control" type="text" name="txtcpu" placeholder="VD: Intel Core i7-13620H">
	</div>
	<div class="col-md-6 mb-3">
		<label for="txtram" class="form-label">RAM</label>
		<input class="form-control" type="text" name="txtram" placeholder="VD: 16GB DDR5">
	</div>
</div>
<div class="row">
	<div class="col-md-6 mb-3">
		<label for="txto_cung" class="form-label">Ổ cứng</label>
		<input class="form-control" type="text" name="txto_cung" placeholder="VD: 512GB SSD">
	</div>
	<div class="col-md-6 mb-3">
		<label for="txtcard_man_hinh" class="form-label">Card màn hình</label>
		<input class="form-control" type="text" name="txtcard_man_hinh" placeholder="VD: RTX 4060 8GB">
	</div>
</div>
<div class="mb-3">
	<label for="txtman_hinh" class="form-label">Màn hình</label>
	<input class="form-control" type="text" name="txtman_hinh" placeholder="VD: 15.6 FHD 144Hz">
</div>
<div class="row">
	<div class="col-md-6 mb-3">
		<label for="txtgiagoc" class="form-label">Giá gốc</label>
		<input class="form-control" type="number" name="txtgiagoc" value="0">
	</div>
	<div class="col-md-6 mb-3">
		<label for="txtgiaban" class="form-label">Giá bán</label>
		<input class="form-control" type="number" name="txtgiaban" value="0">
	</div>
</div>
<div class="mb-3">
	<label for="txtsoluong" class="form-label">Số lượng tồn</label>
	<input class="form-control" type="number" name="txtsoluong" value="0">
</div>
<div class="mb-3 mt-3">
	<label for="txtmota" class="form-label">Mô tả chi tiết</label>
	<textarea id="txtmota" rows="5" class="form-control" name="txtmota" placeholder="Nhập mô tả chi tiết"></textarea>
</div>
<div class="mb-3 mt-3">
	<label>Hình ảnh</label>
	<input class="form-control" type="file" name="filehinhanh">
</div>
<div class="mb-3 mt-3">
	<input type="submit" value="Lưu" class="btn btn-success">
	<a href="index.php" class="btn btn-warning">Hủy</a>
</div>
</form>

<?php include("../inc/bottom.php"); ?>

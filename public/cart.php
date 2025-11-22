<?php include("inc/top.php"); ?>

<?php if(demhangtronggio() == 0): ?>
    <h3 class="text-info">Giỏ hàng rỗng!</h3>
    <p>Vui lòng chọn sản phẩm...</p>    
<?php else: ?>
    <h3 class="text-info">Giỏ hàng của bạn:</h3>

    <form action="index.php" method="post">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="15%">Hình ảnh</th>
                    <th>Tên hàng</th>
                    <th>Đơn giá</th>
                    <th width="15%">Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($giohang as $id => $mh): ?>
                <tr>
                    <!-- Ảnh chính -->
                    <td>
                        <img width="60" class="img-thumbnail" 
                             src="../<?php echo $mh['hinhanh_chinh'] ?? 'images/laptops/default.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($mh['tenlaptop']); ?>">
                    </td>
                    <!-- Tên laptop -->
                    <td class="fw-semibold"><?php echo htmlspecialchars($mh['tenlaptop']); ?></td>
                    <!-- Đơn giá -->
                    <td><?php echo number_format($mh['giaban']); ?>đ</td>
                    <!-- Số lượng -->
                    <td>
                        <input type="number" name="mh[<?php echo $id; ?>]" 
                               value="<?php echo $mh['soluong']; ?>" 
                               min="0" class="form-control form-control-sm w-75">
                    </td>
                    <!-- Thành tiền -->
                    <td class="text-danger fw-bold">
                        <?php echo number_format($mh['thanhtien']); ?>đ
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr class="table-warning">
                    <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                    <td class="text-danger fw-bold fs-5">
                        <?php echo number_format(tinhtiengiohang()); ?>đ
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="alert alert-warning small">
            Lưu ý: trước khi nhấn nút "Cập nhật" hoặc "Thanh toán" thì kiểm tra nếu số lượng mua lớn hơn số lượng tồn kho thì không được thực hiện.
        </div>

        <div class="row mt-3">
            <div class="col">
                <a href="index.php?action=xoagiohang" class="text-danger">
                    Xóa tất cả giỏ hàng
                </a>
                <small class="text-muted d-block">(Nhập số lượng = 0 để xóa từng sản phẩm)</small>
            </div>
            <div class="col text-end">
                <input type="hidden" name="action" value="capnhatgio">
                <button type="submit" class="btn btn-warning me-2">Cập nhật giỏ hàng</button>
                <a href="index.php?action=thanhtoan" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php include("inc/bottom.php"); ?>
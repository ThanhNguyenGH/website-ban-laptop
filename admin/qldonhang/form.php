<?php include("../inc/top.php"); ?>

<?php 
$edit_mode = isset($donhang);
$title = $edit_mode ? "SỬA ĐƠN HÀNG #" . $donhang['id'] : "THÊM ĐƠN HÀNG MỚI";
?>

<h3 class="text-center"><?php echo $title; ?></h3>

<form method="post" action="index.php?action=<?php echo $edit_mode ? 'sua&id='.$donhang['id'] : 'them'; ?>" id="donhangForm">
    <!-- Thông tin chung -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Khách hàng *</label>
            <select name="nguoidung_id" class="form-select" required>
                <option value="">-- Chọn --</option>
                <?php foreach($nguoidungs as $nd): ?>
                    <option value="<?php echo $nd['id']; ?>" 
                        <?php echo ($edit_mode && $donhang['nguoidung_id'] == $nd['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($nd['hoten']) . ' (' . $nd['sodienthoai'] . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Địa chỉ giao hàng *</label>
            <select name="diachi_id" class="form-select" required>
                <option value="">-- Chọn --</option>
                <?php foreach($diachis as $dc): ?>
                    <option value="<?php echo $dc['id']; ?>" 
                        <?php echo ($edit_mode && $donhang['diachi_id'] == $dc['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dc['diachi']) . ' (' . $dc['hoten'] . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php if ($edit_mode): ?>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Trạng thái</label>
            <select name="trangthai" class="form-select">
                <option value="0" <?php echo $donhang['trangthai']==0?'selected':''; ?>>Chờ xử lý</option>
                <option value="1" <?php echo $donhang['trangthai']==1?'selected':''; ?>>Đã xác nhận</option>
                <option value="2" <?php echo $donhang['trangthai']==2?'selected':''; ?>>Đang giao</option>
                <option value="3" <?php echo $donhang['trangthai']==3?'selected':''; ?>>Hoàn thành</option>
                <option value="4" <?php echo $donhang['trangthai']==4?'selected':''; ?>>Đã hủy</option>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Ghi chú</label>
        <textarea name="ghichu" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($donhang['ghichu'] ?? '') : ''; ?></textarea>
    </div>

    <!-- Chi tiết đơn hàng -->
    <h5>Chi tiết đơn hàng</h5>
    <div id="chiTietContainer">
        <?php if ($edit_mode && !empty($chitiets)): ?>
            <?php foreach($chitiets as $ct): ?>
                <div class="row mb-2 chi-tiet-item">
                    <div class="col-md-5">
                        <select name="mathang_id[]" class="form-select mh-select" required>
                            <option value="">-- Chọn mặt hàng --</option>
                            <?php foreach($mathangs as $m): ?>
                                <option value="<?php echo $m['id']; ?>" 
                                    <?php echo $m['id'] == $ct['mathang_id'] ? 'selected' : ''; ?>
                                    data-price="<?php echo $m['giaban']; ?>">
                                    <?php echo htmlspecialchars($m['tenmathang']) . ' - ' . number_format($m['giaban']) . '₫'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="soluong[]" class="form-control soluong" value="<?php echo $ct['soluong']; ?>" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control thanhtien" value="<?php echo number_format($ct['thanhtien']); ?>₫" readonly>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm xoa-mh">Xóa</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row mb-2 chi-tiet-item">
                <div class="col-md-5">
                    <select name="mathang_id[]" class="form-select mh-select" required>
                        <option value="">-- Chọn mặt hàng --</option>
                        <?php foreach($mathangs as $m): ?>
                            <option value="<?php echo $m['id']; ?>" data-price="<?php echo $m['giaban']; ?>">
                                <?php echo htmlspecialchars($m['tenmathang']) . ' - ' . number_format($m['giaban']) . '₫'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="soluong[]" class="form-control soluong" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control thanhtien" value="<?php echo number_format(reset($mathangs)['giaban'] ?? 0); ?>₫" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm xoa-mh">Xóa</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <button type="button" class="btn btn-secondary" id="themMH">+ Thêm mặt hàng</button>
    </div>

    <!-- Tổng tiền ẩn (sẽ cập nhật bằng JS, nhưng không cần gửi vì sẽ tính lại ở server) -->
    <div class="text-end mb-3">
        <strong>Tổng tiền: <span id="tongTien">0₫</span></strong>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Lưu đơn hàng</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tính thành tiền khi chọn mặt hàng hoặc đổi số lượng
    function tinhThanhTien(item) {
        const select = item.querySelector('.mh-select');
        const soluong = item.querySelector('.soluong');
        const thanhtien = item.querySelector('.thanhtien');
        const option = select.options[select.selectedIndex];
        const price = parseFloat(option.dataset.price) || 0;
        const qty = parseInt(soluong.value) || 0;
        const total = price * qty;
        thanhtien.value = new Intl.NumberFormat('vi-VN').format(total) + '₫';
        capNhatTongTien();
    }

    function capNhatTongTien() {
        let tong = 0;
        document.querySelectorAll('.thanhtien').forEach(el => {
            const val = el.value.replace(/[^0-9]/g, '');
            tong += parseInt(val) || 0;
        });
        document.getElementById('tongTien').textContent = new Intl.NumberFormat('vi-VN').format(tong) + '₫';
    }

    // Thêm mặt hàng mới
    document.getElementById('themMH').addEventListener('click', function() {
        const container = document.getElementById('chiTietContainer');
        const firstItem = container.querySelector('.chi-tiet-item');
        const clone = firstItem.cloneNode(true);
        clone.querySelectorAll('select, input').forEach(el => {
            if (el.type !== 'button') el.value = el.type === 'number' ? '1' : '';
        });
        clone.querySelector('.thanhtien').value = '0₫';
        container.appendChild(clone);
        attachEvents(clone);
    });

    // Xóa dòng
    function attachEvents(item) {
        item.querySelector('.xoa-mh').addEventListener('click', function() {
            if (document.querySelectorAll('.chi-tiet-item').length > 1) {
                item.remove();
                capNhatTongTien();
            } else {
                alert('Phải có ít nhất 1 mặt hàng!');
            }
        });
        item.querySelector('.mh-select').addEventListener('change', () => tinhThanhTien(item));
        item.querySelector('.soluong').addEventListener('input', () => tinhThanhTien(item));
    }

    // Gắn sự kiện cho các dòng có sẵn
    document.querySelectorAll('.chi-tiet-item').forEach(attachEvents);
    capNhatTongTien();
});
</script>

<?php include("../inc/bottom.php"); ?>
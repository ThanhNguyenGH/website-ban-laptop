<?php include("../inc/top.php"); ?>

<div class="container">
    <h3 class="text-center">CHI TIẾT ĐƠN HÀNG #<?php echo $donhang["id"]; ?></h3>

    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($donhang["hoten"]); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($donhang["email"] ?? 'Chưa có'); ?></p>
            <p><strong>SĐT:</strong> <?php echo $donhang["sodienthoai"]; ?></p>
            <p><strong>Địa chỉ giao:</strong> <?php echo htmlspecialchars($donhang["diachi"] ?? 'Chưa cập nhật'); ?></p>
            <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($donhang["ghichu"] ?? 'Không có'); ?></p>
        </div>
        <div class="col-md-6 text-end">
            <p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($donhang["ngay"])); ?></p>
            <p><strong>Tổng tiền:</strong> 
                <span class="text-danger fs-3"><?php echo number_format($donhang["tongtien"]); ?>₫</span>
            </p>
            <p><strong>Trạng thái:</strong> 
                <span class="badge 
                    <?php 
                        switch($donhang["trangthai"]){
                            case 0: echo 'bg-warning'; break;
                            case 1: echo 'bg-primary'; break;
                            case 2: echo 'bg-info'; break;
                            case 3: echo 'bg-success'; break;
                            case 4: echo 'bg-danger'; break;
                        }
                    ?>">
                    <?php 
                        $tt = ["Chờ xử lý", "Đã xác nhận", "Đang giao", "Hoàn thành", "Đã hủy"];
                        echo $tt[$donhang["trangthai"]];
                    ?>
                </span>
            </p>
        </div>
    </div>

    <h4>Sản phẩm trong đơn hàng</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Hình</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>SL</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($chitiet as $ct): ?>
            <tr>
                <td><img src="../../<?php echo $ct["hinhanh"]; ?>" width="60" class="img-thumbnail"></td>
                <td><?php echo htmlspecialchars($ct["tenmathang"]); ?></td>
                <td><?php echo number_format($ct["dongia"]); ?>₫</td>
                <td class="text-center"><?php echo $ct["soluong"]; ?></td>
                <td class="text-end"><strong><?php echo number_format($ct["thanhtien"]); ?>₫</strong></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>TỔNG CỘNG:</strong></td>
                <td class="text-end"><strong class="text-danger fs-5"><?php echo number_format($donhang["tongtien"]); ?>₫</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
</div>

<?php include("../inc/bottom.php"); ?>
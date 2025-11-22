<?php
include("../inc/top.php");
require_once("../../model/database.php");
require_once("../../model/Donhang.php");

$dh = new DONHANG();
$id = $_GET['id'] ?? 0;
$don = $dh->laydonhangtheoid($id);

if (!$don) {
    echo "<h3>Không tìm thấy đơn hàng!</h3>";
    include("../inc/bottom.php");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chi tiết Đơn hàng #<?php echo $don['id']; ?></h2>
    <a href="index.php" class="btn btn-secondary"><i class="align-middle" data-feather="arrow-left"></i> Quay lại</a>
</div>

<div class="row">
    <!-- Thông tin khách hàng & Đơn hàng -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 text-white">Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> <?php echo $don['hoten']; ?></p>
                <p><strong>Email:</strong> <?php echo $don['email']; ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo $don['sodienthoai']; ?></p>
                <p><strong>Địa chỉ giao hàng:</strong> <?php echo $don['diachi_giaohang'] ?? 'Chưa cập nhật'; ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0 text-white">Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($don['ngay'])); ?></p>
                <p><strong>Phương thức thanh toán:</strong> <?php echo $don['phuongthuc_thanhtoan']; ?></p>
                <p><strong>Trạng thái thanh toán:</strong> 
                    <?php echo ($don['trangthai_thanhtoan'] == 1) ? '<span class="badge bg-success">Đã thanh toán</span>' : '<span class="badge bg-warning text-dark">Chưa thanh toán</span>'; ?>
                </p>
                <p><strong>Trạng thái đơn hàng:</strong> 
                    <?php 
                    $tt = $don['trangthai_donhang'];
                    $text = 'Chờ xác nhận';
                    if ($tt == 1) $text = 'Đang xử lý';
                    elseif ($tt == 2) $text = 'Đang giao';
                    elseif ($tt == 3) $text = 'Hoàn thành';
                    elseif ($tt == 4) $text = 'Đã hủy';
                    echo "<strong>$text</strong>";
                    ?>
                </p>
                <p><strong>Ghi chú:</strong> <?php echo $don['ghichu']; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách sản phẩm -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Sản phẩm đã mua</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                foreach ($don['chitiet'] as $ct) : 
                    $hinh = !empty($ct['hinhanh']) ? "../../" . $ct['hinhanh'] : "../../images/laptops/default.jpg";
                ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><img src="<?php echo $hinh; ?>" width="60" class="img-thumbnail"></td>
                    <td><?php echo $ct['tenlaptop']; ?></td>
                    <td><?php echo number_format($ct['dongia']); ?>đ</td>
                    <td><?php echo $ct['soluong']; ?></td>
                    <td class="fw-bold"><?php echo number_format($ct['thanhtien']); ?>đ</td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-end fw-bold fs-5">Tổng cộng:</td>
                    <td class="text-danger fw-bold fs-5"><?php echo number_format($don['tongtien']); ?>đ</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 mb-5 text-center">
    <div class="btn-group">
        <a href="index.php?action=xuly&id=<?php echo $don['id']; ?>" class="btn btn-info">Xác nhận & Xử lý</a>
        <a href="index.php?action=giao&id=<?php echo $don['id']; ?>" class="btn btn-primary">Giao hàng</a>
        <a href="index.php?action=hoanthanh&id=<?php echo $don['id']; ?>" class="btn btn-success">Hoàn thành</a>
        <a href="index.php?action=huy&id=<?php echo $don['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn này?')">Hủy đơn</a>
    </div>
</div>

<?php include("../inc/bottom.php"); ?>

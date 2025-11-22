<h2 class="my-4">Quản lý Đơn hàng</h2>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donhangs as $d) : ?>
            <tr>
                <td>#<?php echo $d['id']; ?></td>
                <td>
                    <strong><?php echo $d['hoten']; ?></strong><br>
                    <small><?php echo $d['email']; ?></small>
                </td>
                <td><?php echo date('d/m/Y H:i', strtotime($d['ngay'])); ?></td>
                <td class="text-danger fw-bold"><?php echo number_format($d['tongtien']); ?>đ</td>
                <td>
                    <span class="badge bg-secondary"><?php echo $d['phuongthuc_thanhtoan']; ?></span>
                    <br>
                    <?php if ($d['trangthai_thanhtoan'] == 1): ?>
                        <span class="badge bg-success">Đã thanh toán</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php 
                    $tt = $d['trangthai_donhang'];
                    $class = 'secondary';
                    $text = 'Chờ xác nhận';
                    if ($tt == 1) { $class = 'info'; $text = 'Đang xử lý'; }
                    elseif ($tt == 2) { $class = 'primary'; $text = 'Đang giao'; }
                    elseif ($tt == 3) { $class = 'success'; $text = 'Hoàn thành'; }
                    elseif ($tt == 4) { $class = 'danger'; $text = 'Đã hủy'; }
                    ?>
                    <span class="badge bg-<?php echo $class; ?>"><?php echo $text; ?></span>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="detail.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-info" title="Xem chi tiết"><i class="align-middle" data-feather="eye"></i></a>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?action=xuly&id=<?php echo $d['id']; ?>">Xác nhận & Xử lý</a></li>
                            <li><a class="dropdown-item" href="index.php?action=giao&id=<?php echo $d['id']; ?>">Giao hàng</a></li>
                            <li><a class="dropdown-item" href="index.php?action=hoanthanh&id=<?php echo $d['id']; ?>">Hoàn thành</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=huy&id=<?php echo $d['id']; ?>">Hủy đơn</a></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=xoa&id=<?php echo $d['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa đơn này?')">Xóa vĩnh viễn</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../inc/bottom.php"); ?>
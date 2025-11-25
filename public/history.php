<?php include("inc/top.php"); ?>
<div class="container py-5">
    <h3 class="mb-4 text-info"><i class="bi bi-clock-history"></i> Lịch sử mua hàng</h3>
    <?php if(empty($donhangs)): ?>
        <div class="alert alert-warning">Bạn chưa có đơn hàng nào. <a href="index.php">Mua sắm ngay</a></div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered shadow-sm">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>TT Thanh toán</th>
                        <th>TT Vận chuyển</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($donhangs as $dh): ?>
                    <tr>
                        <td class="text-center">#<?php echo $dh['id']; ?></td>
                        <td class="text-center"><?php echo date('d/m/Y', strtotime($dh['ngay'])); ?></td>
                        <td class="text-end fw-bold text-danger"><?php echo number_format($dh['tongtien']); ?>đ</td>
                        <td class="text-center">
                            <?php echo ($dh['trangthai_thanhtoan'] == 1) ? '<span class="badge bg-success">Đã TT</span>' : '<span class="badge bg-warning text-dark">Chưa TT</span>'; ?>
                        </td>
                        <td class="text-center">
                            <?php 
                                $tt = $dh['trangthai_donhang'];
                                if($tt==0) echo '<span class="badge bg-secondary">Chờ xác nhận</span>';
                                elseif($tt==1) echo '<span class="badge bg-info text-dark">Đang xử lý</span>';
                                elseif($tt==2) echo '<span class="badge bg-primary">Đang giao</span>';
                                elseif($tt==3) echo '<span class="badge bg-success">Hoàn thành</span>';
                                else echo '<span class="badge bg-danger">Đã hủy</span>';
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php include("inc/bottom.php"); ?>

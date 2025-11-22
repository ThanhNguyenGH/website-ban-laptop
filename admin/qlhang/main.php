<?php include("../inc/top.php"); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (nếu có) -->
        <div class="col-md-12">
            <h3 class="text-primary mb-4">
                <i class="bi bi-building"></i> Quản lý hãng laptop
            </h3>

            <?php if ($thongbao) echo $thongbao; ?>

            <!-- Nút thêm mới -->
            <div class="mb-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalThem">
                    <i class="bi bi-plus-circle"></i> Thêm hãng mới
                </button>
            </div>

            <!-- Bảng danh sách hãng -->
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-info">Danh sách hãng laptop</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th width="80">ID</th>
                                    <th>Logo</th>
                                    <th>Tên hãng</th>
                                    <th>Mô tả</th>
                                    <th width="120">Sửa</th>
                                    <th width="120">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hangs as $h): ?>
                                    <?php if ($h["id"] == $idsua): // đang sửa ?>
                                        <tr class="table-warning">
                                            <form method="post">
                                                <input type="hidden" name="action" value="capnhat">
                                                <input type="hidden" name="id" value="<?php echo $h["id"]; ?>">
                                                <td><?php echo $h["id"]; ?></td>
                                                <td>
                                                    <input type="text" name="logo" class="form-control form-control-sm" 
                                                           value="<?php echo htmlspecialchars($h["logo"]); ?>" placeholder="logo_asus.png">
                                                </td>
                                                <td>
                                                    <input type="text" name="tenhang" class="form-control" 
                                                           value="<?php echo htmlspecialchars($h["tenhang"]); ?>" required>
                                                </td>
                                                <td>
                                                <td>
                                                    <textarea name="mota" class="form-control" rows="2"><?php echo htmlspecialchars($h["mota"]); ?></textarea>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-check-lg"></i> Lưu
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="index.php" class="btn btn-secondary btn-sm">
                                                        <i class="bi bi-x"></i> Hủy
                                                    </a>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td><strong><?php echo $h["id"]; ?></strong></td>
                                            <td>
                                                <?php if ($h["logo"]): ?>
                                                    <img src="../../images/brands/<?php echo $h["logo"]; ?>" 
                                                         alt="<?php echo $h["tenhang"]; ?>" width="80" class="rounded">
                                                <?php else: ?>
                                                    <span class="text-muted">Chưa có logo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($h["tenhang"]); ?></strong></td>
                                            <td><?php echo $h["mota"] ? nl2br(htmlspecialchars($h["mota"])) : "<em class='text-muted'>Chưa có mô tả</em>"; ?></td>
                                            <td>
                                                <a href="index.php?action=sua&id=<?php echo $h["id"]; ?>" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Sửa
                                                </a>
                                            </td>
                                            <td>
                                                <a href="index.php?action=xoa&id=<?php echo $h["id"]; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Xóa hãng \'<?php echo $h["tenhang"]; ?>\'?\nCảnh báo: Tất cả laptop thuộc hãng này cũng sẽ bị xóa!')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (empty($hangs)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Chưa có hãng nào. <a href="#" data-bs-toggle="modal" data-bs-target="#modalThem">Thêm ngay!</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm hãng mới -->
<div class="modal fade" id="modalThem" tabindex="-1">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Thêm hãng laptop mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="them">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên hãng <span class="text-danger">*</span></label>
                        <input type="text" name="tenhang" class="form-control" required placeholder="Ví dụ: Asus, Dell, MSI...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File logo (tên file)</label>
                        <input type="text" name="logo" class="form-control" placeholder="logo_asus.png">
                        <div class="form-text">Đặt file vào thư mục: public/images/brands/</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="mota" class="form-control" rows="3" placeholder="Nhập thông tin giới thiệu về hãng..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Thêm hãng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("../inc/bottom.php"); ?>
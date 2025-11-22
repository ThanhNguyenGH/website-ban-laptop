<?php
include("../inc/top.php");
require_once("../../model/database.php");
require_once("../../model/Donhang.php");

$dh = new DONHANG();

// Xử lý các action
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? 0;

    if ($action == 'xoa' && $id > 0) {
        $dh->xoadonhang($id);
        header("Location: index.php");
        exit;
    } elseif ($action == 'xuly' && $id > 0) {
        $dh->capnhattrangthai($id, 1); // 1: Đang xử lý
        header("Location: index.php");
        exit;
    } elseif ($action == 'giao' && $id > 0) {
        $dh->capnhattrangthai($id, 2); // 2: Đang giao
        header("Location: index.php");
        exit;
    } elseif ($action == 'hoanthanh' && $id > 0) {
        $dh->capnhattrangthai($id, 3); // 3: Hoàn thành
        $dh->capnhatthanhtoan($id, 1); // Đánh dấu đã thanh toán
        header("Location: index.php");
        exit;
    } elseif ($action == 'huy' && $id > 0) {
        $dh->capnhattrangthai($id, 4); // 4: Hủy
        header("Location: index.php");
        exit;
    }
}

$donhangs = $dh->laydonhang();

include("main.php");
?>
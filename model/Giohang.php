<?php
// Khởi tạo giỏ hàng
if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Thêm vào giỏ
function themvaogio($id, $soluong = 1) {
    if (isset($_SESSION['giohang'][$id])) {
        $_SESSION['giohang'][$id] += $soluong;
    } else {
        $_SESSION['giohang'][$id] = $soluong;
    }
}

// Cập nhật số lượng
function capnhatsoluong($id, $soluong) {
    if ($soluong <= 0) {
        unset($_SESSION['giohang'][$id]);
    } else {
        $_SESSION['giohang'][$id] = $soluong;
    }
}

// Xóa sản phẩm
function xoamotlaptop($id) {
    unset($_SESSION['giohang'][$id]);
}

function laygiohang() {
    if (empty($_SESSION['giohang'])) return [];

    $ids = array_keys($_SESSION['giohang']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    $db = DATABASE::connect();
    $sql = "SELECT 
                l.id, 
                l.tenlaptop, 
                l.giaban, 
                COALESCE(ha.hinhanh, 'images/laptops/default.jpg') AS hinhanh_chinh
            FROM laptop l
            LEFT JOIN laptop_hinhanh ha ON l.id = ha.laptop_id AND ha.anhchinh = 1
            WHERE l.id IN ($placeholders)";
    
    $cmd = $db->prepare($sql);
    $cmd->execute($ids);
    
    // Dùng FETCH_ASSOC thay vì FETCH_KEY_PAIR vì ta cần nhiều hơn 2 cột
    $rows = $cmd->fetchAll(PDO::FETCH_ASSOC);

    $gio = [];
    foreach ($rows as $row) {
        $id = $row['id'];
        $sl = $_SESSION['giohang'][$id] ?? 0;
        
        $gio[$id] = [
            'tenlaptop'     => $row['tenlaptop'],
            'giaban'        => $row['giaban'],
            'hinhanh_chinh' => $row['hinhanh_chinh'],
            'soluong'       => $sl,
            'thanhtien'     => $sl * $row['giaban']
        ];
    }
    return $gio;
}

function demsoluongtronggio() {
    return array_sum($_SESSION['giohang'] ?? []);
}

function tinhtiengiohang() {
    $tong = 0;
    foreach (laygiohang() as $item) {
        $tong += $item['thanhtien'];
    }
    return $tong;
}

function demhangtronggio() {
    return count($_SESSION['giohang']);
}

function xoagiohang() {
    unset($_SESSION['giohang']);
}
?>
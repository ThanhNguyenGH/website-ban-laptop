<?php
class DONHANG {
    private $id;
    private $nguoidung_id;
    private $diachi_id;
    private $ngay;
    private $tongtien;
    private $phuongthuc_thanhtoan;
    private $trangthai_thanhtoan; // 0: Chưa, 1: Đã
    private $trangthai_donhang;   // 0: Chờ xác nhận, 1: Đang xử lý, 2: Đang giao, 3: Hoàn thành, 4: Hủy
    private $ghichu;

    // Getter & Setter
    public function getid() { return $this->id; }
    public function setid($value) { $this->id = $value; }
    public function getnguoidung_id() { return $this->nguoidung_id; }
    public function setnguoidung_id($value) { $this->nguoidung_id = $value; }
    public function getdiachi_id() { return $this->diachi_id; }
    public function setdiachi_id($value) { $this->diachi_id = $value; }
    public function getngay() { return $this->ngay; }
    public function setngay($value) { $this->ngay = $value; }
    public function gettongtien() { return $this->tongtien; }
    public function settongtien($value) { $this->tongtien = $value; }
    public function getphuongthuc_thanhtoan() { return $this->phuongthuc_thanhtoan; }
    public function setphuongthuc_thanhtoan($value) { $this->phuongthuc_thanhtoan = $value; }
    public function gettrangthai_thanhtoan() { return $this->trangthai_thanhtoan; }
    public function settrangthai_thanhtoan($value) { $this->trangthai_thanhtoan = $value; }
    public function gettrangthai_donhang() { return $this->trangthai_donhang; }
    public function settrangthai_donhang($value) { $this->trangthai_donhang = $value; }
    public function getghichu() { return $this->ghichu; }
    public function setghichu($value) { $this->ghichu = $value; }

    // Lấy danh sách đơn hàng (Admin)
    public function laydonhang() {
        $db = DATABASE::connect();
        $sql = "SELECT dh.*, nd.hoten, nd.email 
                FROM donhang dh 
                JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                ORDER BY dh.id DESC";
        $cmd = $db->prepare($sql);
        $cmd->execute();
        return $cmd->fetchAll();
    }

    // Lấy đơn hàng của một người dùng (User)
    public function laydonhangnguoidung($nguoidung_id) {
        $db = DATABASE::connect();
        $sql = "SELECT * FROM donhang WHERE nguoidung_id = :nguoidung_id ORDER BY id DESC";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":nguoidung_id", $nguoidung_id);
        $cmd->execute();
        return $cmd->fetchAll();
    }

    // Lấy chi tiết đơn hàng theo ID
    public function laydonhangtheoid($id) {
        $db = DATABASE::connect();
        $sql = "SELECT dh.*, nd.hoten, nd.email, nd.sodienthoai, dc.diachi as diachi_giaohang
                FROM donhang dh 
                JOIN nguoidung nd ON dh.nguoidung_id = nd.id 
                LEFT JOIN diachi dc ON dh.diachi_id = dc.id
                WHERE dh.id = :id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $donhang = $cmd->fetch();

        if ($donhang) {
            // Lấy chi tiết sản phẩm
            $sql_ct = "SELECT ct.*, l.tenlaptop, (SELECT hinhanh FROM laptop_hinhanh WHERE laptop_id = l.id AND anhchinh=1 LIMIT 1) as hinhanh 
                       FROM donhangct ct 
                       JOIN laptop l ON ct.laptop_id = l.id 
                       WHERE ct.donhang_id = :id";
            $cmd_ct = $db->prepare($sql_ct);
            $cmd_ct->bindValue(":id", $id);
            $cmd_ct->execute();
            $donhang['chitiet'] = $cmd_ct->fetchAll();
        }
        return $donhang;
    }

    // Thêm đơn hàng mới
    public function themdonhang($donhang) {
        $db = DATABASE::connect();
        try {
            $sql = "INSERT INTO donhang(nguoidung_id, diachi_id, tongtien, phuongthuc_thanhtoan, trangthai_thanhtoan, trangthai_donhang, ghichu) 
                    VALUES(:nguoidung_id, :diachi_id, :tongtien, :phuongthuc_thanhtoan, :trangthai_thanhtoan, :trangthai_donhang, :ghichu)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":nguoidung_id", $donhang->nguoidung_id);
            $cmd->bindValue(":diachi_id", $donhang->diachi_id); // Có thể null nếu khách nhập địa chỉ trực tiếp vào ghi chú hoặc bảng khác (nhưng thiết kế DB có bảng diachi)
            $cmd->bindValue(":tongtien", $donhang->tongtien);
            $cmd->bindValue(":phuongthuc_thanhtoan", $donhang->phuongthuc_thanhtoan);
            $cmd->bindValue(":trangthai_thanhtoan", $donhang->trangthai_thanhtoan);
            $cmd->bindValue(":trangthai_donhang", $donhang->trangthai_donhang);
            $cmd->bindValue(":ghichu", $donhang->ghichu);
            $cmd->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Lỗi thêm đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function capnhattrangthai($id, $trangthai_donhang) {
        $db = DATABASE::connect();
        $sql = "UPDATE donhang SET trangthai_donhang = :trangthai WHERE id = :id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":trangthai", $trangthai_donhang);
        $cmd->bindValue(":id", $id);
        return $cmd->execute();
    }

    // Cập nhật trạng thái thanh toán
    public function capnhatthanhtoan($id, $trangthai_thanhtoan) {
        $db = DATABASE::connect();
        $sql = "UPDATE donhang SET trangthai_thanhtoan = :trangthai WHERE id = :id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":trangthai", $trangthai_thanhtoan);
        $cmd->bindValue(":id", $id);
        return $cmd->execute();
    }
    
    // Xóa đơn hàng
    public function xoadonhang($id) {
        $db = DATABASE::connect();
        $sql = "DELETE FROM donhang WHERE id = :id";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":id", $id);
        return $cmd->execute();
    }
}
?>

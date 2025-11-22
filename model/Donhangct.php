<?php
class DONHANGCT {
    private $id;
    private $donhang_id;
    private $laptop_id;
    private $dongia;
    private $soluong;
    private $thanhtien;

    // Getter & Setter
    public function getid() { return $this->id; }
    public function setid($value) { $this->id = $value; }
    public function getdonhang_id() { return $this->donhang_id; }
    public function setdonhang_id($value) { $this->donhang_id = $value; }
    public function getlaptop_id() { return $this->laptop_id; }
    public function setlaptop_id($value) { $this->laptop_id = $value; }
    public function getdongia() { return $this->dongia; }
    public function setdongia($value) { $this->dongia = $value; }
    public function getsoluong() { return $this->soluong; }
    public function setsoluong($value) { $this->soluong = $value; }
    public function getthanhtien() { return $this->thanhtien; }
    public function setthanhtien($value) { $this->thanhtien = $value; }

    // Thêm chi tiết đơn hàng
    public function themchitietdonhang($donhangct) {
        $db = DATABASE::connect();
        try {
            $sql = "INSERT INTO donhangct(donhang_id, laptop_id, dongia, soluong, thanhtien) 
                    VALUES(:donhang_id, :laptop_id, :dongia, :soluong, :thanhtien)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":donhang_id", $donhangct->donhang_id);
            $cmd->bindValue(":laptop_id", $donhangct->laptop_id);
            $cmd->bindValue(":dongia", $donhangct->dongia);
            $cmd->bindValue(":soluong", $donhangct->soluong);
            $cmd->bindValue(":thanhtien", $donhangct->thanhtien);
            $cmd->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Lỗi thêm chi tiết đơn hàng: " . $e->getMessage());
            return false;
        }
    }

    // Lấy chi tiết đơn hàng (đã được xử lý trong Donhang::laydonhangtheoid, nhưng giữ lại nếu cần dùng riêng)
    public function laychitietdonhang($donhang_id) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT ct.*, l.tenlaptop, (SELECT hinhanh FROM laptop_hinhanh WHERE laptop_id = l.id AND anhchinh=1 LIMIT 1) as hinhanh 
                    FROM donhangct ct 
                    JOIN laptop l ON ct.laptop_id = l.id 
                    WHERE ct.donhang_id = :donhang_id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":donhang_id", $donhang_id);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            error_log("Lỗi lấy chi tiết đơn hàng: " . $e->getMessage());
            return [];
        }
    }
}
?>
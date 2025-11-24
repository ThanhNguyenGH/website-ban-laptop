<?php

class LAPTOP {
    private $id;
    private $tenlaptop;
    private $slug;
    private $hang_id;
    private $dongmay_id;
    private $cpu;
    private $ram;
    private $o_cung;
    private $card_man_hinh;
    private $man_hinh;
    private $trong_luong;
    private $pin;
    private $cong_ket_noi;
    private $he_dieu_hanh;
    private $mota_chitiet;
    private $giagoc;
    private $giaban;
    private $soluongton;
    private $luotxem;
    private $luotmua;
    private $noibat;
    private $khuyenmai;
    private $hinhanh;

    // Getter & Setter (tất cả các trường)
    public function getid() { return $this->id; }
    public function setid($value) { $this->id = $value; }
    public function gettenlaptop() { return $this->tenlaptop; }
    public function settenlaptop($value) { $this->tenlaptop = $value; }
    public function getslug() { return $this->slug; }
    public function setslug($value) { $this->slug = $value; }
    public function gethang_id() { return $this->hang_id; }
    public function sethang_id($value) { $this->hang_id = $value; }
    public function getdongmay_id() { return $this->dongmay_id; }
    public function setdongmay_id($value) { $this->dongmay_id = $value; }
    public function getcpu() { return $this->cpu; }
    public function setcpu($value) { $this->cpu = $value; }
    public function getram() { return $this->ram; }
    public function setram($value) { $this->ram = $value; }
    public function geto_cung() { return $this->o_cung; }
    public function seto_cung($value) { $this->o_cung = $value; }
    public function getcard_man_hinh() { return $this->card_man_hinh; }
    public function setcard_man_hinh($value) { $this->card_man_hinh = $value; }
    public function getman_hinh() { return $this->man_hinh; }
    public function setman_hinh($value) { $this->man_hinh = $value; }
    public function gettrong_luong() { return $this->trong_luong; }
    public function settrong_luong($value) { $this->trong_luong = $value; }
    public function getpin() { return $this->pin; }
    public function setpin($value) { $this->pin = $value; }
    public function getcong_ket_noi() { return $this->cong_ket_noi; }
    public function setcong_ket_noi($value) { $this->cong_ket_noi = $value; }
    public function gethe_dieu_hanh() { return $this->he_dieu_hanh; }
    public function sethe_dieu_hanh($value) { $this->he_dieu_hanh = $value; }
    public function getmota_chitiet() { return $this->mota_chitiet; }
    public function setmota_chitiet($value) { $this->mota_chitiet = $value; }
    public function getgiagoc() { return $this->giagoc; }
    public function setgiagoc($value) { $this->giagoc = $value; }
    public function getgiaban() { return $this->giaban; }
    public function setgiaban($value) { $this->giaban = $value; }
    public function getsoluongton() { return $this->soluongton; }
    public function setsoluongton($value) { $this->soluongton = $value; }
    public function getluotxem() { return $this->luotxem; }
    public function setluotxem($value) { $this->luotxem = $value; }
    public function getluotmua() { return $this->luotmua; }
    public function setluotmua($value) { $this->luotmua = $value; }
    public function getnoibat() { return $this->noibat; }
    public function setnoibat($value) { $this->noibat = $value; }
    public function getkhuyenmai() { return $this->khuyenmai; }
    public function setkhuyenmai($value) { $this->khuyenmai = $value; }
    public function gethinhanh() { return $this->hinhanh; }
    public function sethinhanh($value) { $this->hinhanh = $value; }

    // Lấy tất cả laptop (có JOIN để lấy tên hãng, dòng máy)
    public function laylaptop() {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT l.*, h.tenhang, d.tendong 
                    FROM laptop l
                    LEFT JOIN hang h ON l.hang_id = h.id
                    LEFT JOIN dongmay d ON l.dongmay_id = d.id
                    ORDER BY l.id DESC";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi laylaptop(): $error</p>"; exit();
        }
    }

    // Lấy laptop theo hãng
    public function laylaptoptheohang($hang_id) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT l.*, h.tenhang, d.tendong FROM laptop l
                    LEFT JOIN hang h ON l.hang_id = h.id
                    LEFT JOIN dongmay d ON l.dongmay_id = d.id
                    WHERE l.hang_id = :hang_id ORDER BY l.id DESC";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":hang_id", $hang_id);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi laylaptoptheohang(): $error</p>"; exit();
        }
    }

    // Lấy laptop theo ID (chi tiết)
    public function laylaptoptheoid($id) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT l.*, h.tenhang, d.tendong FROM laptop l
                    LEFT JOIN hang h ON l.hang_id = h.id
                    LEFT JOIN dongmay d ON l.dongmay_id = d.id
                    WHERE l.id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return $cmd->fetch();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi laylaptoptheoid(): $error</p>"; exit();
        }
    }

    // Tăng lượt xem
    public function tangluotxem($id) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE laptop SET luotxem = luotxem + 1 WHERE id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi tangluotxem(): $error</p>"; exit();
        }
    }

    // Laptop nổi bật
    public function laylaptopnoibat() {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT l.*, h.tenhang FROM laptop l
                    LEFT JOIN hang h ON l.hang_id = h.id
                    WHERE l.noibat = 1 ORDER BY l.id DESC LIMIT 8";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi laylaptopnoibat(): $error</p>"; exit();
        }
    }

    // Laptop đang khuyến mãi
    public function laylaptopkhuyenmai() {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT l.*, h.tenhang FROM laptop l
                    LEFT JOIN hang h ON l.hang_id = h.id
                    WHERE l.khuyenmai = 1 ORDER BY l.id DESC LIMIT 8";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi laylaptopkhuyenmai(): $error</p>"; exit();
        }
    }

    // Thêm laptop mới
    public function themlaptop($laptop) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "INSERT INTO laptop(tenlaptop, slug, hang_id, dongmay_id, cpu, ram, o_cung, card_man_hinh, man_hinh, trong_luong, pin, cong_ket_noi, he_dieu_hanh, mota_chitiet, giagoc, giaban, soluongton, noibat, khuyenmai, hinhanh)
                    VALUES(:tenlaptop, :slug, :hang_id, :dongmay_id, :cpu, :ram, :o_cung, :card_man_hinh, :man_hinh, :trong_luong, :pin, :cong_ket_noi, :he_dieu_hanh, :mota_chitiet, :giagoc, :giaban, :soluongton, :noibat, :khuyenmai, :hinhanh)";
            $cmd = $dbcon->prepare($sql);
            
            // Tạo slug từ tên laptop
            $slug = $this->taoSlug($laptop->tenlaptop);
            
            $cmd->bindValue(":tenlaptop", $laptop->tenlaptop);
            $cmd->bindValue(":slug", $slug);
            $cmd->bindValue(":hang_id", $laptop->hang_id);
            $cmd->bindValue(":dongmay_id", $laptop->dongmay_id ?? null, PDO::PARAM_INT);
            $cmd->bindValue(":cpu", $laptop->cpu ?? "");
            $cmd->bindValue(":ram", $laptop->ram ?? "");
            $cmd->bindValue(":o_cung", $laptop->o_cung ?? "");
            $cmd->bindValue(":card_man_hinh", $laptop->card_man_hinh ?? "");
            $cmd->bindValue(":man_hinh", $laptop->man_hinh ?? "");
            $cmd->bindValue(":trong_luong", $laptop->trong_luong ?? "");
            $cmd->bindValue(":pin", $laptop->pin ?? "");
            $cmd->bindValue(":cong_ket_noi", $laptop->cong_ket_noi ?? "");
            $cmd->bindValue(":he_dieu_hanh", $laptop->he_dieu_hanh ?? "");
            $cmd->bindValue(":mota_chitiet", $laptop->mota_chitiet ?? "");
            $cmd->bindValue(":giagoc", $laptop->giagoc ?? 0);
            $cmd->bindValue(":giaban", $laptop->giaban ?? 0);
            $cmd->bindValue(":soluongton", $laptop->soluongton ?? 0);
            $cmd->bindValue(":noibat", $laptop->noibat ?? 0);
            $cmd->bindValue(":khuyenmai", $laptop->khuyenmai ?? 0);
            $cmd->bindValue(":hinhanh", $laptop->hinhanh ?? "");
            $cmd->execute();
            return $dbcon->lastInsertId();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi themlaptop(): $error</p>"; exit();
        }
    }

    // Sửa laptop
    public function sualaptop($laptop) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE laptop SET tenlaptop=:tenlaptop, slug=:slug, hang_id=:hang_id, dongmay_id=:dongmay_id,
                    cpu=:cpu, ram=:ram, o_cung=:o_cung, card_man_hinh=:card_man_hinh, man_hinh=:man_hinh,
                    trong_luong=:trong_luong, pin=:pin, cong_ket_noi=:cong_ket_noi, he_dieu_hanh=:he_dieu_hanh,
                    mota_chitiet=:mota_chitiet, giagoc=:giagoc, giaban=:giaban, soluongton=:soluongton,
                    luotxem=:luotxem, luotmua=:luotmua, noibat=:noibat, khuyenmai=:khuyenmai, hinhanh=:hinhanh 
                    WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            
            // Tạo slug từ tên laptop
            $slug = $this->taoSlug($laptop->tenlaptop);
            
            $cmd->bindValue(":id", $laptop->id);
            $cmd->bindValue(":tenlaptop", $laptop->tenlaptop);
            $cmd->bindValue(":slug", $slug);
            $cmd->bindValue(":hang_id", $laptop->hang_id);
            $cmd->bindValue(":dongmay_id", $laptop->dongmay_id ?? null, PDO::PARAM_INT);
            $cmd->bindValue(":cpu", $laptop->cpu ?? "");
            $cmd->bindValue(":ram", $laptop->ram ?? "");
            $cmd->bindValue(":o_cung", $laptop->o_cung ?? "");
            $cmd->bindValue(":card_man_hinh", $laptop->card_man_hinh ?? "");
            $cmd->bindValue(":man_hinh", $laptop->man_hinh ?? "");
            $cmd->bindValue(":trong_luong", $laptop->trong_luong ?? "");
            $cmd->bindValue(":pin", $laptop->pin ?? "");
            $cmd->bindValue(":cong_ket_noi", $laptop->cong_ket_noi ?? "");
            $cmd->bindValue(":he_dieu_hanh", $laptop->he_dieu_hanh ?? "");
            $cmd->bindValue(":mota_chitiet", $laptop->mota_chitiet ?? "");
            $cmd->bindValue(":giagoc", $laptop->giagoc ?? 0);
            $cmd->bindValue(":giaban", $laptop->giaban ?? 0);
            $cmd->bindValue(":soluongton", $laptop->soluongton ?? 0);
            $cmd->bindValue(":luotxem", $laptop->luotxem ?? 0);
            $cmd->bindValue(":luotmua", $laptop->luotmua ?? 0);
            $cmd->bindValue(":noibat", $laptop->noibat ?? 0);
            $cmd->bindValue(":khuyenmai", $laptop->khuyenmai ?? 0);
            $cmd->bindValue(":hinhanh", $laptop->hinhanh ?? "");
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi sualaptop(): $error</p>"; exit();
        }
    }

    // Xóa laptop
    public function xoalaptop($laptop) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "DELETE FROM laptop WHERE id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $laptop->id);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi xoalaptop(): $error</p>"; exit();
        }
    }

    // Cập nhật số lượng tồn khi đặt hàng
    public function capnhatsoluong($id, $soluong) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE laptop SET soluongton = soluongton - :soluong WHERE id = :id AND soluongton >= :soluong";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":soluong", $soluong);
            $cmd->bindValue(":id", $id);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi capnhatsoluong(): $error</p>"; exit();
        }
    }

    // Hàm tạo slug từ tên laptop
    private function taoSlug($str) {
        // Chuyển về chữ thường
        $str = mb_strtolower($str, 'UTF-8');
        
        // Chuyển ký tự có dấu thành không dấu
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        
        // Xóa các ký tự đặc biệt
        $str = preg_replace("/[^a-z0-9-\s]/", '', $str);
        
        // Xóa khoảng trắng thay bằng ký tự -
        $str = preg_replace('/([\s]+)/', '-', $str);
        
        return $str;
    }
    // Tìm kiếm laptop theo tên ---
    public function timkiemlaptop($tukhoa){
        $db = DATABASE::connect();
        try{
            $sql = "SELECT * FROM laptop WHERE tenlaptop LIKE :tukhoa";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":tukhoa", "%$tukhoa%");
            $cmd->execute();
            return $cmd->fetchAll();
        }
        catch(PDOException $e){
            $error_message = $e->getMessage();
            echo "<p>Lỗi truy vấn: $error_message</p>";
            exit();
        }
    }
    // --- Lấy laptop có sắp xếp ---
    public function laylaptop_sapxep($kieusapxep){
        // Kiểm tra an toàn để tránh SQL Injection
        $allowed = ['ASC', 'DESC'];
        $order = in_array($kieusapxep, $allowed) ? $kieusapxep : 'ASC';

        $db = DATABASE::connect();
        try{
            $sql = "SELECT * FROM laptop ORDER BY giaban $order";
            $cmd = $db->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        }
        catch(PDOException $e){
            echo "<p>Lỗi truy vấn: ".$e->getMessage()."</p>";
            exit();
        }
    }
}
?>

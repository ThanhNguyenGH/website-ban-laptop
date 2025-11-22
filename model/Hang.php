<?php
class HANG {
    private $id;
    private $tenhang;
    private $logo;
    private $mota;

    // Getter & Setter
    public function getid() { return $this->id; }
    public function setid($value) { $this->id = $value; }
    public function gettenhang() { return $this->tenhang; }
    public function settenhang($value) { $this->tenhang = $value; }
    public function getlogo() { return $this->logo; }
    public function setlogo($value) { $this->logo = $value; }
    public function getmota() { return $this->mota; }
    public function setmota($value) { $this->mota = $value; }

    // Lấy danh sách hãng
    public function layhang() {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT * FROM hang ORDER BY tenhang ASC";
            $cmd = $dbcon->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi truy vấn (HANG): $error</p>"; exit();
        }
    }

    // Lấy hãng theo id
    public function layhangtheoid($id) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "SELECT * FROM hang WHERE id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return $cmd->fetch();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi truy vấn (HANG): $error</p>"; exit();
        }
    }

    // Thêm hãng
    public function themhang($hang) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "INSERT INTO hang(tenhang, logo, mota) VALUES(:tenhang, :logo, :mota)";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenhang", $hang->tenhang);
            $cmd->bindValue(":logo", $hang->logo);
            $cmd->bindValue(":mota", $hang->mota);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi thêm hãng: $error</p>"; exit();
        }
    }

    // Sửa hãng
    public function suahang($hang) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "UPDATE hang SET tenhang=:tenhang, logo=:logo, mota=:mota WHERE id=:id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":tenhang", $hang->tenhang);
            $cmd->bindValue(":logo", $hang->logo);
            $cmd->bindValue(":mota", $hang->mota);
            $cmd->bindValue(":id", $hang->id);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi sửa hãng: $error</p>"; exit();
        }
    }

    // Xóa hãng
    public function xoahang($hang) {
        $dbcon = DATABASE::connect();
        try {
            $sql = "DELETE FROM hang WHERE id = :id";
            $cmd = $dbcon->prepare($sql);
            $cmd->bindValue(":id", $hang->id);
            return $cmd->execute();
        } catch(PDOException $e) {
            $error = $e->getMessage();
            echo "<p>Lỗi xóa hãng: $error</p>"; exit();
        }
    }
}
?>
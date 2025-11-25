<?php
class DANHGIA {
    // Lấy đánh giá của một laptop
    public function laydanhgia($laptop_id) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT d.*, n.hoten, n.hinhanh FROM danhgia d 
                    JOIN nguoidung n ON d.nguoidung_id = n.id 
                    WHERE d.laptop_id = :laptop_id AND d.trangthai = 1 
                    ORDER BY d.ngaydanhgia DESC";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":laptop_id", $laptop_id);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    // Thêm đánh giá mới
    public function themdanhgia($laptop_id, $nguoidung_id, $diem, $noidung) {
        $db = DATABASE::connect();
        try {
            $sql = "INSERT INTO danhgia (laptop_id, nguoidung_id, diem, noidung, trangthai) 
                    VALUES (:laptop_id, :nguoidung_id, :diem, :noidung, 1)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":laptop_id", $laptop_id);
            $cmd->bindValue(":nguoidung_id", $nguoidung_id);
            $cmd->bindValue(":diem", $diem);
            $cmd->bindValue(":noidung", $noidung);
            return $cmd->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Tính điểm trung bình sao
    public function tinhdiemtrungbinh($laptop_id) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT AVG(diem) as diemtb FROM danhgia WHERE laptop_id = :laptop_id AND trangthai=1";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":laptop_id", $laptop_id);
            $cmd->execute();
            $result = $cmd->fetch();
            return $result ? round($result['diemtb'], 1) : 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?>

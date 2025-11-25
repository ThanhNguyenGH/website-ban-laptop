<?php
class TINTUC {
    private $id;
    private $tieude;
    private $slug;
    private $tomtat;
    private $noidung;
    private $hinhanh;
    private $ngaydang;
    private $trangthai;

    public function getid(){ return $this->id; }
    public function gettieude(){ return $this->tieude; }
    public function getslug(){ return $this->slug; }
    public function gettomtat(){ return $this->tomtat; }
    public function getnoidung(){ return $this->noidung; }
    public function gethinhanh(){ return $this->hinhanh; }
    public function getngaydang(){ return $this->ngaydang; }

    // Lấy danh sách tin tức mới nhất
    public function laytintuc($limit = 10) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT * FROM tintuc WHERE trangthai = 1 ORDER BY ngaydang DESC LIMIT :limit";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":limit", $limit, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage(); return [];
        }
    }

    // Lấy chi tiết tin tức theo ID
    public function laytintuCT($id) {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT * FROM tintuc WHERE id = :id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return $cmd->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage(); return null;
        }
    }
}
?>

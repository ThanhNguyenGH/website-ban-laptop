<?php
class LIENHE {
    public function themlienhe($email, $sdt, $noidung) {
        $db = DATABASE::connect();
        try {
            $sql = "INSERT INTO lienhe (email, sodienthoai, noidung) VALUES (:email, :sdt, :noidung)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":email", $email);
            $cmd->bindValue(":sdt", $sdt);
            $cmd->bindValue(":noidung", $noidung);
            return $cmd->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function laylienhe() {
        $db = DATABASE::connect();
        try {
            $sql = "SELECT * FROM lienhe ORDER BY ngaygui DESC";
            $cmd = $db->prepare($sql);
            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $e) { return []; }
    }
}
?>

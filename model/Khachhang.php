<?php
class KHACHHANG
{

	// Thêm khách hàng mới, trả về khóa của dòng mới thêm
	public function themkhachhang($email, $sodt, $hoten)
	{
		$db = DATABASE::connect();
		try {
			$matkhau_ngau_nhien = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
			$hash = password_hash($matkhau_ngau_nhien, PASSWORD_BCRYPT, ["cost" => 12]);
			$sql = "INSERT INTO nguoidung(email,matkhau,sodienthoai,hoten,loai,trangthai) VALUES(:email,:matkhau,:sodt,:hoten,3,1)";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email', $email);
			$cmd->bindValue(':matkhau', $hash);
			$cmd->bindValue(':sodt', $sodt);
			$cmd->bindValue(':hoten', $hoten);
			$cmd->execute();
			$id = $db->lastInsertId();
			return $id;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	public function kiemtrakhachhanghople($email, $matkhau_nhap)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung 
                    WHERE email = :email AND loai = 3 AND trangthai = 1";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->execute();

			$user = $cmd->fetch();

			if ($user && password_verify($matkhau_nhap, $user['matkhau'])) {
				return true;
			}
			return false;
		} catch (PDOException $e) {
			echo "<p>Lỗi kiểm tra đăng nhập: " . $e->getMessage() . "</p>";
			exit();
		}
	}

	// lấy thông tin người dùng có $email
	public function laythongtinkhachhang($email)
	{
		$db = DATABASE::connect();
		try {
			$sql = "SELECT * FROM nguoidung WHERE email=:email AND loai=3";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->execute();
			$ketqua = $cmd->fetch();
			$cmd->closeCursor();
			return $ketqua;
		} catch (PDOException $e) {
			$error_message = $e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
}

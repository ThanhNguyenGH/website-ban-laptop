<?php
class NGUOIDUNG{
	private $id;
    private $email;
    private $sodienthoai;
    private $matkhau;
    private $hoten;
    private $trangthai;
    private $loai;
    private $hinhanh;    

    public function getid(){ return $this->id; }
    public function setid($value){ $this->id = $value; }
    public function getemail(){ return $this->email; }
    public function setemail($value){ $this->email = $value; }
    public function getsodienthoai(){ return $this->sodienthoai; }
    public function setsodienthoai($value){ $this->sodienthoai = $value; }
    public function getmatkhau(){ return $this->matkhau; }
    public function setmatkhau($value){ $this->matkhau = $value; }
    public function gethoten(){ return $this->hoten; }
    public function sethoten($value){ $this->hoten = $value; }
    public function gettrangthai(){ return $this->trangthai; }
    public function settrangthai($value){ $this->trangthai = $value; }
    public function getloai(){ return $this->loai; }
    public function setloai($value){ $this->loai = $value; }
    public function gethinhanh(){ return $this->hinhanh; }
    public function sethinhanh($value){ $this->hinhanh = $value; }
	
    public function kiemtranguoidunghople($email, $matkhau){
        $db = DATABASE::connect();
        try{
            $sql = "SELECT * FROM nguoidung WHERE email = :email AND trangthai = 1";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(":email", $email);
            $cmd->execute();
            $user = $cmd->fetch();

            if ($user && password_verify($matkhau, $user["matkhau"])) {
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            echo "<p>Lỗi truy vấn: ".$e->getMessage()."</p>";
            exit();
        }
    }

    public function doimatkhau($email, $matkhaumoi){
        $db = DATABASE::connect();
        try{
            $hash = password_hash($matkhaumoi, PASSWORD_BCRYPT, ["cost" => 12]);
            $sql = "UPDATE nguoidung SET matkhau = :matkhau WHERE email = :email";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':email', $email);
            $cmd->bindValue(':matkhau', $hash);
            return $cmd->execute();
        }
        catch(PDOException $e){
            echo "<p>Lỗi đổi mật khẩu: ".$e->getMessage()."</p>";
            exit();
        }
    }

    // THÊM NGƯỜI DÙNG MỚI – tự động dùng bcrypt cost 12
    public function themnguoidung($email,$matkhau,$sodt,$hoten,$loai=2){
        $db = DATABASE::connect();
        try{
            $hash = password_hash($matkhau, PASSWORD_BCRYPT, ["cost" => 12]);
            $sql = "INSERT INTO nguoidung(email,matkhau,sodienthoai,hoten,loai,trangthai) 
                    VALUES(:email,:matkhau,:sodt,:hoten,:loai,1)";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':email',$email);
            $cmd->bindValue(':matkhau',$hash);
            $cmd->bindValue(':sodt',$sodt);
            $cmd->bindValue(':hoten',$hoten);
            $cmd->bindValue(':loai',$loai);
            $cmd->execute();
            return $db->lastInsertId();
        }
        catch(PDOException $e){
            echo "<p>Lỗi thêm người dùng: ".$e->getMessage()."</p>";
            exit();
        }
    }
	
	// lấy thông tin người dùng có $email
	public function laythongtinnguoidung($email){
		$db = DATABASE::connect();
		try{
			$sql = "SELECT * FROM nguoidung WHERE email=:email";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(":email", $email);
			$cmd->execute();
			$ketqua = $cmd->fetch();
			$cmd->closeCursor();
			return $ketqua;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
	
	// lấy tất cả ng dùng
	public function laydanhsachnguoidung(){
		$db = DATABASE::connect();
		try{
			$sql = "SELECT * FROM nguoidung";
			$cmd = $db->prepare($sql);			
			$cmd->execute();
			$ketqua = $cmd->fetchAll();			
			return $ketqua;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}


	public function capnhatnguoidung($id,$email,$sodt,$hoten,$hinhanh){
		$db = DATABASE::connect();
		try{
			$sql = "UPDATE nguoidung set hoten=:hoten, email=:email, sodienthoai=:sodt, hinhanh=:hinhanh where id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id',$id);
			$cmd->bindValue(':email',$email);
			$cmd->bindValue(':sodt',$sodt);
			$cmd->bindValue(':hoten',$hoten);
			$cmd->bindValue(':hinhanh',$hinhanh);
			$ketqua = $cmd->execute();            
            return $ketqua;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Đổi quyền (loại người dùng: 1 quản trị, 2 nhân viên. Không cần nâng cấp quyền đối với loại người dùng 3-khách hàng)
	public function doiloainguoidung($email,$loai){
		$db = DATABASE::connect();
		try{
			$sql = "UPDATE nguoidung set loai=:loai where email=:email";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':email',$email);
			$cmd->bindValue(':loai',$loai);
			$ketqua = $cmd->execute();            
            return $ketqua;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}

	// Đổi trạng thái (0 khóa, 1 kích hoạt)
	public function doitrangthai($id,$trangthai){
		$db = DATABASE::connect();
		try{
			$sql = "UPDATE nguoidung set trangthai=:trangthai where id=:id";
			$cmd = $db->prepare($sql);
			$cmd->bindValue(':id',$id);
			$cmd->bindValue(':trangthai',$trangthai);
			$ketqua = $cmd->execute();            
            return $ketqua;
		}
		catch(PDOException $e){
			$error_message=$e->getMessage();
			echo "<p>Lỗi truy vấn: $error_message</p>";
			exit();
		}
	}
}
?>

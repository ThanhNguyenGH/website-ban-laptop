<?php 
session_start();
if(!isset($_SESSION["nguoidung"]))
    header("location:../index.php");

require("../../model/database.php");
require("../../model/Hang.php");
require("../../model/Laptop.php");

// Xét xem có thao tác nào được chọn
if(isset($_REQUEST["action"])){
    $action = $_REQUEST["action"];
}
else{
    $action="xem";
}

$hangModel = new HANG();
$laptopModel = new LAPTOP();

switch($action){
    case "xem":
        $laptops = $laptopModel->laylaptop();
		include("main.php");
        break;
	case "them":
		$hangs = $hangModel->layhang();
		include("addform.php");
        break;
	case "xulythem":	
		// xử lý file upload
		$hinhanh = "images/laptops/" . basename($_FILES["filehinhanh"]["name"]); // đường dẫn ảnh lưu trong db
		$duongdan = "../../" . $hinhanh; // nơi lưu file upload (đường dẫn tính theo vị trí hiện hành)
		move_uploaded_file($_FILES["filehinhanh"]["tmp_name"], $duongdan);
		// xử lý thêm		
        $laptop = new LAPTOP();
		$laptop->settenlaptop($_POST["txttenlaptop"]);
		$laptop->sethang_id($_POST["opthang"]);
		$laptop->setcpu($_POST["txtcpu"] ?? "");
		$laptop->setram($_POST["txtram"] ?? "");
		$laptop->seto_cung($_POST["txto_cung"] ?? "");
		$laptop->setcard_man_hinh($_POST["txtcard_man_hinh"] ?? "");
		$laptop->setman_hinh($_POST["txtman_hinh"] ?? "");
		$laptop->setmota_chitiet($_POST["txtmota"] ?? "");
		$laptop->setgiagoc($_POST["txtgiagoc"]);
		$laptop->setgiaban($_POST["txtgiaban"]);
		$laptop->setsoluongton($_POST["txtsoluong"]);
        $laptop->sethinhanh($hinhanh);
		$laptopModel->themlaptop($laptop);
		$laptops = $laptopModel->laylaptop();
		include("main.php");
        break;
	case "xoa":
		if(isset($_GET["id"])){
            $laptop = new LAPTOP();        
            $laptop->setid($_GET["id"]);
			$laptopModel->xoalaptop($laptop);
        }
		$laptops = $laptopModel->laylaptop();
		include("main.php");
		break;	
    case "chitiet":
        if(isset($_GET["id"])){ 
            $m = $laptopModel->laylaptoptheoid($_GET["id"]);            
            include("detail.php");
        }
        else{
            $laptops = $laptopModel->laylaptop();        
            include("main.php");            
        }
        break;
    case "sua":
        if(isset($_GET["id"])){ 
            $m = $laptopModel->laylaptoptheoid($_GET["id"]);
            $hangs = $hangModel->layhang(); 
            include("updateform.php");
        }
        else{
            $laptops = $laptopModel->laylaptop();        
            include("main.php");            
        }
        break;
    case "xulysua":
        $laptop = new LAPTOP();
        $laptop->setid($_POST["txtid"]);
        $laptop->sethang_id($_POST["opthang"]);
        $laptop->settenlaptop($_POST["txttenlaptop"]);
        $laptop->setcpu($_POST["txtcpu"] ?? "");
        $laptop->setram($_POST["txtram"] ?? "");
        $laptop->seto_cung($_POST["txto_cung"] ?? "");
        $laptop->setcard_man_hinh($_POST["txtcard_man_hinh"] ?? "");
        $laptop->setman_hinh($_POST["txtman_hinh"] ?? "");
        $laptop->setmota_chitiet($_POST["txtmota"] ?? "");
        $laptop->setgiagoc($_POST["txtgiagoc"]);
        $laptop->setgiaban($_POST["txtgiaban"]);
        $laptop->setsoluongton($_POST["txtsoluongton"]);
        $laptop->setluotxem($_POST["txtluotxem"]);
        $laptop->setluotmua($_POST["txtluotmua"]);
        $laptop->sethinhanh($_POST["txthinhcu"]);

        // upload file mới (nếu có)
        if($_FILES["filehinhanh"]["name"]!=""){
            // xử lý file upload -- Cần bổ dung kiểm tra: dung lượng, kiểu file, ...       
            $hinhanh = "images/laptops/" . basename($_FILES["filehinhanh"]["name"]);// đường dẫn lưu csdl
            $laptop->sethinhanh($hinhanh);
            $duongdan = "../../" . $hinhanh; // đường dẫn lưu upload file        
            move_uploaded_file($_FILES["filehinhanh"]["tmp_name"], $duongdan);
        }
        
        // sửa laptop
        $laptopModel->sualaptop($laptop);         
    
        // hiển thị ds laptop
        $laptops = $laptopModel->laylaptop();    
        include("main.php");
        break;

    default:
        break;
}
?>

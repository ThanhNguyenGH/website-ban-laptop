<?php
session_start();
require("../model/Database.php");
require("../model/Hang.php");
require("../model/Laptop.php");
require("../model/Giohang.php");
// require("../model/DongMay.php");
// require("../model/MucDich.php");
require("../model/Common.php");
require("../model/Khachhang.php");
require("../model/Diachi.php");
require("../model/Donhang.php");
require("../model/Donhangct.php");
require("../model/Nguoidung.php"); 

// Khởi tạo các đối tượng model
$hangModel     = new HANG();
$laptopModel   = new LAPTOP();
$khachhangModel = new KHACHHANG();
$diachiModel   = new DIACHI();
$donhangModel  = new DONHANG();
$donhangctModel = new DONHANGCT();
$tintucModel = new TINTUC();
$danhgiaModel = new DANHGIA();

// Dữ liệu chung cho header (hiển thị ở mọi trang)
$hangs           = $hangModel->layhang();           // Tất cả hãng
$laptop_noibat   = $laptopModel->laylaptopnoibat(); // Laptop nổi bật

// Xác định action
$action = $_REQUEST["action"] ?? "trangchu";

switch ($action) {

    // =============================================
    // Trang chủ
    // =============================================
    case "trangchu":
        // Kiểm tra nếu có yêu cầu sắp xếp
        if (isset($_GET['sort'])) {
            $kieu = $_GET['sort']; // 'ASC' hoặc 'DESC'
            $laptops = $laptopModel->laylaptop_sapxep($kieu);
        } else {
            // Mặc định
            $laptops = $laptopModel->laylaptop();
        }
        include("main.php");
        break;

    // =============================================
    // Xem laptop theo hãng (thay cho group cũ)
    // =============================================
    case "hang":
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $hang_id = (int)$_GET["id"];
            $hang = $hangModel->layhangtheoid($hang_id);
            $tenhang = $hang ? $hang["tenhang"] : "Hãng không tồn tại";
            $laptops = $laptopModel->laylaptoptheohang($hang_id);
            $title = "Laptop $tenhang";
            include("group.php");
        } else {
            $laptops = $laptopModel->laylaptop();
            include("main.php");
        }
        break;

    // =============================================
    // Chi tiết laptop
    // =============================================
    case "chitiet":
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = (int)$_GET["id"];

            // Tăng lượt xem
            $laptopModel->tangluotxem($id);

            // Lấy thông tin chi tiết laptop
            $laptop = $laptopModel->laylaptoptheoid($id);
            if (!$laptop) {
                include("main.php");
                break;
            }

            // Lấy các laptop cùng hãng để gợi ý
            $laptop_cung_hang = $laptopModel->laylaptoptheohang($laptop["hang_id"]);
            
            include("detail.php");
        } else {
            include("main.php");
        }
        break;

    // =============================================
    // Thêm vào giỏ hàng
    // =============================================
    case "chovaogio":
        if (!isset($_REQUEST["id"]) || !is_numeric($_REQUEST["id"])) {
            header("Location: index.php");
            exit();
        }

        $id = (int)$_REQUEST["id"];
        $soluong = isset($_REQUEST["soluong"]) ? max(1, (int)$_REQUEST["soluong"]) : 1;

        if (isset($_SESSION['giohang'][$id])) {
            $_SESSION['giohang'][$id] += $soluong;
        } else {
            $_SESSION['giohang'][$id] = $soluong;
        }

        // Cập nhật lại giỏ hàng để hiển thị
        $_SESSION['thongbao'] = "Đã thêm sản phẩm vào giỏ hàng thành công!";
        
        $giohang = laygiohang();
        include("cart.php");
        break;
    // =============================================
    // Xem giỏ hàng
    // =============================================
    case "giohang":
        $giohang = laygiohang();
        include("cart.php");
        break;

    // =============================================
    // Lọc theo giá (Thêm mới)
    // =============================================
    case "locgia":
        $min = isset($_GET['min']) ? $_GET['min'] : 0;
        $max = isset($_GET['max']) ? $_GET['max'] : 9999999999;
        $laptops = $laptopModel->laylaptop_theo_gia($min, $max);
        include("main.php");
        break;

    // =============================================
    // Cập nhật số lượng trong giỏ
    // =============================================
    case "capnhatgio":
        if (isset($_POST["mh"]) && is_array($_POST["mh"])) {
            foreach ($_POST["mh"] as $id => $sl) {
                $sl = (int)$sl;
                if ($sl <= 0) {
                    xoamotlaptop($id);
                } else {
                    capnhatsoluong($id, $sl);
                }
            }
        }
        $giohang = laygiohang();
        include("cart.php");
        break;

    // =============================================
    // Xóa toàn bộ giỏ hàng
    // =============================================
    case "xoagiohang":
        xoagiohang();
        $giohang = laygiohang();
        include("cart.php");
        break;
    // --- MODULE TIN TỨC ---
    case "tintuc":
        $dstintuc = $tintucModel->laytintuc();
        include("news.php");
        break;
    
    case "chitiettintuc":
        if(isset($_GET['id'])){
            $tintuc = $tintucModel->laytintuCT($_GET['id']);
            include("news_detail.php");
        }
        break;
    
    // --- MODULE LỊCH SỬ ĐƠN HÀNG ---
    case "lichsu":
        if(!isset($_SESSION['khachhang'])){
            header("Location: index.php?action=dangnhap");
            exit();
        }
        // Bạn cần thêm hàm laydonhangcuakhach trong Model Donhang nhé
        // $donhangs = $donhangModel->laydonhangcuakhach($_SESSION['khachhang']['id']); 
        // Tạm thời để trống hoặc code hàm đó sau
        include("history.php");
        break;
    
    // --- MODULE GỬI ĐÁNH GIÁ ---
    case "guidanhgia":
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['khachhang'])){
                $laptop_id = $_POST['laptop_id'];
                $nguoidung_id = $_SESSION['khachhang']['id'];
                $diem = $_POST['diem'];
                $noidung = $_POST['noidung'];
                $danhgiaModel->themdanhgia($laptop_id, $nguoidung_id, $diem, $noidung);
                header("Location: index.php?action=chitiet&id=$laptop_id");
            } else {
                $_SESSION['thongbao'] = "Vui lòng đăng nhập để đánh giá!";
                header("Location: index.php?action=dangnhap");
            }
        }
        break;

    // --- MODULE LIÊN HỆ ---
    case "lienhe":
        include("contact.php");
        break;
    
    case "xulylienhe":
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $sdt = $_POST['sodienthoai'];
            $noidung = $_POST['noidung'];
            
            require("../model/Lienhe.php");
            $lienheModel = new LIENHE();
            if($lienheModel->themlienhe($email, $sdt, $noidung)){
                echo "<script>alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Lỗi gửi liên hệ!'); history.back();</script>";
            }
        }
        break;

    
    // =============================================
    // Thanh toán
    // =============================================
    case "thanhtoan":
        if (empty(laygiohang())) {
            header("Location: index.php");
            exit();
        }
        $giohang = laygiohang();
        include("checkout.php");
        break;

    // =============================================
    // Lưu đơn hàng sau khi thanh toán
    // =============================================
    case "luudonhang":
        if (empty(laygiohang())) {
            header("Location: index.php");
            exit();
        }

        $diachi = trim($_POST["txtdiachi"] ?? "");
        $email   = trim($_POST["txtemail"] ?? "");
        $hoten   = trim($_POST["txthoten"] ?? "");
        $sodienthoai = trim($_POST["txtsodienthoai"] ?? "");
        $thanhtoan = $_POST["optthanhtoan"] ?? "COD";
        $ghichu = $_POST["txtghichu"] ?? "";

        if (empty($diachi)) {
            $thongbao = "Vui lòng điền địa chỉ giao hàng!";
            $giohang = laygiohang();
            include("checkout.php");
            break;
        }

        $khachhang_id = null;

        // Nếu đã đăng nhập → lấy ID
        if (isset($_SESSION["khachhang"])) {
            $khachhang_id = $_SESSION["khachhang"]["id"];
        } else {
            // Nếu chưa đăng nhập
            if (empty($email) || empty($hoten) || empty($sodienthoai)) {
                $thongbao = "Vui lòng điền đầy đủ thông tin khách hàng!";
                $giohang = laygiohang();
                include("checkout.php");
                break;
            }

            // Kiểm tra email có tồn tại chưa
            $kh = $khachhangModel->laythongtinkhachhang($email);
            if ($kh) {
                $khachhang_id = $kh["id"];
            } else {
                // Tạo khách hàng mới
                $new_kh = new KHACHHANG();
                $new_kh->setemail($email);
                $new_kh->setsdt($sodienthoai);
                $new_kh->setten($hoten);
                $new_kh->setmatkhau("123456"); // Mật khẩu mặc định
                $new_kh->setdiachi($diachi);
                $khachhang_id = $khachhangModel->themkhachhang($new_kh);
            }
        }

        // Lưu địa chỉ giao hàng (nếu cần thiết, hoặc dùng địa chỉ của khách hàng)
        $diachi_id = $diachiModel->themdiachi($khachhang_id, $diachi);

        // Tạo đơn hàng
        $tongtien = tinhtiengiohang();
        
        $donhang = new DONHANG();
        $donhang->setnguoidung_id($khachhang_id);
        $donhang->setdiachi_id($diachi_id);
        $donhang->settongtien($tongtien);
        $donhang->setphuongthuc_thanhtoan($thanhtoan);
        $donhang->settrangthai_thanhtoan(0); // Chưa thanh toán
        $donhang->settrangthai_donhang(0);   // Chờ xác nhận
        $donhang->setghichu($ghichu);
        
        $donhang_id = $donhangModel->themdonhang($donhang);

        // Lưu chi tiết đơn hàng + giảm số lượng tồn
        $giohang = laygiohang();
        foreach ($giohang as $id => $sp) {
            $ct = new DONHANGCT();
            $ct->setdonhang_id($donhang_id);
            $ct->setlaptop_id($id);
            $ct->setdongia($sp["giaban"]);
            $ct->setsoluong($sp["soluong"]);
            $ct->setthanhtien($sp["thanhtien"]);
            
            $donhangctModel->themchitietdonhang($ct);
            
            // Giảm số lượng tồn kho
            $laptopModel->capnhatsoluong($id, $sp["soluong"]);
        }

        // Xóa giỏ hàng
        xoagiohang();

        // Chuyển đến trang cảm ơn
        $madonhang = $donhang_id;
        include("message.php");
        break;

    // =============================================
    // Đăng nhập
    // =============================================
    case "dangnhap":
        include("loginform.php");
        break;

    case "xldangnhap":
        $email = $_POST["txtemail"] ?? "";
        $matkhau = $_POST["txtmatkhau"] ?? "";

        if ($khachhangModel->kiemtrakhachhanghople($email, $matkhau)) {
            $_SESSION["khachhang"] = $khachhangModel->laythongtinkhachhang($email);
            $giohang = laygiohang();
            include("info.php"); // trang thông tin tài khoản + đơn hàng
        } else {
            $thongbao = "Email hoặc mật khẩu không đúng!";
            include("loginform.php");
        }
        break;

    // =============================================
    // Xem thông tin tài khoản + đơn hàng
    // =============================================
    case "thongtin":
        if (!isset($_SESSION["khachhang"])) {
            include("loginform.php");
            break;
        }
        include("info.php");
        break;

    // =============================================
    // Đăng xuất
    // =============================================
    case "dangxuat":
        unset($_SESSION["khachhang"]);
        header("Location: index.php");
        exit();

    // =============================================
    // Trang mặc định
    // =============================================
    default:
        $laptops = $laptopModel->laylaptop();
        include("main.php");
        break;
    // =============================================
    // Xử lý tìm kiếm (Thêm mới)
    // =============================================
    case "timkiem":
        if(isset($_GET["txtsearch"])){
            $tukhoa = $_GET["txtsearch"];
            $laptops = $laptopModel->timkiemlaptop($tukhoa);
            // Tận dụng lại giao diện main.php để hiển thị kết quả
            include("main.php");
        } else {
            // Nếu không có từ khóa thì về trang chủ
            $laptops = $laptopModel->laylaptop();
            include("main.php");
        }
        break;
}
?>

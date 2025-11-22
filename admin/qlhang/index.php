<?php 
session_start();

// Kiểm tra đăng nhập (chỉ Admin và Nhân viên được vào)
if (!isset($_SESSION["nguoidung"]) || ($_SESSION["nguoidung"]["loai"] != 1 && $_SESSION["nguoidung"]["loai"] != 2)) {
    header("location:../index.php");
    exit();
}

require("../../model/Database.php");
require("../../model/Hang.php");

$hangModel = new HANG();
$idsua = 0;
$thongbao = "";

$action = $_REQUEST["action"] ?? "xem";

switch ($action) {
    case "xem":
        $hangs = $hangModel->layhang();
        include("main.php");
        break;

    case "sua":
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $idsua = (int)$_GET["id"];
            $hangs = $hangModel->layhang();
            include("main.php");
        } else {
            header("location:index.php");
        }
        break;

    case "capnhat":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $tenhang = trim($_POST["tenhang"]);
            $logo = trim($_POST["logo"] ?? "");
            $mota = trim($_POST["mota"] ?? "");

            if (empty($tenhang)) {
                $thongbao = "<div class='alert alert-danger'>Tên hãng không được để trống!</div>";
            } else {
                $hang = new HANG();
                $hang->setid($id);
                $hang->settenhang($tenhang);
                $hang->setlogo($logo);
                $hang->setmota($mota);

                if ($hangModel->suahang($hang)) {
                    $thongbao = "<div class='alert alert-success'>Cập nhật hãng thành công!</div>";
                } else {
                    $thongbao = "<div class='alert alert-danger'>Có lỗi khi cập nhật hãng!</div>";
                }
            }
        }
        $hangs = $hangModel->layhang();
        include("main.php");
        break;

    case "them":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tenhang = trim($_POST["tenhang"]);
            $logo = trim($_POST["logo"] ?? "");
            $mota = trim($_POST["mota"] ?? "");

            if (empty($tenhang)) {
                $thongbao = "<div class='alert alert-danger'>Tên hãng không được để trống!</div>";
            } else {
                $hang = new HANG();
                $hang->settenhang($tenhang);
                $hang->setlogo($logo);
                $hang->setmota($mota);

                if ($hangModel->themhang($hang)) {
                    $thongbao = "<div class='alert alert-success'>Thêm hãng mới thành công!</div>";
                } else {
                    $thongbao = "<div class='alert alert-danger'>Lỗi: Không thể thêm hãng (có thể tên đã tồn tại)!</div>";
                }
            }
        }
        $hangs = $hangModel->layhang();
        include("main.php");
        break;

    case "xoa":
        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id_xoa = (int)$_GET["id"];
            $hang = new HANG();
            $hang->setid($id_xoa);

            if ($hangModel->xoahang($hang)) {
                $thongbao = "<div class='alert alert-success'>Xóa hãng thành công!</div>";
            } else {
                $thongbao = "<div class='alert alert-danger'>Không thể xóa hãng đang có sản phẩm!</div>";
            }
        }
        $hangs = $hangModel->layhang();
        include("main.php");
        break;

    default:
        $hangs = $hangModel->layhang();
        include("main.php");
        break;
}
?>
<?php include("inc/top.php"); ?>
<div class="container py-5">
    <div class="row shadow-sm p-4 rounded border">
        <div class="col-md-6">
            <h3 class="text-primary mb-4">Liên hệ với chúng tôi</h3>
            <p><strong>Địa chỉ:</strong> 18 Ung Văn Khiêm, P. Đông Xuyên, TP. Long Xuyên, An Giang</p>
            <p><strong>Email:</strong> contact@laptopstore.vn</p>
            <p><strong>Hotline:</strong> 1900 1000</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.627295380687!2d105.4301502748479!3d10.371655866529324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a731e7546fd7b%3A0x953539cd7673d9e5!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBBbiBHaWFuZyAtIMSQSFFHIFRQLkhDTQ!5e0!3m2!1svi!2s!4v1700000000000" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="col-md-6">
            <h4 class="mb-3">Gửi tin nhắn</h4>
            <form action="index.php?action=xulylienhe" method="post">
                <div class="mb-3">
                    <label>Email của bạn</label>
                    <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" name="sodienthoai" class="form-control" required placeholder="090...">
                </div>
                <div class="mb-3">
                    <label>Nội dung</label>
                    <textarea name="noidung" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi liên hệ</button>
            </form>
        </div>
    </div>
</div>
<?php include("inc/bottom.php"); ?>

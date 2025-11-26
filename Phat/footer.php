<?php
$company_info = [
    "name" => "GS LIGHTING",
    "desc" => "Chúng tôi cung cấp các giải pháp chiếu sáng hiện đại, tiết kiệm năng lượng và thẩm mỹ cao cho ngôi nhà của bạn.",
    "address" => "Số 123, Đường ABC, Quận XYZ, TP. Hà Nội",
    "phone" => "0987.654.321",
    "email" => "cskh@gslighting.vn",
    "website" => "gslighting.vn"
];

$policies = [
    "Chính sách bảo hành" => "#",
    "Chính sách đổi trả" => "#",
    "Chính sách vận chuyển" => "#",
    "Chính sách bảo mật" => "#",
    "Điều khoản sử dụng" => "#"
];

$guides = [
    "Hướng dẫn mua hàng" => "#",
    "Hướng dẫn thanh toán" => "#",
    "Hướng dẫn lắp đặt đèn" => "#",
    "Câu hỏi thường gặp" => "#",
    "Tải catalogue" => "#"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-title">VỀ CHÚNG TÔI</h5>
                <div class="mb-3">
                    <a href="index.php" class="text-decoration-none">
                        <h3 class="text-white fw-bold"><?= $company_info['name'] ?></h3>
                    </a>
                </div>
                <p><?= $company_info['desc'] ?></p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-geo-alt footer-icon"></i> <?= $company_info['address'] ?></li>
                    <li class="mb-2"><i class="bi bi-telephone footer-icon"></i> <?= $company_info['phone'] ?></li>
                    <li class="mb-2"><i class="bi bi-envelope footer-icon"></i> <?= $company_info['email'] ?></li>
                    <li class="mb-2"><i class="bi bi-globe footer-icon"></i> <?= $company_info['website'] ?></li>
                </ul>
                <div class="mt-3">
                    <img src="./img/image.png" width="150" alt="Đã thông báo bộ công thương">
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">CHÍNH SÁCH</h5>
                <ul class="list-unstyled">
                    <?php foreach($policies as $name => $link): ?>
                        <li><a href="<?= $link ?>" class="footer-link"><?= $name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">HƯỚNG DẪN</h5>
                <ul class="list-unstyled">
                    <?php foreach($guides as $name => $link): ?>
                        <li><a href="<?= $link ?>" class="footer-link"><?= $name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">ĐĂNG KÝ NHẬN TIN</h5>
                <p>Nhập email để nhận thông tin khuyến mãi mới nhất.</p>
                <form action="#" method="POST" class="mb-3">
                    <div class="input-group">
                        <input type="email" class="form-control newsletter-input" placeholder="Email của bạn..." required>
                        <button class="btn btn-newsletter" type="submit"><i class="bi bi-send"></i></button>
                    </div>
                </form>

                <h5 class="footer-title mt-4">KẾT NỐI</h5>
                <div class="d-flex gap-3 mb-4 social-icons">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                </div>

                <h5 class="footer-title">THANH TOÁN</h5>
                <div class="payment-icons">
                    <i class="bi bi-credit-card-2-front" title="Visa/Master"></i>
                    <i class="bi bi-cash-coin" title="Tiền mặt"></i>
                    <i class="bi bi-bank" title="Chuyển khoản"></i>
                </div>
            </div>
        </div>
        
        <div class="row pt-4 mt-4 border-top border-secondary copyright-section">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date("Y"); ?> <strong><?= $company_info['name'] ?></strong>. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">Designed by phat</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
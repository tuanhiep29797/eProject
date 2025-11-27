<?php

$company_info = [
    "name" => "LICERIA & CO",
    "desc" => "We provide modern, energy-saving, and highly aesthetic lighting solutions for your home.",
    "address" => "No. 123, ABC Street, Hanoi City",
    "phone" => "(+84) 987 654 321",
    "email" => "support@liceria&co.vn",
    "website" => "liceria&co.vn"
];

$policies = [
    "Warranty Policy" => "#",
    "Return & Exchange" => "#",
    "Shipping Policy" => "#",
    "Privacy Policy" => "#",
    "Terms of Use" => "#"
];

$guides = [
    "Shopping Guide" => "#",
    "Payment Guide" => "#",
    "Installation Guide" => "#",
    "FAQs" => "#",
    "Download Catalogue" => "#"
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
    <link rel="stylesheet" href="./css/footer.css">
</head>
<body>

<footer class="footer-section">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="mb-4">
                    <a href="index.php" class="text-decoration-none">
                        <h2 class="text-white m-0" style="font-family: 'Calistoga', serif; letter-spacing: 2px;">
                            LICERIA & CO
                        </h2>
                    </a>
                </div>
                <p class="mb-4" style="line-height: 1.6;"><?= $company_info['desc'] ?></p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-geo-alt-fill footer-icon"></i> <?= $company_info['address'] ?></li>
                    <li class="mb-2"><i class="bi bi-telephone-fill footer-icon"></i> <?= $company_info['phone'] ?></li>
                    <li class="mb-2"><i class="bi bi-envelope-fill footer-icon"></i> <?= $company_info['email'] ?></li>
                    <li class="mb-2"><i class="bi bi-globe footer-icon"></i> <?= $company_info['website'] ?></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">POLICIES</h5>
                <ul class="list-unstyled">
                    <?php foreach($policies as $name => $link): ?>
                        <li><a href="<?= $link ?>" class="footer-link"><?= $name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">SUPPORT</h5>
                <ul class="list-unstyled">
                    <?php foreach($guides as $name => $link): ?>
                        <li><a href="<?= $link ?>" class="footer-link"><?= $name ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title">NEWSLETTER</h5>
                <p class="small">Subscribe to receive the latest news.</p>
                <form action="#" method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="email" class="form-control newsletter-input" placeholder="Your email..." required>
                        <button class="btn btn-newsletter" type="submit"><i class="bi bi-send-fill"></i></button>
                    </div>
                </form>

                <h5 class="footer-title mt-2">FOLLOW US</h5>
                <div class="d-flex gap-2 mb-4 social-icons">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                </div>

                <div class="payment-icons">
                    <i class="bi bi-credit-card-2-front"></i>
                    <i class="bi bi-wallet2"></i>
                    <i class="bi bi-bank"></i>
                </div>
            </div>
        </div>
        
        <div class="row copyright-section">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date("Y"); ?> <strong><?= $company_info['name'] ?></strong>. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">Designed by Phat</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
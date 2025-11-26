<?php
session_start();
require_once('./database/dbhelper.php'); 

$msg = "";   
$msgType = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone_number'] ?? '';
    $content = $_POST['content'] ?? '';

    if ($name && $email && $content) {
        try {
            $conn = getConnection();
            $sql = "INSERT INTO feedback (username, email, phone_number, content) 
                    VALUES (:n, :e, :p, :c)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':n' => $name, ':e' => $email, ':p' => $phone, ':c' => $content]);
            
            $msg = "Message sent successfully! We will contact you soon.";
            $msgType = "success";
        } catch (Exception $e) {
            $msg = "Error: " . $e->getMessage();
            $msgType = "danger";
        }
    } else {
        $msg = "Please fill in all required fields!";
        $msgType = "warning";
    }
}

$company_info = [
    "name" => "GS LIGHTING",
    "desc" => "Providing modern, energy-saving lighting solutions for your home.",
    "address" => "No. 123, ABC Street, Hanoi City",
    "phone" => "(+84) 987 654 321",
    "email" => "support@gslighting.vn",
    "website" => "gslighting.vn"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - GS Lighting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body>

    <?php include '../Manh/includes/header.php'; ?>
    <div class="contact-banner">
        <div class="container">
            <h2>Contact Us</h2>
        </div>
    </div>

    <div class="container">
        <div class="row g-5">
            
            <div class="col-lg-5">
                <div class="contact-box">
                    <h4 class="mb-4 fw-bold text-uppercase">Get In Touch</h4>
                    
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Our Office</h6>
                            <p class="text-muted mb-0">Floor 2, ABC Building, Hanoi City</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Call Us</h6>
                            <p class="text-muted mb-0">+84 912 345 678</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Email Us</h6>
                            <p class="text-muted mb-0">support@lightstore.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-box">
                    <h4 class="mb-4 fw-bold text-uppercase">Send a Message</h4>

                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo $msgType; ?>"><?php echo $msg; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="username" class="form-control" required placeholder="Your name...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone_number" class="form-control" placeholder="Your phone...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required placeholder="Your email...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <textarea name="content" class="form-control" rows="4" required placeholder="How can we help you?"></textarea>
                        </div>

                        <button type="submit" class="btn-send">
                            Send Message <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0968141837515!2d105.7800937149326!3d21.028811885998335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab86cece9ac1%3A0xa9bc04e04602dd31!2zSMOgIE7huqFpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1625624123456!5m2!1svi!2s" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h2 class="text-white fw-bold mb-3" style="letter-spacing: 2px;">GS LIGHTING</h2>
                    <p class="mb-4" style="line-height: 1.8; opacity: 0.8;"><?= $company_info['desc'] ?></p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-success"></i> <?= $company_info['address'] ?></li>
                        <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-success"></i> <?= $company_info['phone'] ?></li>
                        <li class="mb-2"><i class="bi bi-envelope-fill me-2 text-success"></i> <?= $company_info['email'] ?></li>
                    </ul>
                    <div class="mt-3">
                    <img src="./img/image.png" width="150" alt="Ministry of Industry and Trade Notification">
                </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-title">Policies</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Warranty Policy</a></li>
                        <li><a href="#" class="footer-link">Return Policy</a></li>
                        <li><a href="#" class="footer-link">Privacy Policy</a></li>
                        <li><a href="#" class="footer-link">Terms of Use</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Shopping Guide</a></li>
                        <li><a href="#" class="footer-link">Installation Guide</a></li>
                        <li><a href="#" class="footer-link">Payment Methods</a></li>
                        <li><a href="#" class="footer-link">FAQs</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-title">Newsletter</h5>
                    <p class="small opacity-75">Sign up for the latest news & offers.</p>
                    <form action="#" class="d-flex mb-4">
                        <input type="email" class="form-control newsletter-input" placeholder="Email...">
                        <button class="btn btn-newsletter"><i class="bi bi-send-fill"></i></button>
                    </form>
                    
                    <h5 class="footer-title mt-2">Follow Us</h5>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="copyright-section">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        &copy; 2024 <strong>GS LIGHTING</strong>. All Rights Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        Designed by Phat
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
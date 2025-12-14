<?php
    require_once (__DIR__.'/../database/dbhelper.php');
    

    $msg = "";
    $msgType = "";

    // get data from form
    if (!empty($_POST)) {
        $username    = trim($_POST['username'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $phone_number   = trim($_POST['phone_number'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($username && $email && $phone_number && $content) 
        {
            try 
            {
                $conn = getConnection();
                $stmt = $conn->prepare(SQL_ADD_FEEDBACK);
                $stmt -> bindParam(":username", $username);
                $stmt -> bindParam(":email", $email);
                $stmt -> bindParam(":phone_number", $phone_number);
                $stmt -> bindParam(":content", $content);
                $stmt->execute();
                
                $msg = "Message sent successfully!";
                $msgType = "success";
            } catch (Exception $e) 
            {
                $msg = "Error: " . $e->getMessage();
                $msgType = "danger";
            }
        } 
        else 
        {
            $msg = "Please fill in required fields!";
            $msgType = "warning";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/contact.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">

</head>
<body>

    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <!-- banner -->
    <div class="page-banner">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>

                <i class="bi bi-chevron-right"></i>

                <a href="#">Contact Us</a>
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="top-map-section">
        <div class="container">
            <div class="map-frame">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0968141837515!2d105.7800937149326!3d21.028811885998335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab86cece9ac1%3A0xa9bc04e04602dd31!2zSMOgIE7huqFpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1625624123456!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <div class="contact-main-section py-4 py-md-5">
        <div class="container">
            
            <div class="section-header-text text-center text-md-start">
                <h3>Contact Us</h3>
                <p>Any questions or remarks? Just write us a message!</p>
            </div>

            <div class="row g-4 g-md-5">
                
                <div class="col-12 col-md-12 col-xl-5"> 
                    <div class="black-border-box">
                        
                        <ul class="info-list">
                            <li class="info-item-vertical">
                            <img src="../assets/img/home/img_contact_us_instagram.png" class="img-icon-custom" alt="Address">
                                <div class="info-content">
                                    <h5>Info</h5>
                                    <p>Chic Lighting & Design</p> 
                                    <p>support@cl&d.vn</p>     
                                </div>                           
                            </li>
                            <li class="info-item-vertical">
                                <img src="../assets/img/home/img_contact_us_map.png" class="img-icon-custom" alt="Address">
                                <div class="info-content">
                                    <h5>Address</h5>
                                    <p>No. 160, Tran Duy Hung Street, Hanoi City</p>
                                </div>
                            </li>

                            <li class="info-item-vertical">
                                <img src="../assets/img/home/img_contact_us_whatsapp.png" class="img-icon-custom" alt="Phone">
                                <div class="info-content">
                                    <h5>Phone</h5>
                                    <p>(+84) 123 456 789</p>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-7"> 
                    <div class="black-border-box">
                        <h3 class="form-title">Send a Message</h3>

                        <?php if ($msg): ?>
                            <div class="alert alert-<?= $msgType ?>"><?= $msg ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-6 form-group-custom">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6 form-group-custom">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone_number" class="form-control">
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label">How can we help you?</label>
                                <textarea name="content" class="form-control" rows="5"></textarea>
                            </div>

                            <button type="submit" name="btn_send" class="btn-submit-black">
                                 Send Feedback
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
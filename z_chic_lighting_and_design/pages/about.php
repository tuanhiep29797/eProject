<?php
    require_once (__DIR__.'/../database/dbhelper.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/about.css">
</head>
<body>
    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <div class="page-banner">
        <div class="container">
            <h2>About Us</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">About Us</a>
                
            </div>
        </div>
    </div>
    <div class="container about-section">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="img-box">
                    <img src="../assets/img/home/img_about_1.png" alt="Chic Lighting & Design">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="about-content">
                    <span class="sub-title">OUR STORY</span>
                    <h2 class="main-title">CHIC LIGHTING & DESIGN</h2>
                    <p class="desc">
                        Welcome to <strong>LCHIC LIGHTING & DESIGN</strong>. We are a passionate team dedicated to providing modern, energy-efficient, and aesthetically pleasing lighting solutions.
                    </p>
                    <p class="desc">
                        We believe that lighting is not just about visibility; it is the soul of your home. Our mission is to transform your living spaces with the perfect blend of technology and design.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="why-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 pe-lg-5 order-2 order-lg-1">
                    <div class="about-content">
                        <span class="sub-title">WHY CHOOSE US</span>
                        <h2 class="main-title">We Bring The Best For Your Home</h2>
                        <p class="desc">
                            With over 10 years of experience in the lighting industry, we understand what makes a home shine. We commit to quality and service.
                        </p>
                        
                        <ul class="check-list ps-0">
                            <li><i class="bi bi-check-circle-fill"></i> 100% Genuine High-Quality Products</li>
                            <li><i class="bi bi-check-circle-fill"></i> Free Installation Support</li>
                            <li><i class="bi bi-check-circle-fill"></i> 2 Years Warranty</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="img-box">
                        <img src="../assets/img/home/img_about_2.png" alt="Why Choose Us">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="video-section">
        <div class="container">
            <h3 class="text-white mb-4 fw-bold text-uppercase">Introduction Video</h3>
            <p class="text-white-50 mb-5">Discover our showroom and working process</p>
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/UH27YDBjNFU?list=RDVFjb8lDVW04" title="[Vietsub - Pinyin] Tháp Rơi Tự Do - LBI Lợi Bỉ | 跳楼机 - LBI利比" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
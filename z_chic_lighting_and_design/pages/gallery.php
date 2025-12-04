<?php
session_start();
require_once('./database/dbhelper.php'); 

$gallery_images = [
    "img/img_about_1.png",
    "img/img_about_2.png",
    "img/img_about_1.png",
    "img/img_about_2.png",
    "img/img_about_1.png",
    "img/img_about_2.png",
    "img/img_about_1.png",
    "img/img_about_2.png",
    "img/img_about_1.png",
];


$total_images = count($gallery_images);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery - LICERIA & CO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/gallery.css">
</head>
<body>



    <div class="gallery-banner">
        <div class="container">
            <h2>Our Gallery</h2>
            <div class="banner-breadcrumb">
                <a href="index.php">Home</a>
                <i class="bi bi-chevron-right"></i>
                <span class="active">Gallery</span>
            </div>
        </div>
    </div>

    <div class="container gallery-section">
        <div class="gallery-header">
            <h3>Latest Projects</h3>
            <p>Explore our beautiful lighting collections</p>
        </div>

        <div class="row">
            <?php foreach($gallery_images as $index => $img): ?>
                <div class="col-xl-4 col-md-6">
                    <a class="gallery-item" href="#img-<?= $index ?>">
                        <img src="<?= $img ?>" alt="Gallery Image">
                        <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach($gallery_images as $index => $img): ?>
        <?php
            $prev_index = ($index == 0) ? $total_images - 1 : $index - 1;
            
            // điều kiện ? đúng : sai

            $next_index = ($index == $total_images - 1) ? 0 : $index + 1;
        ?>

        <div class="lightbox-target" id="img-<?= $index ?>">
            
            <img src="<?= $img ?>" class="lightbox-content" alt="Full Image">
            
            <a class="lightbox-close" href="#gallery-section">&times;</a>
            
            <a class="lightbox-nav lightbox-prev" href="#img-<?= $prev_index ?>">
                &#10094;
            </a>
            
            <a class="lightbox-nav lightbox-next" href="#img-<?= $next_index ?>">
                &#10095;
            </a>
            
            <a href="#gallery-section" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:9998; cursor:default;"></a>
        </div>
    <?php endforeach; ?>

    <div id="gallery-section"></div>

    <?php require_once "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
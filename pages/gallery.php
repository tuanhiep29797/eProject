<?php
    require_once (__DIR__.'/../database/dbhelper.php');

    //connection to database and get gallery
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_GALLERY);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $img_list = $stmt->fetchAll();

        $total = count($img_list);
        $row = ceil($total / 5);

    }
    catch (PDOException $e) 
    {
        echo "<script>
                console.error(" . json_encode($e->getMessage()) . ");
            </script>";
        exit();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/banner.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/gallery.css?v=<?= time() ?>"> 
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">

</head>
<body>

    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <!-- body -->
    <div class="page-banner">
        <div class="container">
            <h2>GALLERY</h2>
            
            <div class="banner-breadcrumb">
                <a href="<?= BASE_URL ?>home">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Gallery</a>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class='d-flex align-items-center mt-3 mt-md-4'>
        <div class="d-inline-block bg-dark px-3 px-md-4 py-2 rounded-pill shadow-sm text-center mx-auto">
            <a href="<?= BASE_URL ?>assets/img/Gallery.pdf"
                download="Gallery.pdf"
                class="text-decoration-none text-white fw-bold text-uppercase small">
                Download Gallery <i class="bi bi-cloud-arrow-down ms-1"></i>
            </a>    
        </div>  
    </div>

    <div class="gallery-section">     
        <?php for ($i = 0; $i < $row; $i++): ?>
            <div class="container_gallery">
                <?php for ($j = 0; $j <= 4; $j++): ?>
                    <?php 
                        $index = $i * 5 + $j;
                        if ($index >= $total) break; 
                    ?>
                    <div class="card">
                        <img src="<?= BASE_URL.htmlspecialchars($img_list[$index]['url']) ?>" alt="img_gallery">
                    </div>
                <?php endfor;?>
                </div>
        <?php endfor;?>
    </div>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    require_once (__DIR__.'/../database/dbhelper.php');

    //connection to database and get gallery
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_GALLERY);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt->fetchAll();

        $row = ceil(count($data_list) - 1);

    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
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
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/gallery.css"> 


</head>
<body>

    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <div class="page-banner" style="background-image: url('../assets/img/home/img_banner.png');">
        <div class="container">
            <h2>GALLERY</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Gallery</a>
                
            </div>
        </div>
    </div>

    <div class="gallery-section">
        
        <div class="container_gallery">
            <?php for ($i = 1; $i <= $row; $i++): ?>
                <?php for ($j = 0; $j <= 4; $j++): ?>
                    <div class="card">
                       <img src="<?= htmlspecialchars($data_list[($i - 1) * 5 + $j]["url"]) ?>" alt="img_gallery">
                    </div>
                <?php endfor;?>
            <?php endfor;?>
        </div>
    </div>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
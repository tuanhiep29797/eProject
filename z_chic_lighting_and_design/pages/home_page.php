<?php
    require_once (__DIR__.'/../database/dbhelper.php'); 
    
    //connection to data base
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_PRODUCT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt->fetchAll();
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $products = [];
    for ($i = 1; $i <= 4; $i++)
    {
        $products[] = $data_list[rand(0, count($data_list) - 1)];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chic Lighting & Design</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/banner.css">
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>

    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <div class="page-banner">

        <div class="container">
            <h2>Chic Lighting & Design</h2>
            <p class="mb-4 text-white-50 mx-auto">
                Where Light Becomes Art — A Touch That Illuminates Your Soul
            </p>
            <div class="d-inline-block bg-white px-4 py-2 rounded-pill shadow-sm">
                <a href="../pages/product.php" class="text-decoration-none text-dark fw-bold text-uppercase small">To Order <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>

    </div>

    <div class="container py-5 my-3 my-md-5">
        <div class="row align-items-center mb-5 gx-lg-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="img-wrapper">
                    <img src="../assets/img/home/image_01.png" alt="Interior Design" class="story-img shadow-sm">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4 text-secondary">
                    <p class="lh-xl mb-3">
                        <p>Welcome to Chic Lighting & Design where we believe that lighting is not merely functional, but an art form. We specialize in providing high-end, unique decorative lighting fixtures, carefully curated from leading designers, aiming to create an inspirational, luxurious, and distinctly personalized living and working environment for you.</p>
                    </p>
                    <p class="lh-xl mb-3">
                        Premium Quality: Every lighting product we offer undergoes rigorous inspection for material quality, durability, and lighting performance, ensuring lasting value for our customers.
                    </p>
                </div>
            </div>
        </div>

        <div class="row align-items-center mt-5 gx-lg-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="pe-lg-4 text-secondary">
                    <p class="lh-xl">
                        Groundbreaking Design: From the minimalist Scandinavian style and edgy Industrial lamps to dazzling classic crystal chandeliers, we constantly update the latest design trends to suit every aesthetic taste and interior structure.
                    </p>
                    <p class="lh-xl">
                        Customer Experience: We don't just sell lights; we sell lighting solutions. Our team of experts is dedicated to providing thoughtful consultation to help you find the perfect light source, suitable for every corner of your home and every moment of your life.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                <div class="img-wrapper">
                     <img src="../assets/img/home/image_02.png" alt="Hanging Lamp" class="story-img shadow-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="catalog-section py-5 bg-light-subtle">
        <div class="container">
            <h2 class="section-title fw-bold mb-4 mb-md-5 font-serif text-uppercase text-center text-md-start">Catalog</h2>
            
            <div class="row g-4">
                <?php foreach($products as $prod): ?>
                <div class="col-md-6"> <div class="card product-card h-100 border p-3 p-md-4 shadow-sm bg-white">
                        <div class="row align-items-center h-100">
                            <div class="col-5 col-sm-4">
                                <img src="<?php echo $prod['product_thumbnail']; ?>" class="img-fluid" alt="<?php echo $prod['product_title']; ?>">
                            </div>
                            
                            <div class="col-7 col-sm-8 ps-3 ps-md-4">
                                <h5 class="fw-bold font-serif mb-2 text-truncate"><?php echo $prod['product_title']; ?></h5>
                                <p class="text-muted small mb-3 d-none d-sm-block">
                                    <?php echo $prod['product_description']; ?>
                                </p>
                                <p class="text-muted small mb-2 d-block d-sm-none text-truncate">Description here...</p>

                                <div class="d-flex flex-wrap align-items-center justify-content-between mt-auto">
                                    <span class="fw-bold fs-5 mb-2 mb-sm-0 me-2">$<?php echo $prod['product_price']; ?></span>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="product_detail.php?id=<?= $prod["product_id"] ?>" class="btn btn-dark btn-sm rounded-0 px-3 py-1 text-uppercase" style="font-size: 12px;">Buy</a>
                                        <a href="#" class="btn btn-light btn-sm rounded-circle border d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="bi bi-heart-fill text-muted" style="font-size: 14px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="../pages/product.php" class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold text-uppercase">
                    View More <i class="bi bi-arrow-right ms-2"></i>
                </a>
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
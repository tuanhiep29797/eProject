<?php
    require_once (__DIR__.'/../database/dbhelper.php'); 
    
    //connection to data base and get product
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_PRODUCT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $prod_list = $stmt->fetchAll();
    }
    catch (PDOException $e) 
    {
        echo "<script>
                console.error(" . json_encode($e->getMessage()) . ");
            </script>";
        exit();
    }

    // select random product
    $products = [];
    for ($i = 1; $i <= 4; $i++)
    {
        $products[] = $prod_list[rand(0, count($prod_list) - 1)];
    }

    //connection to data base and get brand
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brand_list = $stmt->fetchAll();
    }
    catch (PDOException $e) 
    {
        echo "<script>
                console.error(" . json_encode($e->getMessage()) . ");
            </script>";
        exit();
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/home.css?v=<?= time() ?>">
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
            <h2>Chic Lighting & Design</h2>
            <p class="mb-4 text-white-50 mx-auto">
                Where Light Becomes Art — A Touch That Illuminates Your Soul
            </p>
            <div class="d-inline-block bg-white rounded-pill shadow-sm">
                <a href="product.php" class="text-decoration-none text-dark fw-bold text-uppercase small"><button class='btn btn-light px-4 py-2 text-bold' style="border-radius: 20px;font-weight:bold;">Order <i class="bi bi-arrow-right ms-1"></i></button></a>
            </div>
        </div>

    </div>

    <!-- body -->
    <div class="container py-4 py-md-5 my-3 my-xl-5">
        <div class="row align-items-center mb-4 mb-xl-5 gx-xl-5">
            <div class="col-12 col-md-12 col-xl-6 mb-4 mb-xl-0">
                <div class="img-wrapper">
                    <img src="../assets/img/home/image_01.png" alt="Interior Design" class="story-img shadow-sm">
                </div>
            </div>
            <div class="col-12 col-md-12 col-xl-6">
                <div class="ps-xl-4 text-secondary">
                    <h2>CHIC LIGHTING & DESIGN</h2>
                    <p class="lh-xl mb-3">
                        <p>Welcome to Chic Lighting & Design where we believe that lighting is not merely functional, but an art form. We specialize in providing high-end, unique decorative lighting fixtures, carefully curated from leading designers, aiming to create an inspirational, luxurious, and distinctly personalized living and working environment for you.</p>
                    </p>
                    <p class="lh-xl mb-3">
                        Premium Quality: Every lighting product we offer undergoes rigorous inspection for material quality, durability, and lighting performance, ensuring lasting value for our customers.
                    </p>
                    <div class="d-inline-block rounded-pill shadow-sm">
                        <a href="about.php" class="text-decoration-none text-dark fw-bold text-uppercase small"><button class='btn btn-dark px-4 py-3 text-bold' style="border-radius: 20px;font-weight:bold;">About Us <i class="bi bi-arrow-right ms-1"></i></button></a>
                    </div>
                </div>
            </div>
        </div>

    <div class="catalog-section py-5 bg-white">
        <div class="container">
            <h2 class="section-title fw-bold mb-4 mb-md-5 font-serif text-uppercase text-center text-md-start">BRANDS</h2>

            <div class="row g-3 g-md-4 justify-content-center ">
            <?php foreach ($brand_list as $item): ?>
            <div class="col-6 col-md-4 col-xl-2 text-center">

                <div class="brand-card product-card bg-white rounded shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                    <a href="brand.php?brand%5B%5D=<?= $item["brand_id"]?>&action=filter"
                       class="fw-semibold text-decoration-none brand-link text-dark p-3">
                    <img src="<?= BASE_URL . $item["brand_thumbnail"] ?>"
                         alt="<?= $item["brand_name"] ?>"
                         class="img-fluid mb-3 brand-img">
                        <?= $item["brand_name"] ?>
                    </a>
                    
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        </div>
            
    </div>

    <div class="catalog-section py-5 bg-white">
        <div class="container">
            <h2 class="section-title fw-bold mb-4 mb-md-5 font-serif text-uppercase text-center text-md-start">BEST SELLER</h2>
            
            <div class="row g-3 g-md-4">
                <?php foreach($products as $prod): ?>
                    <div class="col-12 col-md-6 col-xl-6"> 
                        <div class="card product-card h-100 border p-3 p-md-4 shadow-sm bg-white">
                            <div class="row align-items-center h-100">
                                <div class="col-5 col-md-4 col-xl-4">
                                    <a href="product_detail.php?id=<?= $prod["product_id"] ?>">
                                        <img src="<?= BASE_URL . $prod["product_thumbnail"]; ?>" class="img-fluid" alt="<?= $prod["product_title"]; ?>">
                                    </a>
                                </div>
                                
                                <div class="col-7 col-md-8 col-xl-8 ps-3 ps-md-4 overflow-hidden">
                                    <a class="d-block fw-bold font-serif mb-2 text-truncate text-decoration-none text-dark" href="product_detail.php?id=<?= $prod["product_id"] ?>"><?= $prod["product_title"]; ?></a>
                                    <p class="text-muted small mb-3 d-none d-md-block">
                                        <?= $prod["product_description"]; ?>
                                    </p>
                                    <p class="text-muted small mb-2 d-block d-md-none text-truncate">Description here...</p>

                                    <div class="d-flex flex-column flex-md-row flex-wrap align-items-start align-items-md-center justify-content-between mt-auto">
                                        <span class="fw-bold fs-6 mb-2 mb-md-0 me-2">$<?= $prod["product_price"]; ?></span>
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="product_detail.php?id=<?= $prod["product_id"] ?>" class="btn btn-dark btn-sm rounded-0 px-3 py-1 text-uppercase" style="font-size: 12px;">Buy</a>
                                            <a href="" class="heartBtn btn btn-light btn-sm rounded-circle border d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                <i class="heartIcon bi bi-heart-fill text-muted" style="font-size: 14px;"></i>
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
    </div>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script>
    document.querySelectorAll(".heartBtn").forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();

            const icon = this.querySelector(".heartIcon"); 

            icon.classList.toggle("text-muted");
            icon.classList.toggle("text-danger");
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
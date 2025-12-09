<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    if (isset($_GET['id'])) {
        $product_id = intval($_GET['id']); 
         try {
            $conn = getConnection();
            $stmt = $conn->prepare("
                SELECT p.*, b.brand_name, c.category_name
                FROM product p
                inner join brand b on b.brand_id =p.brand_id
                inner join category c on c.category_id =p.category_id
                WHERE p.product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $product_detail_list = $stmt->fetchAll();

            if ($product_detail_list == null || count($product_detail_list) == 0) {
            echo '<script>
                    alert("Product detail not found.");
                    window.location.href = "product.php";
                </script>';
            }

            $product_item = $product_detail_list[0];

            $stmt = $conn -> prepare("select * from product_img where product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $product_img_list = $stmt->fetchAll();

            $stmt = $conn->prepare("
                SELECT p.*, b.brand_name, c.category_name
                FROM product p
                LEFT JOIN brand b ON b.brand_id = p.brand_id
                LEFT JOIN category c ON c.category_id = p.category_id
                WHERE p.product_id != :product_id
                ORDER BY RAND()
                LIMIT 6
                ");
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $random_products = $stmt->fetchAll();

        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;

    } 
    else 
    {
      echo '<script>
          alert("Product detail not found.");
          window.location.href = "product.php";
      </script>';
      exit();
    }

?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/product_detail.css?v=<?= time() ?>">
</head>

<body>

  <!-- include header -->
  <?php
      require_once (__DIR__."/../includes/home_header.php");
  ?>

  <div class="page-banner">
      <div class="container">
          <h2>Product Detail</h2>
          
          <div class="banner-breadcrumb">
              <a href="home_page.php">Home</a>

              <i class="bi bi-chevron-right"></i>
      
              <a href="product.php">Product</a>
              
              <i class="bi bi-chevron-right"></i>
      
              <a href="#"><?= htmlspecialchars($product_item["product_title"]) ?></a>
              
          </div>
      </div>
  </div>

  <!-- Product Detail Section -->
  <section class="product-detail py-4">
    <div class="container">
      <div class="product-card">
        <div class="row g-4">
          <!-- Product Images -->
          <div class="col-lg-6">

            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php foreach($product_img_list as $index => $product_img):?>
                  <div class="carousel-item <?= $index === 0 ? "active" : ""?>" data-bs-interval="2000">
                    <img src="<?= BASE_URL . $product_img["url"] ?>" class="d-block w-100" style="height: 700px; object-fit: cover;" alt="Product Image">
                  </div>
                <?php endforeach;?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
      
          </div>

          <!-- Product Info -->
          <div class="col-lg-6">
            <div class="product-info">
              <div class="product-meta">
                <span class="meta-item">Brand: <strong><?= $product_item['brand_name'] ?></strong></span>
                <span class="meta-item">Category: <strong><?= $product_item['category_name'] ?></strong></span>
              </div>

              <h1 class="product-title">      
                <?= $product_item['product_title'] ?>
              </h1>

              <div class="rating-badge">
                <i class="bi bi-star-fill"></i>
                <span>5.0</span>
                <span class="rating-count">(26 Reviews)</span>
              </div>

              <p class="product-description">
                <?= $product_item['product_description'] ?>
              </p>
              <p class="product-description">
                <?= $product_item['product_content'] ?>
              </p>

              <div class="product-price">$<?= number_format($product_item['product_price'])?></div>

              <div class="product-actions">
                <a href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $product_item['product_id'] ?>">
                  <button class="btn btn-outline-dark btn-cart">
                    <i class="bi bi-cart-plus"></i>             
                    ADD TO CART
                  </button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Recommendations Section -->
  <section class="recommendations py-5">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Explore our recomendations</h2>
      </div>

      <div class="row g-4">
        <?php for ($i = 0; $i <= 5; $i++): 
            $product_item = $random_products[$i];
        ?>
        <div class="col-6 col-md-2 col-lg-2">
        <div class="recommendation-card">
            <div class="card-image">
            <img src="<?= BASE_URL . $product_item['product_thumbnail'] ?>" alt="<?= $product_item['product_thumbnail'] ?>">
            </div>
            <div class="card-body">
            <h5 class="card-title"><?= $product_item['product_title'] ?></h5>
            <div class="card-rating">
                <i class="bi bi-star-fill"></i>
                <span>5.0 (26 Reviews)</span>
            </div>
            <div class="card-price">$<?= number_format($product_item['product_price']) ?></div>
            <div class="card-actions">
                <a href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $product_item['product_id'] ?>">
                    <button class="btn btn-sm btn-dark">Add To Cart</button>
                </a>
                <a href="<?= BASE_URL ?>pages/product_detail.php?id=<?= $product_item['product_id'] ?>">
                  <button class="btn btn-sm btn-warning">Buy Now</button>
                </a>
            </div>
            </div>
        </div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- include footer -->
  <?php
      require_once (__DIR__."/../includes/home_footer.php");
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>

</html>
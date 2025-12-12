<?php
  require_once(__DIR__ . "/../database/dbhelper.php");

  try 
  {
  $conn = getConnection();
  $stmt = $conn->prepare(SQL_GET_BRAND);
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $brands = $stmt->fetchAll();
  } 
  catch (PDOException $e) 
  {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

  //get data filter
  $brand_filter = isset($_GET['brand']) ? $_GET['brand'] : [];
  
  //pagination config
  $limit = 9;
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
  $offset = ($page - 1) * $limit;
  $products = [];
  $total_products = 0;
  $total_pages = 0;

  try
  {
    $conn = getConnection();
    if (isset($_GET['action']) && $_GET['action'] == 'filter')
    {
      //base sql
      $where = "WHERE 1";
      $params = [];

      //build conditions
      if (!empty($brand_filter)) 
      {
        $placeholders = implode(',', array_fill(0, count($brand_filter), '?'));
        $where .= " AND p.brand_id IN ($placeholders)";
        $params = array_merge($params, $brand_filter);
      }

      //count total
      $stmt = $conn->prepare(SQL_COUNT_PRODUCT_FILTER_BRAND . $where);
      $stmt->execute($params);
      $total_products = $stmt->fetchColumn();

      //get data
      $stmt = $conn->prepare(SQL_GET_PRODUCT_AS_BRAND . $where . " limit ? offset ?");
      $idx = 1;
      foreach ($params as $val) 
      {
        $stmt->bindValue($idx++, $val);
      }
      $stmt->bindValue($idx++, $limit, PDO::PARAM_INT);
      $stmt->bindValue($idx++, $offset, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
      $products = $stmt->fetchAll();
    }

    elseif (isset($_GET['action']) && $_GET['action'] == 'search')
    {
      $search = isset($_GET['search']) ? trim($_GET['search']) : '';

      //count total
      $stmt = $conn->prepare(SQL_COUNT_PRODUCT_SEARCH);
      $stmt->bindValue(':search', '%' . $search . '%');
      $stmt->execute();
      $total_products = $stmt->fetchColumn();

      ///get data
      $stmt = $conn->prepare(SQL_SEARCH_PRODUCT . " limit :limit offset :offset");
      $stmt->bindValue(':search', '%' . $search . '%');
      $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
      $products = $stmt->fetchAll();
    }

     else 
    {
      //default
      //count total
      $stmt = $conn->prepare(SQL_COUNT_PRODUCT);
      $stmt->execute();
      $total_products = $stmt->fetchColumn();

      //get data
      $stmt = $conn->prepare(SQL_GET_PRODUCT . " limit :limit offset :offset");
      $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
      $products = $stmt->fetchAll();
    }

    $total_pages = ceil($total_products / $limit);
  } 
  catch (PDOException $e) 
  {
    echo "<script>
            console.error(" . json_encode($e->getMessage()) . ");
          </script>";
  }

  $conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product - Chic Lighting</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/banner.css?v=<?= time() ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/product.css?v=<?= time() ?>">
  <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

  <!-- include header -->
  <?php
      require_once (__DIR__."/../includes/home_header.php");
  ?>

  <div class="page-banner">
      <div class="container">
          <h2>Brand</h2>
          
          <div class="banner-breadcrumb">
              <a href="home_page.php">Home</a>
              
              <i class="bi bi-chevron-right"></i>
      
              <a href="#">Brand</a>
              
          </div>
      </div>
  </div>

  <main class="product-page">
    <div class="container-fluid px-4 px-xl-5 py-4">
      <!-- Page Header -->
      <div class="row align-items-center mb-4">
        <div class="col-xl-6">
          <p class="subtitle mb-1 display-2">Give All You Need</p>
          <h1 class="page-title">Brand</h1>
        </div>
        <div class="col-xl-6">
          <form action="" method="GET" class="search-form">
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search on stuffbus"
                value="<?= htmlspecialchars($search ?? "") ?>">
              <button class="btn btn-dark" type="submit" name="action" value="search">Search</button>
            </div>
          </form>
        </div>
      </div>

      <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-xl-3 col-md-4">
          <form action="" method="GET" id="filterForm">

            <!-- Filter by Brand -->
            <div class="filter-section mb-4">
              <h6 class="filter-title">Filter by brand:</h6>
              <div class="filter-options">
                <?php if ($brands): ?>
                  <?php foreach ($brands as $brand): ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="brand[]" value="<?= $brand['brand_id'] ?>"
                        id="brand_<?= $brand['brand_id'] ?>" <?= in_array($brand['brand_id'], $brand_filter) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="brand_<?= $brand['brand_id'] ?>">
                        <?= htmlspecialchars($brand['brand_name']) ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
                  </div>
            <button type="submit" class="btn bg-dark text-white w-100" name="action" value="filter">Apply Filter</button>
          </form>
        </div>

        <!-- Product Grid -->
        <div class="col-xl-9 col-md-8">
          <div class="row g-4">
            <?php if ($products && count($products) > 0): ?>
              <?php foreach ($products as $product): ?>
                <?php
                $image_path = BASE_URL . $product['product_thumbnail'];
                $rating = $product['rating'] ?? 5;
                $reviews = $product['reviews'] ?? '12k';
                $quantity = $product['product_quantity'];
                $is_OOS = $quantity == 0;
                ?>
                <div class="col-xl-4 col-md-6">
                  <div class="product-card" id="product_item_<?= $product['product_id'] ?>">
                    <div class="product-image">
                      <a href="<?= BASE_URL ?>/pages/product_detail.php?id=<?= $product['product_id'] ?>">
                        <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($product['product_title']) ?>">
                      </a>
                    </div>
                    <div class="product-info">
                      <h5 class="product-name">
                        <a href="<?= BASE_URL ?>/pages/product_detail.php?id=<?= $product['product_id'] ?>">
                          <?= htmlspecialchars($product['product_title']) ?>
                        </a>
                      </h5>
                      <div class="product-rating">
                        <div class="stars">
                          <?php
                          $full_stars = floor($rating);
                          $half_star = ($rating - $full_stars) >= 0.5;
                          for ($s = 0; $s < $full_stars; $s++): ?>
                            <i class="bi bi-star-fill"></i>
                          <?php endfor; ?>
                          <?php if ($half_star): ?>
                            <i class="bi bi-star-half"></i>
                          <?php endif; ?>
                          <?php for ($s = $full_stars + ($half_star ? 1 : 0); $s < 5; $s++): ?>
                            <i class="bi bi-star"></i>
                          <?php endfor; ?>
                        </div>
                        <span class="review-count"><?= $rating ?> (<?= $reviews ?> Reviews)</span>
                      </div>
                      <div class="product-price">
                        <?php if(!$is_OOS):?>
                          $<?= number_format($product['product_price'], 2) ?>
                        <?php else: ?>
                          Out of Stock
                        <?php endif;?>
                      </div>
                      <div class="product-actions">
                        <a class="btn btn-outline-success btn-add-cart <?= $is_OOS ? "disabled" : "" ?>" href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $product['product_id'] ?>">
                          <i class="bi bi-cart-plus-fill"></i>  
                          Add To Cart
                        </a>
                        <button class="btn btn-dark btn-buy-now" href="product_detail.php?id=<?= $product['product_id'] ?>">
                          Buy Now
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="no-products text-center py-5">
                  <i class="bi bi-box-seam" style="font-size: 4rem; color: #ccc;"></i>
                  <h4 class="mt-3">No products found</h4>
                  <p class="text-muted">Try adjusting your filters or search terms</p>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Pagination -->
          <?php if ($total_pages > 1): ?>
            <nav class="pagination-wrapper mt-5">
              <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                  <a class="page-link page-prev"
                    href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                    Previous
                  </a>
                </li>

                <?php
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);

                if ($start_page > 1): ?>
                  <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a>
                  </li>
                  <?php if ($start_page > 2): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                  <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                  <?php if ($end_page < $total_pages - 1): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                  <?php endif; ?>
                  <li class="page-item">
                    <a class="page-link"
                      href="?<?= http_build_query(array_merge($_GET, ['page' => $total_pages])) ?>"><?= $total_pages ?></a>
                  </li>
                <?php endif; ?>

                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                  <a class="page-link page-next"
                    href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                    Next
                  </a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
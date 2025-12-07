<?php
require_once(__DIR__ . "/../database/dbhelper.php");

try {
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT * FROM category");
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $categories = $stmt->fetchAll();

  $stmt = $conn->prepare("SELECT * FROM brand");
  $stmt->execute();

  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $brands = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

// Get filter parameters


$category_filter = isset($_GET['category']) ? $_GET['category'] : [];
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : [];
$min_price = isset($_GET['min_price']) ? (float) $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float) $_GET['max_price'] : 50000000;


if (!empty($_GET['action'])) {

  switch ($_GET['action']) {
    case 'filter':
      try {
        $conn = getConnection();

        $sql = "SELECT p.*, c.category_name, b.brand_name
                FROM product p
                INNER JOIN category c ON p.category_id = c.category_id
                INNER JOIN brand b ON p.brand_id = b.brand_id
                WHERE 1";
        $params = [];

        if (!empty($_GET['category'])) {
          $placeholders = implode(',', array_fill(0, count($category_filter), '?'));
          $sql .= " AND p.category_id IN ($placeholders)";
          $params = array_merge($params, $category_filter);
        }

        if (!empty($_GET['brand'])) {
          $placeholders = implode(',', array_fill(0, count($brand_filter), '?'));
          $sql .= " AND p.brand_id IN ($placeholders)";
          $params = array_merge($params, $brand_filter);
        }

        $sql .= " AND p.product_price BETWEEN ? AND ?";
        $params[] = (float)$min_price;
        $params[] = (float)$max_price;

      $stmt = $conn->prepare($sql);
      $stmt->execute($params);

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      break;

    case 'search':
    $search = $_GET['search'] ?? '';

    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT * FROM product
            WHERE product_title LIKE :search
        ");
      $stmt->execute([
                  ':search' => '%' . $search . '%'
              ]);

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      break;

    default:
      header("Location: #");
      break;
  }
} else {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM product");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $products = $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
}

$total_products = count($products);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product - Chic Lighting</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/product.css?v=<?= time() ?>">
</head>

<body>
  <?php
  require_once(__DIR__ . "/../includes/home_header.php");
  ?>

  <main class="product-page">
    <div class="container-fluid px-4 px-xl-5 py-4">
      <!-- Page Header -->
      <div class="row align-items-center mb-4">
        <div class="col-xl-6">
          <p class="subtitle mb-1 display-2">Give All You Need</p>
          <h1 class="page-title">Product</h1>
        </div>
        <div class="col-xl-6">
          <form action="" method="GET" class="search-form">
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search on stuffbus"
                value="<?= htmlspecialchars($search) ?>">
              <button class="btn btn-dark" type="submit" name='action' value='search'>Search</button>
            </div>
          </form>
        </div>
      </div>

      <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-xl-3 col-md-4">
          <form action="" method="GET" id="filterForm">
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">

            <!-- Filter by Category -->
            <div class="filter-section mb-4">
              <h6 class="filter-title">Filter by category:</h6>
              <div class="filter-options">
                <?php foreach ($categories as $cat): ?>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="<?= $cat['category_id'] ?>"
                      id="cat_<?= $cat['category_id'] ?>" <?= in_array($cat['category_id'], $category_filter) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="cat_<?= $cat['category_id'] ?>">
                      <?= htmlspecialchars($cat['category_name']) ?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

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

            <!-- Filter by Price -->
            <div class="filter-section mb-4">
              <h6 class="filter-title">Filter by price:</h6>
              <div class="price-range">
                <div class="d-flex gap-2 mb-3">
                  <div class="price-input">
                    <span>$</span>
                    <input type="number" name="min_price" id="minPrice" value="<?= $min_price ?>" min="0" max="50000000">
                  </div>
                  <div class="price-input">
                    <span>$</span>
                    <input type="number" name="max_price" id="maxPrice" value="<?= $max_price ?>" min="0" max="50000000">
                  </div>
                </div>
                <input type="range" class="form-range price-slider" id="priceRange" min="0" max="50000000"
                  value="<?= $max_price ?>">
              </div>
            </div>

            <button type="submit" class="btn bg-dark text-white w-100" name='action' value='filter'>Apply Filter</button>
          </form>
        </div>

        <!-- Product Grid -->
        <div class="col-xl-9 col-md-8">
          <div class="row g-4">
            <?php if ($products && count($products) > 0): ?>
              <?php foreach ($products as $product): ?>
                <?php
                $image_path = $product['product_thumbnail'];
                $rating = $product['rating'] ?? 4.8;
                $reviews = $product['reviews'] ?? '1.2k';
                ?>
                <div class="col-xl-4 col-md-6">
                  <div class="product-card">
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
                        $<?= number_format($product['product_price'], 2) ?>
                      </div>
                      <div class="product-actions">
                        <button class="btn btn-add-cart" onclick="addToCart(<?= $product['product_id'] ?>)">
                          Add To Cart
                        </button>
                        <button class="btn btn-buy-now" onclick="buyNow(<?= $product['product_id'] ?>)">
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
    <?php
    require_once(__DIR__ . "/../includes/home_footer.php.php");
    ?>
  </main>
</body>

</html>
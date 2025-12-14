<?php
require_once(__DIR__ . "/../../database/dbhelper.php");

// connect database and get product table
try {
    $conn = getConnection();
    $stmt = $conn->prepare(SQL_GET_PRODUCT_AS_CAT_AND_BRAND);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data_list = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>
    <!-- include header -->
    <?php
    require_once(__DIR__ . "/../../admin/admin_header.php");
    ?>

    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-auto bg-dark">
                <?php require_once(__DIR__ . "/../../admin/admin_side_bar.php"); ?>
            </div>

            <!-- body product management page -->
            <div class="col overflow-hidden p-4">
                    <?php
                    $breadcrumb =
                        [
                            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
                            ["icon" => "bi-box-seam", "label" => "Product Management"]
                        ];
                    require_once(__DIR__ . "/../../admin/admin_breadcrumb.php");
                    ?>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="page-title">
                            <i class="bi bi-boxes me-2"></i>
                            Product Management
                        </h2>

                        <a href="add_product.php" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i>
                            Add New Product
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($data_list as $index => $item): ?>
                                    <tr>
                                        <th><?= $index+1 ?></th>
                                        <td>
                                            <img src="<?= BASE_URL . $item['product_thumbnail'] ?>"
                                                alt="Product Image"
                                                style="width: 60px; height: 60px; object-fit: cover;"
                                                class="rounded">
                                        </td>
                                        <td><?= $item['product_title'] ?></td>
                                        <td><?= $item['product_content'] ?></td>
                                        <td><?= $item['category_name'] ?></td>
                                        <td><?= $item['brand_name'] ?></td>
                                        <td>$<?= number_format($item['product_price'], 2) ?></td>
                                        <td><?= $item['product_quantity'] ?></td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="edit_product.php?id=<?= $item['product_id'] ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="delete_product.php?id=<?= $item['product_id'] ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Delete product: <?= $item['product_title'] ?> ?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
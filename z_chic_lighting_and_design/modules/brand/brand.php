<?php
    require_once (__DIR__."/../../database/dbhelper.php");
        
    // connect database and get brand table
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt->fetchAll();
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <!-- include header -->
    <?php 
        require_once (__DIR__."/../../admin/admin_header.php");
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-shop", "label" => "Brand Management"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php";
    ?>

    <!-- body brand management page -->
    <div class="container table-container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-shop-window me-2"></i>
                Brand Management
            </h2>

            <a href="add_brand.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Brand
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Thumbnail</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($data_list as $item): ?>
                        <tr>
                            <th><?= $item['brand_id'] ?></th>

                            <td><?= $item['brand_name'] ?></td>

                            <td>
                                <img src="<?=BASE_URL . $item['brand_thumbnail'] ?>" 
                                     alt="Brand Image"
                                     style="width: 70px; height: 70px; object-fit: cover;"
                                     class="rounded border">
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="edit_brand.php?id=<?= $item['brand_id'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="delete_brand.php?id=<?= $item['brand_id'] ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Delete brand: <?= $item['brand_name'] ?> ?');">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

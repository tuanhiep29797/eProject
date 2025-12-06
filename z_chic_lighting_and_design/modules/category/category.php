<?php
    require_once (__DIR__."/../../database/dbhelper.php");
    
    // connect database and get category table
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_CATEGORY);
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
    <title>Category Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css">
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
            ["icon" => "bi-tag-fill", "label" => "Category Management"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php"); 
    ?>

    <!-- body category management page -->
    <div class="container table-container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-tags-fill me-2"></i>
                Category Management
            </h2>

            <a href="add_category.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i>
                Add New Category
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
                            <th><?= $item['category_id'] ?></th>
                            <td><?= $item['category_name'] ?></td>

                            <td>
                                <img src="<?= $item['category_thumbnail'] ?>" 
                                     alt="Category Image"
                                     style="width: 70px; height: 70px; object-fit: cover;"
                                     class="rounded border">
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a href="edit_category.php?id=<?= $item['category_id'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="delete_category.php?id=<?= $item['category_id'] ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Delete category: <?= $item['category_name'] ?> ?');">
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

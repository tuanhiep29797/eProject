<?php
require_once(__DIR__ . "/../../database/dbhelper.php");

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

$total_category = 0;
$total_pages = 0;

try {
    $conn = getConnection();

    // đếm tổng category
    $stmt = $conn->prepare("SELECT COUNT(*) FROM category");
    $stmt->execute();
    $total_category = $stmt->fetchColumn();
    $total_pages = ceil($total_category / $limit);

    // lấy category theo trang
    $stmt = $conn->prepare(
        SQL_GET_CATEGORY . " ORDER BY category_id DESC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $category_list = $stmt->fetchAll();
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
    <title>Category Manager</title>
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

            <!-- body category management page -->
            <div class="col overflow-hidden p-4">
                <?php
                $breadcrumb = [
                    ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
                    ["icon" => "bi-tag-fill", "label" => "Category Management"]
                ];
                require_once(__DIR__ . "/../../admin/admin_breadcrumb.php");
                ?>
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
                            <?php foreach ($category_list as $item): ?>
                                <tr>
                                    <th><?= $item['category_id'] ?></th>
                                    <td><?= $item['category_name'] ?></td>

                                    <td>
                                        <img src="<?= BASE_URL .  $item['category_thumbnail'] ?>"
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
                    <?php if ($total_pages > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">

                                <!-- Previous -->
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                                </li>

                                <?php
                                $start = max(1, $page - 2);
                                $end   = min($total_pages, $page + 2);
                                ?>

                                <?php if ($start > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=1">1</a>
                                    </li>
                                    <?php if ($start > 2): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($end < $total_pages): ?>
                                    <?php if ($end < $total_pages - 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $total_pages ?>">
                                            <?= $total_pages ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Next -->
                                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                                </li>

                            </ul>
                        </nav>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
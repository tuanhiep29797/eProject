<?php
require_once(__DIR__ . "/../../database/dbhelper.php");

//get all feedback
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

$total_feedback = 0;
$total_pages = 0;

if (isset($_GET["read_id"])) {
    $read_id = $_GET["read_id"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_UPDATE_FEEDBACK_STATUS);

        $new_status = "readed";

        $stmt->bindParam(":status", $new_status);
        $stmt->bindParam(":feedback_id", $read_id);
        $stmt->execute();

        header("Location: feedback.php?page=$page");
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

try {
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM feedback");
    $stmt->execute();
    $total_feedback = $stmt->fetchColumn();
    $total_pages = ceil($total_feedback / $limit);

    $stmt = $conn->prepare(
        SQL_GET_FEEDBACK . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
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
    <title>Feedback Manager</title>
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

            <!-- body -->
            <div class="col overflow-hidden p-4">
                <?php
                $breadcrumb = [
                    ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
                    ["icon" => "bi-chat-left-text-fill", "label" => "Feedback Management"]
                ];
                require_once __DIR__ . "/../../admin/admin_breadcrumb.php";
                ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title">
                        <i class="bi bi-chat-left-dots-fill me-2"></i>
                        Feedback Management
                    </h2>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data_list as $index => $item): ?>

                                <?php
                                $status = ($item["status"] === "new")
                                    ? "<span class='badge bg-danger'>New</span>"
                                    : "<span class='badge bg-success'>Read</span>";
                                ?>

                                <tr class="<?= $item["status"] === "new" ? 'table-warning' : '' ?>">
                                    <th><?= $index + 1 ?></th>
                                    <td><?= $item["username"] ?></td>
                                    <td><?= $item["email"] ?></td>
                                    <td><?= $item["phone_number"] ?></td>
                                    <td><?= $item["content"] ?></td>
                                    <td><?= $status ?></td>
                                    <td><?= date("H:i d/m/Y", strtotime($item["created_at"])) ?></td>

                                    <td>
                                        <?php if ($item["status"] === "new"): ?>
                                            <a href="feedback.php?read_id=<?= $item['feedback_id'] ?>"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-check2-circle"></i> Mark as Read
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-check-lg"></i> Readed
                                            </button>
                                        <?php endif; ?>
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
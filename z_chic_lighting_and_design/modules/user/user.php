<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    // connect database and get user table
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_USER);
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
    <title>User Manager</title>

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
        $breadcrumb = 
        [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-people-fill", "label" => "User Management"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php"); 
    ?>

    <!-- body user management page -->
    <div class="container table-container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-boxes me-2"></i>
                User Management
            </h2>

            <a href="add_user.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i>
                Add New User
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($data_list as $item): ?>
                        <tr>
                            <th><?= $item['user_id'] ?></th>
                            <td><?= $item['fullname'] ?></td>
                            <td><?= $item['username'] ?></td>
                            <td><?= $item['email'] ?></td>
                            <td><?= $item['phone_number'] ?></td>
                            <td><?= $item['role'] ?></td>
                            <td><?= date("H:i d/m/Y", strtotime($item["created_at"])) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="edit_user.php?id=<?= $item['user_id'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="delete_user.php?id=<?= $item['user_id'] ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Delete user: <?= $item['fullname'] ?> ?');">
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

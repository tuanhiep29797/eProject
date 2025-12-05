<?php
    require_once (__DIR__."/../../database/dbhelper.php");
    
    // connect database and get user table
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_USER);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../../assets/css/modules.css">
</head>

<body>
    <!-- include header -->
    <?php
        require_once __DIR__."/../../admin/admin_header.php"; 
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = 
        [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-people-fill", "label" => "User Management"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php"; 
    ?>

    <!-- body user page -->
    <div class="container table-container">

        <div class="row justify-content-center">
            <div class="col-xl-10 col-md-12">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title">
                        <i class="bi bi-person-circle me-2"></i>
                        User Management
                    </h2>

                    <a href="add_user.php" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> 
                        Add New User
                    </a>
                </div>

                <!-- data table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Fullname</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Role</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($data_list as $item): ?>
                                <tr>
                                    <th scope="row"><?= $item["user_id"] ?></th>
                                    <td><?= $item["fullname"] ?></td>
                                    <td><?= $item["username"] ?></td>
                                    <td><?= $item["email"] ?></td>
                                    <td><?= $item["phone_number"] ?></td>
                                    <td><?= $item["role"] ?></td>
                                    <td><?= date("H:i:s d/m/Y", strtotime($item["updated_at"])) ?></td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="edit_user.php?id=<?= $item["user_id"] ?>" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="delete_user.php?id=<?= $item["user_id"] ?>" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete user: <?= $item["fullname"] ?>?');">
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

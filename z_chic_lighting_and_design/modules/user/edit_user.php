<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location: user.php");
        exit;
    }

    $id = $_GET["id"];

    //connection to database to get user by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_USER_BY_ID);
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt->fetchAll();

        $item = $data_list[0];
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $conn = null;


//update user to database when submit form
if (!empty($_POST)) {
    $fullname     = $_POST["fullname"];
    $username     = $_POST["username"];
    $email        = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $role         = $_POST["role"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_UPDATE_USER);

        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":user_id", $id);

        $stmt->execute();

        header("Location: user.php");
        exit;
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            ["icon" => "bi-people-fill", "label" => "User Management", "url" => "user.php"],
            ["icon" => "bi-person-fill", "label" => "Edit User"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php"; 
    ?>

    <!-- body user page -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">

                <h2 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit User
                </h2>

                <!-- edit form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($item["fullname"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($item["username"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($item["email"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" value="<?= htmlspecialchars($item["phone_number"]) ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="role" value="user" <?= ($item["role"] == "user" ? "checked" : "") ?>>
                            <label class="form-check-label">User</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="role" value="admin"<?= ($item["role"] == "admin" ? "checked" : "") ?>> 
                            <label class="form-check-label">Admin</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save User</button>
                    <a href="user.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

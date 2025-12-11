<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location: user.php");
        exit;
    }

    $id = $_GET["id"];

    //connection to database and get user by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_USER_BY_ID);
        $stmt->bindParam(":user_id", $id);
        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$item) {
            header("Location: user.php");
            exit;
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $conn =null;

    if (!empty($_POST)) 
    {
        //get new data
        $fullname     = $_POST["fullname"];
        $username     = $_POST["username"];
        $email        = $_POST["email"];
        $phone_number = $_POST["phone_number"];
        $role         = $_POST["role"];

        //connection to database and update user
        try 
        {
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
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }

        $conn = null;
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
    <link rel="stylesheet" href="../../assets/css/modules.css?v=<?= time() ?>">
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
            ["icon" => "bi-people-fill", "label" => "User Management", "url" => "user.php"],
            ["icon" => "bi-pencil-square", "label" => "Edit User"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
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
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="fullname" 
                               value="<?= htmlspecialchars($item["fullname"]) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username"
                               value="<?= htmlspecialchars($item["username"]) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                               value="<?= htmlspecialchars($item["email"]) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number"
                               value="<?= htmlspecialchars($item["phone_number"]) ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label><br>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" 
                                   name="role" value="user"
                                   <?= $item["role"] === "user" ? "checked" : "" ?>>
                            <label class="form-check-label">User</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" 
                                   name="role" value="admin"
                                   <?= $item["role"] === "admin" ? "checked" : "" ?>>
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

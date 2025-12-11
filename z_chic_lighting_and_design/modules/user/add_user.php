<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!empty($_POST)) 
    {
        // get data from form
        $fullname     = $_POST["fullname"];
        $username     = $_POST["username"];
        $email        = $_POST["email"];
        $phone_number = $_POST["phone_number"];
        $password     = $_POST["password"];
        $role         = $_POST["role"];

        // password encrypt
        $password = password_hash($password, PASSWORD_DEFAULT);

        //connection to database and add new user
        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_ADD_USER);

            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone_number", $phone_number);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);

            $stmt->execute();

            header("Location: user.php");
            exit;
        }
        catch (PDOException $e) {
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
    <title>Add New User</title>

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
            ["icon" => "bi-people-fill", "label" => "User Management", "url" => "user.php"],
            ["icon" => "bi-person-fill", "label" => "Add User"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">

                <h2 class="page-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Add New User
                </h2>

                <!-- add form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="role" value="user" checked>
                            <label class="form-check-label">User</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="role" value="admin">
                            <label class="form-check-label">Admin</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add User</button>
                    <a href="user.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

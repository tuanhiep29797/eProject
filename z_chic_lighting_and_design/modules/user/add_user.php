<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if(!empty($_POST))
    {
        //get data from form input
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        //password encryption
        $password = password_hash($password, PASSWORD_DEFAULT);

        //connect to database and push data to database
        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_ADD_USER);
            $stmt -> bindParam(':fullname', $fullname);                
            $stmt -> bindParam(':username', $username);                
            $stmt -> bindParam(':email', $email);                
            $stmt -> bindParam(':phone_number', $phone_number);                
            $stmt -> bindParam(':password', $password);                
            $stmt -> bindParam(':role', $role);                
            $stmt -> execute();

            header('Location: user.php');
        }
        catch (PDOException $e)
        {
            $e -> getMessage();
        }

        $conn = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css">
</head>
<body>
    <!-- include header -->
    <?php
        require_once __DIR__."/../../admin/admin_header.php"; 
    ?>

    <!-- body user page -->
    <div class="container table-container">

        <!-- breadcrumb -->
        <div class="mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center">
                    <li class="breadcrumb-item">
                        <a href="../../admin/home_admin.php" class="d-flex align-items-center text-decoration-none">
                            <i class="bi bi-house-door me-1"></i> Admin
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="user.php" class="d-flex align-items-center text-decoration-none">
                            <i class="bi bi-people-fill me-1"></i> User Management
                        </a>
                    </li>

                    <li class="breadcrumb-item active d-flex align-items-center" aria-current="page">
                        <i class="bi bi-person-fill me-1"></i> Add User
                    </li>
                </ol>
            </nav>
        </div>

        <!-- body -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-md-12">

                <h2 class="page-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Add New User
                </h2>

                <!-- input form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="fullname">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
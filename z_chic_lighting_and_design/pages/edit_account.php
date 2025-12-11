<?php
require_once(__DIR__ . "/../database/dbhelper.php");


if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
        select *
        from user
        where user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $userList = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo '<script>
        alert("Please log in to view your cart.");
        window.location.href = "../admin/login.php";
    </script>';
    exit();
}
$conn = null;

    if (!empty($_POST)) 
    {
        $user_id = $_SESSION["id"];
        // get data from form
        $fullname     = $_POST["fullname"];
        $username     = $_POST["username"];
        $email        = $_POST["email"];
        $phone_number = $_POST["phone_number"];


        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare('
                UPDATE user 
                SET 
                    fullname = :fullname,
                    username = :username,
                    email = :email,
                    phone_number = :phone_number
                WHERE user_id = :user_id
            ');
            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone_number", $phone_number);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            header("Location: account.php");
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
    <title>User Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/style.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <div class="page-banner">
        <div class="container">
            <h2>Edit Account</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>

                <i class="bi bi-chevron-right"></i>
        
                <a href="account.php">Account</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Edit Account</a>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="container my-5 ">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">

                <h2 class="page-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Edit Account
                </h2>

                <!-- add form -->
                <form method="post" class="card-form">
                <?php foreach ($userList as $item): ?>

                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="fullname" value="<?= $item['fullname'] ?>" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $item['username'] ?>" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $item['email'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" value="<?= $item['phone_number'] ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Edit Account</button>
                    <a href="account.php" class="btn btn-secondary ms-2">Cancel</a>
                <?php endforeach; ?>
                </form>

            </div>
        </div>
    </div>
    <?php
    require_once(__DIR__ . "/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

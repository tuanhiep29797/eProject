<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    if (isset($_SESSION["user_id"])) 
    {
        $user_id = $_SESSION["user_id"];

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_GET_USER_BY_ID);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $userList = $stmt->fetchAll();
        } 
        catch (PDOException $e) 
        {
            echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
        }
        $conn = null;
    } 
    else 
    {
        echo '<script>
                alert("Please log in to view your cart.");
                window.location.href = "../admin/login.php";
            </script>';
        exit();
    }
    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>
    
    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <!-- banner -->
    <div class="page-banner">
        <div class="container">
            <h2>Account</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Account</a>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="container px-3 px-md-4">
        <div class="shopping-cart-header my-3 my-md-4 text-center">
            <h1>Account</h1>
        </div>
        <div class="row mx-0 mx-md-3 mx-xl-5 my-3">

            <div class="col-12 col-md-4 col-xl-4 mb-4 mb-xl-0">
                <div class="account-card p-3 p-md-4">
                    <h5 class="fw-bold mb-3 mb-md-4">Account</h5>

                    <a href="#" class="account-item">
                        <i class="bi bi-person"></i>
                        <div>
                            <p class="title">My Profile</p>
                            <span class="desc d-none d-md-block">Change your profile details & password</span>
                        </div>
                    </a>

                    <a href="order_history.php" class="account-item">
                        <i class="bi bi-bag-check"></i>
                        <div>
                            <p class="title">My Orders</p>
                            <span class="desc d-none d-md-block">View & Manage orders</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-8 col-xl-8">
                <div class="account-info-box mt-0 mt-xl-4">
                    <?php foreach($userList as $item): ?>
                    <h3 class="fw-bold mb-4">Account information</h3>
                    <div class="info-row">
                        <span class="label">Full Name</span>
                        <span class="value"><?= $item['fullname'] ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">User name</span>
                        <span class="value"><?= $item['username'] ?></span>
                    </div>

                    <div class="info-row">
                        <span class="label">Email</span>
                        <span class="value"><?= $item['email'] ?></span>
                    </div>

                    <div class="info-row">
                        <span class="label">Phone number</span>
                        <span class="value"><?= $item['phone_number'] ?></span>
                    </div>
                    <?php endforeach; ?>
                    <a href='edit_account.php'><button class="btn btn-success mt-4">Edit Profile</button></a>
                </div>
            </div>
        </div>
    </div>


    <!-- include footer -->
    <?php
        require_once(__DIR__ . "/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
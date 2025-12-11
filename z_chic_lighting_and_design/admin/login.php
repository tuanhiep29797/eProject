<?php
    require_once (__DIR__."/../database/dbhelper.php");

    if (is_login())
    {
        header("Location: " . BASE_URL . "home_page.php");
    }

    //error variable
    $login_error = "";

    //check form_type
    if (!empty($_POST["form_type"])) 
        {

        //handle form login
        if ($_POST["form_type"] === "login") 
        {
            $account = trim($_POST["account"] ?? "");
            $password = $_POST["password"] ?? "";

            if ($account === "") $login_error = "Email or Username is required.";
            if ($password === "") $login_error = "Password is required.";

            try 
            {
                //search account
                $conn = getConnection();
                $stmt = $conn->prepare(SQL_SEARCH_USER);
                $stmt->bindParam(":account", $account);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $dataList = $stmt->fetchAll();

                if ($dataList == null || count($dataList) == 0) 
                {
                    $login_error = "Username or Password incorrect.";
                }
                else
                {
                    $user = $dataList[0];

                    //verify password
                    if (!password_verify($password, $user["password"])) 
                    {
                        $login_error = "Username or Password incorrect.";
                    } 
                    else 
                    {
                        //save user infomation
                        $_SESSION["username"] = $user["username"];
                        $_SESSION["fullname"] = $user["fullname"];
                        $_SESSION["email"] = $user["email"];
                        $_SESSION["user_id"] = $user["user_id"];
                        $_SESSION["role"] = $user["role"];

                        //check role
                        switch ($user["role"])
                        {
                            case "admin":
                                header("Location: home_admin.php");
                                exit();
                            case "user":
                                header("Location: ../pages/home_page.php");
                                exit();
                            default:
                                break;
                        }
                    }
                }
            } 
            catch (PDOException $e) 
            {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
        }


        //handle form forget password
        if ($_POST["form_type"] === "forget") {
            $email_forget = trim($_POST["email_forget"] ?? "");
    
            $forgetErrors = "Hi $email_forget, A password reset email has been sent to your email. Thank you!";
            
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>
    <div class="login">

        <!-- include header -->
        <?php 
            require_once __DIR__ . "/../includes/home_header.php";
        ?>

        <!-- Login start  -->
        <div class="container">
            <div class="row mt-5 pt-5 ">
                <div class="col-lg-5 col-sm-12 col-md-6 col-12" style="margin:auto;">
                    <div class="login-form wpx">
                        <h3 class="text-center py-3">LOGIN</h3>
                        <div class="form-login ">
                            <form method="POST">
                                <div class="form-group mb-3 fw-bold position-relative">
                                    <input type="hidden" name="form_type" value="login">
                                    <label for='account' class="email_login"><i class="bi bi-envelope"></i></label>
                                    <input type="text" placeholder="Email or Username" name="account" id='account' required class="input-login">
                                    <input type="password" placeholder="Password" name="password" id="password" required class="input-login mb-0">
                                    <span id="togglePassword" class="togglePassword">
                                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                                <p id="forget_password">Forget Password?</p>
                                <button class="btn btn-success w-100 mt-4" type="submit">Login</button>
                            </form>
                            <?php if (isset($login_error)): ?>
                                <div class="text-danger mt-3">
                                        <p><?= htmlspecialchars($login_error) ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="register-login d-flex mt-4 justify-content-between">
                                <p style="cursor: pointer;">Don't have an Account?</p>
                                <a href="./register.php" class="text-decoration-none fw-semibold text-dark"><strong>Register</strong></a>
                            </div>
                        </div>
                        <div class="form-forget-password d-none" id="box_forget_password">
                            <form method="POST">
                                <h3 class="text-center">Retrieve Password</h3>
                                <input type="hidden" name="form_type" value="forget">
                                <input type="email" placeholder="Email" name="email_forget" required class="input-login">
                                <button class="btn btn-success w-100 fw-bold" type="submit">Submit</button>
                            </form>
                            <?php if (!empty($forgetErrors)): ?>
                                <script>
                                    alert("<?= $forgetErrors?>");
                                </script>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- include footer -->
    <?php
        require_once __DIR__ . "/../includes/home_footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const forget_password = document.getElementById("forget_password");
        const box_forget_password = document.getElementById("box_forget_password");

        const password = document.getElementById("password");
        const eye_icon = document.getElementById("eyeIcon");

        document.getElementById("togglePassword").onclick = function() {
            if (password.type === "password") {
                password.type = "text"
                eye_icon.classList.remove("bi-eye-slash");
                eye_icon.classList.add("bi-eye");
            } else {
                password.type = "password"
                eye_icon.classList.remove("bi-eye");
                eye_icon.classList.add("bi-eye-slash");
            }
        }

        forget_password.onclick = function() {
            box_forget_password.classList.toggle("show");
        }
    </script>
    
</body>

</html>
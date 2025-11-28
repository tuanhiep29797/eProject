<?php
require_once("../database/dbhelper.php");
session_start();
$loginErrors = [];
if (!empty($_POST["form_type"])) {
    if ($_POST["form_type"] === "login") {
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        if ($email === "") $loginErrors[] = "Email is required.";
        if ($password === "") $loginErrors[] = "Password is required.";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $loginErrors[] = "Invalid email format.";
        }

        try {
            $conn = getConnection();
            $stmt = $conn->prepare("select * from user where email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $dataList = $stmt->fetchAll();

            if ($dataList == null || count($dataList) == 0) {
                $loginErrors[] = "Email or password is not correct.";
            } else {
                $user = $dataList[0];
                if (!password_verify($password, $user['password'])) {
                    $loginErrors[] = "Email or password is not correct.";
                } else {
                    $_SESSION['user'] = $user;
                    header("Location: ../pages/home.php"); 
                    exit();
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }

    if ($_POST["form_type"] === "forget") {
        $email_forget = trim($_POST["email_forget"] ?? "");
   
        $forgetErrors = "Hi $email_forget, A password reset email has been sent to the administrator. Thank you!";
          
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
    <title>Login</title>
</head>

<body>
    <div class="login">
        <?php require "../includes/header.php"; ?>
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
                                    <label for='email' class="email_login"><i class="bi bi-envelope"></i></label>
                                    <input type="email" placeholder="Email" name="email" id='email' required class="input-login">
                                    <input type="password" placeholder="Password" name="password" id="password" required class="input-login mb-0">
                                    <span id="togglePassword" class="togglePassword">
                                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                                <p id="forget_password">Forget Password?</p>
                                <button class="btn btn-success w-100 mt-4" type="submit">Login</button>
                            </form>
                            <?php if (!empty($loginErrors)): ?>
                                <div class="text-danger mt-3">
                                    <?php foreach ($loginErrors as $err): ?>
                                        <p><?= htmlspecialchars($err) ?></p>
                                    <?php endforeach; ?>
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
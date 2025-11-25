<?php
require_once("../database/dbhelper.php");
session_start();
$errors = [];
$isRegister = true;

if (!empty($_POST)) {
    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if ($fullname === "") $errors[] = "Fullname is required.";
    if ($username === "") $errors[] = "Username is required.";
    if ($phone === "") $errors[] = "Phone number is required.";
    if ($email === "") $errors[] = "Email is required.";
    if ($password === "") $errors[] = "Password is required.";
    if ($confirm_password === "") $errors[] = "Confirm password is required.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($password !== $confirm_password){
        $errors[] = "Password and confirm password do not match.";
    }
    
    if(empty($errors))
    {   
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $conn = getConnection();
        $check = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $check->bindParam(":email", $email);
        $check->execute();

        $result = $check->setFetchMode(PDO::FETCH_ASSOC);
		$dataList = $check->fetchAll();

        if($dataList != null && count($dataList) > 0){
            $errors[] = "This email is already registered.";
            $isRegister = false;
        }
        else {
            try {
                $conn = getConnection();
                $stmt = $conn->prepare("INSERT INTO user (fullname, username, phone_number, email, password)
                    VALUES (:fullname, :username, :phone_number, :email, :password)");
                $stmt->bindParam(":fullname", $fullname);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":phone_number", $phone);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->execute();

                header('Location: login.php');
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
        }
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
            <div class="row mt-3">
                <div class="col-lg-5 col-sm-12 col-md-6 col-12" style="margin:auto;">
                    <div class="login-form wpx">
                        <h3 class="text-center pt-3 text-uppercase">Register</h3>
                        <div class="form-login ">
                            <form method="POST">
                                <div class="form-group fw-bold">
                                    <input type="text" placeholder="Fullname" name="fullname" required class="input-login text-dark">
                                    <input type="text" placeholder="Username" name="username" required class="input-login">
                                    <input type="number" placeholder="Phone number" name="phone" required class="input-login">
                                    <input type="email" placeholder="Email" name="email" required class="input-login">
                                    <input type="password" placeholder="Password" name="password" id="password1" required class="input-login">
                                    <span class="togglePassword1" id="togglePassword1">
                                        <i class="bi bi-eye-slash" id="eyeIcon1"></i>
                                    </span>

                                    <input type="password" placeholder="Confirm password" name="confirm_password" id="password2" required class="input-login">
                                    <span class="togglePassword2" id="togglePassword2">
                                        <i class="bi bi-eye-slash" id="eyeIcon2"></i>
                                    </span>
                                </div>
                                <?php if (!empty($errors)): ?>
                                    <div class="text-danger">
                                        <?php foreach ($errors as $err): ?>
                                            <p><?= htmlspecialchars($err) ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <button class="btn btn-success w-100 mt-2 fw-bold" type="submit">Register</button>
                            </form>
                            <div class="register-login d-flex mt-3 justify-content-between">
                                <p style="cursor: pointer;">I have an Account?</p>
                                <a href="./login.php" class="text-decoration-none fw-semibold text-dark"><strong>Login</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function setupToggle(passId, iconId, toggleId) {
        const pass = document.getElementById(passId);
        const icon = document.getElementById(iconId);

        document.getElementById(toggleId).onclick = function () {
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                pass.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    }
    setupToggle("password1", "eyeIcon1", "togglePassword1");
    setupToggle("password2", "eyeIcon2", "togglePassword2");
    </script>
</body>
</html>
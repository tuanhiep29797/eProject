<?php

// session_start();
$error = [];
if (!empty($_POST["form_type"])) {
    if($_POST["form_type"] === "login"){
        $email = $_POST["email"];
        $password = $_POST["password"];

        try{
            $conn = getConnection();
            $stmt = $conn->prepare("select * from user where email = :email");
            $stmt->bindParam(":email", $email);
		    $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    $dataList = $stmt->fetchAll();

            if($dataList == null || count($dataList) == 0) {
            $error['email'] = "Email or password is not correr";
            $error['pwd'] = "Email or password is not correr";
        }
        $std = $dataList[0];

        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        $conn = null;
    }

    if ($_POST["form_type"] === "forget") {
        $email_forget = $_POST["email_forget"];

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
    <?php require "../includes/header.php"; ?>
    <!-- Login start  -->
    <div class="container my-3">
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-md-6 col-12" style="margin:auto;">
                <div class ="login wpx">
                    <div class="login-button">
                        <ul class="list-unstyled">
                            <li class="active">
                                <a href="#" class="text-decoration-none">Login</a>
                            </li>
                            <li>
                                <a href="/account/register" class="text-decoration-none">Register</a>
                            </li>
                        </ul>
                    </div>
                    <div class="form-login">
                        <form method="POST">
                            <div class="form-group mb-3">
                                <input type="hidden" name="form_type" value="login">
                                <input type="email" placeholder="Email" name = "email" required class="form-control input-test">
                                <input type="password" placeholder="Password" name = "password" required class="form-control input-test">
                            </div>
                            <button class="btn btn-success w-100" type="submit">Login</button>
                        </form>
                        <p class="text-center my-3 forget_password" id ="forget_password">Forget Password?</p>
                    </div>
                    <div class="form-forget-password d-none" id="box_forget_password">
                        <form method="POST">
                            <input type="hidden" name="form_type" value="forget">
                            <input type="email" placeholder="Email" name = "email_forget" required class="form-control input-test">
                            <button class="btn btn-success w-100" type="submit">Retrieve Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const forget_password = document.getElementById("forget_password");
        const box_forget_password = document.getElementById("box_forget_password");

        forget_password.onclick = function(){
            box_forget_password.classList.toggle("show");
        }
    </script>
</body>
</html>
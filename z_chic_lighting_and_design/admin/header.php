<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Admin Header</title>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="row d-flex align-items-center header-index ">
                <!-- header left start -->
                <div class="header_left col-lg-2 p-5 py-3">
                    <a href="header.php">
                        <img src="../img/img_logo1.png" alt="Logo" class="logo-box"/>
                    </a>
                </div>
                <!-- header menu start -->
                <div class="col-lg-8">
                    <div class="header_menu">
                        <nav class="navbar navbar-expand-lg p-0">
                            <ul class="navbar-nav gap-3 mx-auto">
                                <li class="nav-item d-flex align-items-center fs-3">
                                    <i class="bi bi-house-fill text-success "></i>
                                    <a class="nav-link text-success" id="header_click" href="#">Home</a>
                                </li>
                                <li class="nav-item d-flex align-items-center fs-3">
                                    <i class="bi bi-person-fill-gear text-primary"></i>
                                    <a class="nav-link text-primary fw-bold" href="#" id="header_click">Admin</a>
                                </li>                       
                            </ul>
                        </nav>
                    </div>
                </div>    
            </div>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
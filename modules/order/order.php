<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    $limit = 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page'])
        ? max(1, (int)$_GET['page'])
        : 1;
    $offset = ($page - 1) * $limit;

    $total_orders = 0;
    $total_pages = 0;

    // connect database and get order table
    try
    {
        $conn = getConnection();

        $stmt = $conn->prepare(SQL_COUNT_ORDER);
        $stmt->execute();
        $total_orders = $stmt->fetchColumn();
        $total_pages = ceil($total_orders / $limit);

        $stmt = $conn->prepare(
            SQL_GET_ORDER . " ORDER BY order_id DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $order_list = $stmt -> fetchAll();
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>
<body>
    <!-- include header -->
    <?php
        require_once __DIR__."/../../admin/admin_header.php"; 
    ?>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-auto bg-dark">
                <?php require_once(__DIR__ . "/../../admin/admin_side_bar.php"); ?>
            </div>

    <!-- body order management page -->
    <div class="col overflow-hidden p-4">
    <?php
        $breadcrumb = 
        [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => BASE_URL . "admin/dashboard"],
            ["icon" => "bi-people-fill", "label" => "Order Management"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php"; 
    ?>
        <form method="post" action = '<?= BASE_URL ?>admin/order/save' >
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-boxes me-2"></i>
                Order Management
            </h2>

            <button type='submit' class="btn btn-success">
                <i class="bi bi-patch-check-fill"></i>
                Save All
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Receiver</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($order_list as $item): ?>
                        <?php
                            $selected = [];
                            $selected[$item["order_status"]] = "selected";
                        ?>
                        <input type="hidden" name="order_id[]" value="<?= $item["order_id"] ?>">
                        <tr>
                            <th><?= $item["order_id"] ?></th>
                            <td>$<?= number_format($item["total_amount"],2) ?></td>
                            <td><?= $item["receiver"] ?></td>
                            <td><?= $item["phone_number"] ?></td>
                            <td style="width: 230px;"><?= $item["address"] ?></td>
                            <td>    
                                <select class="form-select" name="order_status[]"
                                    style="color:<?= isset($selected["pending"]) || isset($selected["cancelled"]) ? 
                                                "red" :
                                                (isset($selected["processing"]) ? "orange" :
                                                    (isset($selected["shipped"]) ? "brown" : "green"))?>;"
                                >
                                    <?php switch ($item["order_status"])
                                    {
                                        case "pending":
                                            echo '<option style="color:red;" selected value="pending">⏰ Pending</option>';
                                        case "processing":
                                            echo '<option style="color:orange;" value="processing"' . $selected["processing"] . '>📦 Processing</option>';
                                        case "shipped":
                                            echo '<option style="color:brown;" value="shipped"' . $selected["shipped"] . '>🚕 Shipped</option>';
                                        case "delivered":
                                            echo '<option style="color:green;" value="delivered"' . $selected["delivered"] . '>✅ Delivered</option>';
                                            if(isset($selected["delivered"]))
                                            {
                                                break;
                                            }
                                        case "cancelled":
                                            echo '<option style="color:red;" value="cancelled"' . $selected["cancelled"] . '>❌ Cancelled</option>';
                                    } 
                                    ?>
                                        
                                </select>
                            </td>
                            <td><?= date("H:i d/m/Y", strtotime($item["order_date"])) ?></td>

                            <td>
                                <a href="<?= BASE_URL ?>admin/order/edit/<?= $item["order_id"] ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= BASE_URL ?>admin/order/order-detail/<?= $item["order_id"] ?>" 
                                   class="btn btn-info btn-sm text-white">
                                    <i class='bi bi-eye-fill'></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">

                    <!-- Previous -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>

                    <?php
                    $start = max(1, $page - 2);
                    $end   = min($total_pages, $page + 2);
                    ?>

                    <?php if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($end < $total_pages): ?>
                        <?php if ($end < $total_pages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $total_pages ?>">
                                <?= $total_pages ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Next -->
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>

                </ul>
            </nav>
            <?php endif; ?>

        </div>
        </form>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
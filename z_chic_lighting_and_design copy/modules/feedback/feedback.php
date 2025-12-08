<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (isset($_GET["read_id"])) 
    {
        $read_id = $_GET["read_id"];

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_UPDATE_FEEDBACK_STATUS);

            $new_status = "readed";

            $stmt->bindParam(":status", $new_status);
            $stmt->bindParam(":feedback_id", $read_id);
            $stmt->execute();

            header("Location: feedback.php");
            exit;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //get all feedback
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_FEEDBACK);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt->fetchAll();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css">
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
            ["icon" => "bi-chat-left-text-fill", "label" => "Feedback Management"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php"; 
    ?>

    <!-- body -->
    <div class="container table-container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-chat-left-dots-fill me-2"></i>
                Feedback Management
            </h2>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data_list as $index => $item): ?>

                        <?php 
                            $status = ($item["status"] === "new")
                                ? "<span class='badge bg-danger'>New</span>"
                                : "<span class='badge bg-success'>Read</span>";
                        ?>

                        <tr class="<?= $item["status"] === "new" ? 'table-warning' : '' ?>">
                            <th><?= $index + 1 ?></th>
                            <td><?= $item["username"] ?></td>
                            <td><?= $item["email"] ?></td>
                            <td><?= $item["phone_number"] ?></td>
                            <td><?= $item["content"] ?></td>
                            <td><?= $status ?></td>
                            <td><?= date("H:i:s d/m/Y", strtotime($item["created_at"])) ?></td>

                            <td>
                                <?php if ($item["status"] === "new"): ?>
                                    <a href="feedback.php?read_id=<?= $item['feedback_id'] ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-check2-circle"></i> Mark as Read
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="bi bi-check-lg"></i> Readed
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

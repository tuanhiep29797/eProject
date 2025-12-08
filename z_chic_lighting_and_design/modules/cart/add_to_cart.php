<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    if (!is_login())
    {
        header("Location: " . BASE_URL ."admin/login.php");
        exit();
    }
    else
    {
        $user_id = $_SESSION["user_id"];

        if(!empty($_GET["id"]))
        {
            $id = $_GET["id"];

            try
            {
                $conn = getConnection();
                $stmt = $conn->prepare(SQL_GET_CARD_BY_USER_AND_PRODUCT);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":product_id", $id);
                $stmt->execute();

                $add_to_cart_result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $dataList = $stmt->fetchAll();

                if($data_list == null && count($data_list) == 0)
                {
                    $quantity = 1;
                }
                else
                {
                    $quantity = $data_list[0]["quantity"] + 1;
                }
            }
            catch (PDOException $e)
            {
                echo $e -> getMessage();
            }

            try
            {
                $conn = getConnection();
                $stmt = $conn->prepare(SQL_ADD_CART);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":product_id", $product_id);
                $stmt->bindParam(":quantity", $quantity);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $dataList = $stmt->fetchAll();
            }
            catch (PDOException $e)
            {
                echo $e -> getMessage();
            }
        }

        header("Location: " . BASE_URL . "");
        exit();
    }
?>
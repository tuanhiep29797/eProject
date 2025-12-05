<?php
require_once(__DIR__ . "/config.php");

function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . HOST . ";dbname=" . DBNAME,
            USERNAME,
            PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function getConnectionInit() {
    try {
        $conn = new PDO(
            "mysql:host=" . HOST,
            USERNAME,
            PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Init connection failed: " . $e->getMessage());
    }
}

function executeQuery($sql, $params = []) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        return [];
    }
}

function executeNonQuery($sql, $params = []) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        if (stripos($sql, "INSERT") === 0) {
            return $conn->lastInsertId();
        }
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log("Execution Error: " . $e->getMessage());
        return false;
    }
}
?>

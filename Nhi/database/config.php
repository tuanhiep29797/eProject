<?php
session_start();

// DATABASE CONFIG
define("HOST", "localhost");
define("DBNAME", "db_cl_and_d");
define("USERNAME", "root");
define("PASSWORD", "");

// BASE URL (tùy folder của bạn)
define("BASE_URL", "/Eproject/z_chic_lighting_and_design");

// CHECK LOGIN FUNCTION
function isLogin() {
    return isset($_SESSION['userInfo']);
}
?>
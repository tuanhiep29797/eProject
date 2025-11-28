<?php
    //create a sesstion
    session_start();

    //define var to connect database
    define("HOST", "localhost");
    define("DBNAME", "db_cl_and_d");
    define("USERNAME", "root");
    define("PASSWORD", "");

    //function check Login
    function isLogin() {
        if(isset($_SESSION['userInfo'])) {
            return true;
        }
        return false;
    }
?>
<?php
    //create a sesstion
    session_start();

    //define var to connect database
    define("HOST", "localhost");
    define("DBNAME", "db_cl_and_d");
    define("USERNAME", "root");
    define("PASSWORD", "");

    define("BASE_URL", "http://localhost/eProject/z_chic_lighting_and_design/");

    //function check Login
    function is_login() {
        if(isset($_SESSION["username"])) {
            return true;
        }
        return false;
    }

    //function check Admin
    function is_admin() 
    {
        return is_login() && $_SESSION["role"] === "admin";
    }
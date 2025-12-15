<?php
    //create a sesstion
    session_start();

    //define var to connect database
    define("HOST", "localhost");
    define("DBNAME", "db_cl_and_d");
    define("USERNAME", "root");
    define("PASSWORD", "");

    define("BASE_URL", "http://localhost/ChicLightingAndDesign/");

    //function check Login
    function is_login() {
        // var_dump($_SESSION);
        // die();
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

    //function create slug
    function create_slug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        return trim($string, '-');
    }
<?php
//create a sesstion
session_start();

//define var to connect database
define("HOST", "localhost");
define("DBNAME", "db_cl_and_d");
define("USERNAME", "root");
define("PASSWORD", "");

//define base url for the project
define("BASE_URL", "/Eproject/z_chic_lighting_and_design");

//function check Login
function isLogin()
{
  if (isset($_SESSION['userInfo'])) {
    return true;
  }
  return false;
}
?>
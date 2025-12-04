<?php
    session_start();
    if (isset($_SESSION["Runtime"]))
    {
        $runtime = $_SESSION["Runtime"];
    }
    else
    {
        $runtime = 0;
    }
    if ($runtime === 0)
    {
        require_once __DIR__ ."/database/db.php";
        $_SESSION["Runtime"] = 1;
    }

    header("Location: ./admin/login.php");
?>
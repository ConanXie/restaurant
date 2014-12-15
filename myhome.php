<?php
    session_start();
    require('header.php');
    if (!isset($_SESSION['USERNAME'])) {
        header("Location: ".$config_basedir);
        exit();
    }
?>
<a href="logout.php">退出</a>
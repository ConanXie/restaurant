<?php
    session_start();
    require('header.php');
    if (!isset($_SESSION['USERNAME'])) {
        header("Location: ".$config_basedir);
        exit();
    }
    echo '<p>欢迎你，'.$_SESSION['USERNAME'].'</p>';
?>
<a href="logout.php">退出</a>
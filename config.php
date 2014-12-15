<?php
    $conn = mysql_connect("localhost", "root", "conan") or die("数据库连接失败".mysql_error());
    mysql_select_db("restaurant", $conn);
    mysql_query("set names utf8");
    $config_basedir = "http://192.168.1.112:8080/restaurant/";
?>
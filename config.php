<?php
    /*$conn = mysql_connect("localhost", "root", "conan") or die("数据库连接失败".mysql_error());
    mysql_select_db("restaurant", $conn);
    mysql_query("set names utf8");*/
    $mysqli = new mysqli('localhost', 'root', 'conan', 'restaurant');
    $mysqli->query('set names utf8');
    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
    }
    // $config_basedir = "http://192.168.1.100/restaurant/";
    $config_basedir = "http://localhost/restaurant/";
?>
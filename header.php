<?php
    session_start();
    require("config.php");
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width, user-scalable=0">
    <title>Conan Restaurant</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/islider.css">
    <script src="js/islider.js"></script>
    <script src="js/islider_plugin.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    <header>
        <a href="index.php">Conan</a>
        <div id="menu-button">&#xe807;</div>
        <div id="user">&#xe8e6;</div>
    </header>
    <div id="shade"></div>
    <aside>
        <h3>菜单</h3>
        <ul>
            <?php
                $cate_sql = "SELECT * FROM dishcate;";
                $cate_result = mysql_query($cate_sql);
                while ($cate_row = mysql_fetch_array($cate_result)) {
                    echo '<li><a href=""><span class="icon">&#xe88f;</span><p class="cate">'.$cate_row["cate"].'</p></a></li>';
                }
            ?>
        </ul>
    </aside>
    <div id="occupy"></div>
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
</head>
<body>
    <script src="js/main.js"></script>
    <header>
        <a href="index.php">Conan</a>
        <div id="menu-button">&#xe807;</div>
        <?php
            if (isset($_SESSION['USERNAME'])) {
                echo '<a id="user" href="myhome.php">&#xe8e5;</a>';
            } else {
                echo '<a id="user" href="joinin.php">&#xe8e6;</a>';
            }
        ?>
    </header>
    <div id="shade"></div>
    <aside>
        <h3>菜单</h3>
        <ul>
            <?php
                $cate_sql = "SELECT * FROM dishcate;";
                $cate_result = $mysqli->query($cate_sql);
                while ($cate_row = $cate_result->fetch_array()) {
                    echo '<li><a href="viewcate.php?id='.$cate_row["id"].'"><span class="icon">&#xe88f;</span><p class="cate">'.$cate_row["cate"].'</p></a></li>';
                }
            ?>
        </ul>
    </aside>
    <div class="occupy"></div>
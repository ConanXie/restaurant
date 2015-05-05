<?php
    require('../config.php');
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="aside">
        <a href="index.php">订单查看</a>
        <a href="reco.php">推荐菜品</a>
        <a href="special.php">特价菜品</a>
        <a href="cate.php">菜品管理</a>
    </div>
    <div class="atc">
        <div class="cate-box">
            <a href="cate.php">全部</a>
            <?php
                $cate = mysql_query("SELECT * FROM dishcate;");
                while ($cate_row = mysql_fetch_array($cate)) {
                    echo '<a href="cate.php?id='.$cate_row['id'].'">'.$cate_row['cate'].'</a>';
                }
            ?>
        </div>
        <div class="dish-box">
            <?php
                if ($_GET['id'] && is_numeric($_GET['id'])) {
                    $dish = mysql_query("SELECT * FROM dish WHERE dishcate = ".$_GET['id'].";");
                } else {
                    $dish = mysql_query("SELECT * FROM dish;");
                }
                while ($dish_row = mysql_fetch_array($dish)) {
                    echo '<a href="edit.php?id='.$dish_row['id'].'">'.$dish_row['name'].'</a>';
                }
            ?>
        </div>
    </div>
</body>
</html>
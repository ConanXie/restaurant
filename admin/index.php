<?php
    require('../config.php');
    /*if (isset($_POST['submit'])) {
        if (isset($_POST['user']) && isset($_POST['pw'])) {
            $admin_sql = "SELECT * FROM admin WHERE username = '".$_POST['user']."' AND password = '".$_POST['pw']."';";
            $result = mysql_query($admin_sql);
            $admin_num = mysql_num_rows($result);
            if (!$admin_num) {
                header("Location: ".$config_basedir."admin/login.php?error=1");
                exit();
            }
            $admin = mysql_fetch_array($result);
            $_SESSION['admin'] = $admin['id'];
        } else {
            header("Location: ".$config_basedir."admin/login.php?error=1");
        }
    }
    if (!$_SESSION['admin']) {
        header("Location: ".$config_basedir."admin/login.php?error=1");
    }*/
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
        <?php
            $order_result = mysql_query("SELECT * FROM orders;");
            while ($order_row = mysql_fetch_array($order_result)) {
                echo '<div class="order">';
                echo '<p>订单号'.$order_row['id'].'</p>';
                if ($order_row['outsell']) {
                    echo '<p>外卖</p>';
                    $cont = mysql_fetch_array(mysql_query("SELECT * FROM contact WHERE id = ".$order_row['contactid'].";"));
                    echo '<p>'.$cont['name'].'</p>';
                    echo '<p>'.$cont['phone'].'</p>';
                    echo '<p>'.$cont['address'].'</p>';
                } else {
                    echo '<p>店内消费</p>';
                }
                $detail = mysql_query("SELECT odetail.*, dish.* FROM odetail, dish WHERE orderid = ".$order_row['id']." AND dish.id = odetail.dishid;");
                while ($detail_row = mysql_fetch_array($detail)) {
                    echo '<p>'.$detail_row['name'].'</p>';
                    echo '<p>'.$detail_row['num'].'</p>';
                }
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>
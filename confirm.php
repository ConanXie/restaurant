<?php
    require('config.php');
    session_start();
    if (!isset($_SESSION['USERID']) || !isset($_SESSION['confirm'])) {
        header("Location: ".$config_basedir);
        exit();
    } else {
        unset($_SESSION['confirm']);
        if ($_POST['choice']) {
            $order_sql = "INSERT INTO orders (userid, contactid, sumcost, createtime) VALUES (".$_SESSION['USERID'].", ".$_POST['contact'].", ".$_POST['cost'].", now());";
        } else {
            $order_sql = "INSERT INTO orders (userid, outsell, sumcost, createtime) VALUES (".$_SESSION['USERID'].", ".$_POST['choice'].", ".$_POST['cost'].", now());";
        }
        mysql_query($order_sql);
        $order_id = mysql_insert_id();
        foreach($_POST['checkdish'] as $checkdish) {
            $dish_info = explode(' ', $checkdish);
            mysql_query("UPDATE dish SET sellnum = sellnum + ".$dish_info[1]." WHERE id = ".$dish_info[0].";");
            mysql_query("INSERT INTO odetail (orderid, dishid, num, cost) VALUES (".$order_id.", ".$dish_info[0].", ".$dish_info[1].", ".$dish_info[2].");");
        }
        $time = 3;
        $url = $config_basedir;
        header("Refresh: ".$time.";url=".$url);
        require('header.php');
        echo "下单成功，3秒后跳转到主页";
    }
    require('footer.php');
?>
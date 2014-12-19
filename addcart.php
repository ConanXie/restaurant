<?php
    require('config.php');
    if (!$_POST['userid'] || !$_POST['dishid']) {
        echo 'no logged in';
    } else {
        $cart_num = mysql_num_rows(mysql_query("SELECT * FROM cart WHERE userid = ".$_POST['userid']." AND dishid = ".$_POST['dishid'].";"));
        if (!$cart_num) {
            $addcart_sql = "INSERT INTO cart (userid, dishid, createtime) VALUES (".$_POST['userid'].", ".$_POST['dishid'].", now());";
            mysql_query($addcart_sql);
        }
        echo "success";
    }
?>
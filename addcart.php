<?php
    require('config.php');
    session_start();
    if (!isset($_SESSION['USERID']) || !isset($_SESSION['DISHID'])) {
        echo 'no logged in';
    } else {
        $cart_num = $mysqli->query("SELECT * FROM cart WHERE userid = ".$_SESSION['USERID']." AND dishid = ".$_SESSION['DISHID'].";")->num_rows;
        if (!$cart_num) {
            $mysqli->query("UPDATE dish SET cartnum = cartnum + 1  WHERE id = ".$_SESSION['DISHID'].";");
            $addcart_sql = "INSERT INTO cart (userid, dishid, createtime) VALUES (".$_SESSION['USERID'].", ".$_SESSION['DISHID'].", now());";
            $mysqli->query($addcart_sql);
        }
        echo "success";
    }
?>
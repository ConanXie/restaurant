<?php
    require('config.php');
    session_start();
    $eva_sql = "INSERT INTO evaluate (dishid, userid, detailid, star, content, createtime) VALUES (".$_POST['dishid'].", ".$_SESSION['USERID'].", ".$_POST['detail'].", ".$_POST['star'].", '".$_POST['content']."', now());";
    mysql_query($eva_sql);
    mysql_query("UPDATE odetail SET evaluated = 1 WHERE id = ".$_POST['detail'].";");
?>
<?php
    require('config.php');
    session_start();
    $eva_sql = "INSERT INTO evaluate (dishid, userid, detailid, star, content, createtime) VALUES (".$_POST['dishid'].", ".$_SESSION['USERID'].", ".$_POST['detail'].", ".$_POST['star'].", '".$_POST['content']."', now());";
    $mysqli->query($eva_sql);
    $mysqli->query("UPDATE odetail SET evaluated = 1 WHERE id = ".$_POST['detail'].";");
    require('recommendation/recommend.php');
    $reco = new RECO();
    $data = $reco->recommend($_SESSION['USERID'] - 1, $mysqli);
    $reco_sql = "UPDATE user set reco = '".$data."' WHERE id = ".$_SESSION['USERID'].";";
    $mysqli->query($reco_sql);
?>
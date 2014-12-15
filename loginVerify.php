<?php
    session_start();
    require('config.php');
    if ($_POST['submit']) {
        if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $_POST['username'])) {
            $login_sql = "SELECT * FROM user WHERE email = '".$_POST['username']."' AND password = '".$_POST['password']."';";
        } else {
            $login_sql = "SELECT * FROM user WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."';";
        }
        $login_result = mysql_query($login_sql);
        $login_num = mysql_num_rows($login_result);
        if ($login_num == 1) {
            $login_row = mysql_fetch_array($login_result);
            $_SESSION['USERID'] = $login_row['id'];
            $_SESSION['USERNAME'] = $login_row['username'];
            header("Location: ".$config_basedir);
        }
    } else {
        header("Location: ".$config_basedir."joinin.php?error=1");
    }
?>
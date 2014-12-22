<?php
    session_start();
    require('config.php');
    if ($_POST['username'] && !$_POST['password'] && !$_POST['submit']) {
        if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $_POST['username'])) {
            $login_sql = "SELECT * FROM user WHERE email = '".$_POST['username']."';";
        } else {
            $login_sql = "SELECT * FROM user WHERE username = '".$_POST['username']."';";
        }
        $login_result = mysql_query($login_sql);
        $login_num = mysql_num_rows($login_result);
        if (!$login_num) {
            echo 'no user';
        } else {
            echo 'user exist';
        }
    } else if ($_POST['username'] && $_POST['password'] && !$_POST['submit']) {
        if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $_POST['username'])) {
            $login_sql = "SELECT * FROM user WHERE email = '".$_POST['username']."' AND password='".$_POST['password']."';";
        } else {
            $login_sql = "SELECT * FROM user WHERE username = '".$_POST['username']."' AND password='".$_POST['password']."';";
        }
        $login_result = mysql_query($login_sql);
        $login_num = mysql_num_rows($login_result);
        if (!$login_num) {
            echo 'password error';
        }
    } else if ($_POST['submit']) {
        if ($_POST['email']) {
            $signup_sql = "INSERT INTO user (username, password, email, registerdate) values ('".$_POST['username']."', '".$_POST['password']."', '".$_POST['email']."', now());";
            mysql_query($signup_sql);
            $_SESSION['USERNAME'] = $_POST['username'];
            header("Location: ".$config_basedir."myhome.php");
        } else {
            if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $_POST['username'])) {
                $login_sql = "SELECT * FROM user WHERE email = '".$_POST['username']."' AND password='".$_POST['password']."';";
            } else {
                $login_sql = "SELECT * FROM user WHERE username = '".$_POST['username']."' AND password='".$_POST['password']."';";
            }
            $login_result = mysql_query($login_sql);
            $login_row = mysql_fetch_array($login_result);
            $_SESSION['USERNAME'] = $login_row['username'];
            header("Location: ".$config_basedir."myhome.php");
        }
    } else {
        header("Location: ".$config_basedir."joinin.php");
    }
?>
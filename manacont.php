<?php
    require('config.php');
    session_start();
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    }
    switch ($_POST['way']) {
        case 'delete':
            $cont_sql = "DELETE FROM contact WHERE id = ".$_POST['id'].";";
            mysql_query($cont_sql);
            break;
        case 'edit':
            $cont_sql = "UPDATE contact SET name = '".$_POST['name']."', phone = '".$_POST['phone']."', address = '".$_POST['address']."' WHERE id = ".$_POST['id'].";";
            mysql_query($cont_sql);
            break;
        case 'add':
            $cont_sql = "INSERT INTO contact (userid, name, phone, address) VALUES (".$_SESSION['USERID'].", '".$_POST['name']."', '".$_POST['phone']."', '".$_POST['address']."');";
            mysql_query($cont_sql);
            break;
        default:
            echo 'fail';
            break;
    }
?>
<?php
    require('config.php');
    if (isset($_POST['way'])) {
        if ($_POST['way'] == 'edit') {
            if (isset($_POST['cartid']) && is_numeric($_POST['cartid']) && is_numeric($_POST['num'])) {
                mysql_query("UPDATE cart SET num = ".$_POST['num']." WHERE id = ".$_POST['cartid'].";");
            }
        } else if ($_POST['way'] == 'delete') {
            if (is_numeric($_POST['cartid']) && is_numeric($_POST['dishid'])) {
                mysql_query("DELETE FROM cart WHERE id = ".$_POST['cartid'].";");
                mysql_query("UPDATE dish SET cartnum = cartnum - 1 WHERE id = ".$_POST['dishid'].";");
            }
        }
    } else {
        header("Location: ".$config_basedir);
    }
?>
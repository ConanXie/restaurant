<?php
    require('header.php');
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    } else {
        $_SESSION['confirm'] = 'confirm';
        echo '<form action="confirm.php" method="post">';
        echo '<input type="radio" name="choice" value="1" checked>外卖';
        echo '<div>';
        $contact_result = mysql_query("SELECT * FROM contact WHERE userid = ".$_SESSION['USERID'].";");
        while ($contact_row = mysql_fetch_array($contact_result)) {
            echo '<input type="radio" name="contact" value="'.$contact_row['id'].'">联系方式';
            echo '<p>联系人: '.$contact_row['name'].'</p>';
            echo '<p>联系电话: '.$contact_row['phone'].'</p>';
            echo '<p>外卖地址: '.$contact_row['address'].'</p>';
        }
        echo '</div>';
        echo '<input type="radio" name="choice" value="0">店内消费';
        echo "<table border=1>";
        echo "<tr><td>菜名</td><td>单价</td><td>数量</td></tr>";
        $cost = 0;
        foreach($_POST['checkdish'] as $mycheckbox) {
            $dish_info = explode(' ', $mycheckbox);
            $dish_sql = "SELECT * FROM dish WHERE id = ".$dish_info[0].";";
            $dish_row = mysql_fetch_array(mysql_query($dish_sql));
            echo '<tr>';
            echo '<td>'.$dish_row['name'].'</td>';
            echo '<td>'.$dish_row['price'].'</td>';
            echo '<td>'.$dish_info[1].'</td>';
            echo '</tr>';
            $cost += $dish_row['price'] * $dish_info[1];
        }
        echo "</table>";
        foreach($_POST['checkdish'] as $mycheckbox) {
            $dish_info = explode(' ', $mycheckbox);
            $dish_sql = "SELECT * FROM dish WHERE id = ".$dish_info[0].";";
            $dish_row = mysql_fetch_array(mysql_query($dish_sql));
            echo '<input type="checkbox" name="checkdish[]" value="'.$mycheckbox.' '.$dish_row['price'].'" checked style="display: none;">';
        }
        echo '<input type="checkbox" name="cost" checked value="'.$cost.'" style="display: none;">';
        echo '<p>总费用：'.$cost.'</p>';
        echo '<input type="submit" value="提交订单">';
        echo "</form>";
    }
?>
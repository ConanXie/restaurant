<?php
    require('header.php');
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    }
    echo '<link rel="stylesheet" href="css/contact.css">';
    echo '<div class="shade"></div>';
    $cont_sql = "SELECT * FROM contact WHERE userid = ".$_SESSION['USERID'].";";
    $cont_result = mysql_query($cont_sql);
    echo '<ol id="contact-list">';
    if (mysql_num_rows($cont_result)) {
        while ($cont_row = mysql_fetch_array($cont_result)) {
            echo '<li>';
            echo '<div class="cont">';
            echo '<p class="li-name" data-value="'.$cont_row['name'].'">联系人：'.$cont_row['name'].'</p>';
            echo '<p class="li-phone"  data-value="'.$cont_row['phone'].'">电话：'.$cont_row['phone'].'</p>';
            echo '<p class="li-address"  data-value="'.$cont_row['address'].'">地址：'.$cont_row['address'].'</p>';
            echo '</div>';
            echo '<input type="button" class="edit" data-id="'.$cont_row['id'].'" data-way="edit" value="编辑">';
            echo '<input type="button" class="delete" data-id="'.$cont_row['id'].'" data-way="delete" value="删除">';
            echo '</li>';
        }
    }
    echo '</ol>';
    echo '<div id="add-cont" data-way="add">增加外卖地址</div>';
?>
<form action="contact.php" method="post" name="cont" onsubmit="return false;">
    <label for="name">联系人</label>
    <input type="text" id="name" name="name"><br>
    <label for="phone">电话</label>
    <input type="text" id="phone" name="phone"><br>
    <label for="address">地址</label>
    <textarea name="address" id="address" cols="30" rows="5"></textarea>
    <p></p>
    <input type="submit" name="submit" value="提交">
</form>
<script src="js/contact.js"></script>
<?php
    require('footer.php');
?>
<?php
    require('header.php');
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    } else {
        $_SESSION['confirm'] = 'confirm';
        echo '<link rel="stylesheet" href="css/order.css">';
        echo '<form action="confirm.php" method="post" name="order">';
        echo '<h3>消费方式</h3>';
        echo '<input type="radio" name="choice" class="choice" value="0" checked> 店内消费<br />';
        echo '<input type="radio" name="choice" class="choice" value="1"> 外卖';
        echo '<div id="contact-box">';
        $contact_result = mysql_query("SELECT * FROM contact WHERE userid = ".$_SESSION['USERID'].";");
        while ($contact_row = mysql_fetch_array($contact_result)) {
            echo '<div class="contact">';
            echo '<input type="radio" name="contact" value="'.$contact_row['id'].'" checked> 联系方式';
            echo '<p>联系人: '.$contact_row['name'].'</p>';
            echo '<p>联系电话: '.$contact_row['phone'].'</p>';
            echo '<p>外卖地址: '.$contact_row['address'].'</p>';
            echo '</div>';
        }
        echo '</div>';
        echo '<h3 class="order-list">订单列表</h3>';
        echo "<table border=1>";
        echo "<tr><td>菜名</td><td>单价（元）</td><td>数量</td></tr>";
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
        echo '<p class="sum-cost">总费用：'.$cost.'<span class="yuan">元</span></p>';
        echo '<input type="submit" value="提交订单">';
        echo "</form>";
    }?>
    <script type="text/javascript">
        var order = {
            choiceIn: document.order.choice[0],
            choiceOut: document.order.choice[1],
            contactBox: document.querySelector('#contact-box'),
            contactWay: document.querySelectorAll('.contact'),
            init: function () {
                this.checkContact();
            },
            checkContact: function () {
                var that = this;
                this.choiceOut.addEventListener('click', function () {
                    if (!that.contactWay.length) {
                        alert('无联系方式，请在联系方式里添加');
                        that.choiceIn.checked = true;
                    } else {
                        that.contactBox.style.display = 'block';
                    }
                }, false);
                this.choiceIn.addEventListener('click', function () {
                    that.contactBox.style.display = 'none';
                }, false);
            }
        };
        order.init();
    </script>
    <?php
    require('footer.php');
?>
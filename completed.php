<?php
    require('header.php');
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    }
?>
<link rel="stylesheet" href="css/completed.css">
    <?php
        $order_sql = "SELECT * FROM orders WHERE userid = ".$_SESSION['USERID']." ORDER BY id DESC;";
        $order_result = mysql_query($order_sql);
        while ($order_row = mysql_fetch_array($order_result)) {
            ?>
            <section class="orderbox">
                <div class="order-head">
                    <p class="order-index">订单号：<span class="order-id"><?php echo $order_row['id']; ?></span></p>
                    <p class="order-sell"><?php echo (!$order_row['outsell']) ? '店内消费' : '外卖'; ?></p>
                </div>
            <?php
            $detail_sql = "SELECT odetail.*, dish.* FROM odetail, dish WHERE orderid = ".$order_row['id']." AND dish.id = odetail.dishid;";
            $detail_result = mysql_query($detail_sql);
            $detail_num = 0;
            while ($detail_row = mysql_fetch_array($detail_result)) {
                ?>
                    <div class="dish-info">
                        <div class="dish-image" style="background: url(<?php echo $detail_row['image']; ?>) no-repeat center; background-size: auto 100%;"></div>
                        <div class="dish-name"><?php echo $detail_row['name']; ?></div>
                        <div class="dish-price">
                            <p><?php echo $detail_row['price']; ?><span class="yuan">元</span></p>
                            <p>x<?php echo $detail_row['num']; ?></p>
                        </div>
                    </div>
                <?php
                $detail_num += $detail_row['num'];
            }
            echo '<div class="order-sta">共 '.$detail_num.' 个菜&nbsp;&nbsp;&nbsp;实付：'.$order_row['sumcost'].'<span class="yuan">元</span></div></section>';
        }
    ?>
<?php
    require('footer.php');
?>
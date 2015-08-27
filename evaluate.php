<?php
    require('header.php');
    if (!isset($_SESSION['USERID'])) {
        header("Location: ".$config_basedir);
        exit();
    }
?>
<link rel="stylesheet" href="css/completed.css">
<link rel="stylesheet" href="css/evaluate.css">
<div class="shades"></div>
<section>
<?php
    $detail_sql = "SELECT orders.*, dish.*, odetail.* FROM orders, dish, odetail WHERE orders.userid = ".$_SESSION['USERID']." AND odetail.orderid = orders.id AND odetail.dishid = dish.id ORDER BY odetail.id DESC;";
    $detail_result = $mysqli->query($detail_sql);
    $star_arr = array('', '&#xe8f2;&#xe8f4;&#xe8f4;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f4;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;');
    while ($detail_row = $detail_result->fetch_array()) {
        ?>
        <div class="dish-box">
        <p>下单时间：<?php echo $detail_row[5]; ?></p>
        <div class="dish-info">
            <div class="dish-image" style="background: url(<?php echo $detail_row['image']; ?>) no-repeat center; background-size: auto 100%;"></div>
            <div class="dish-name"><?php echo $detail_row['name']; ?></div>
            <div class="dish-price">
                <p><?php echo $detail_row['price']; ?><span class="yuan">元</span></p>
                <p>x<?php echo $detail_row['num']; ?></p>
            </div>
        </div>
    <?php
        if (!$detail_row['evaluated']) {
            echo '<div class="evaluate" data-dish="'.$detail_row[6].'" data-detail="'.$detail_row[19].'">评价</div>';
            echo '</div>';
        } else {
            $eva_sql = "SELECT * FROM evaluate WHERE detailid = ".$detail_row[19].";";
            $eva_row = $mysqli->query($eva_sql)->fetch_array();
            echo '<p class="star">'.$star_arr[$eva_row['star']].' '.$eva_row['createtime'].'</p>';
            echo '<p class="content">'.$eva_row['content'].'</p>';
            echo '</div>';
        }
    }
?>
</section>
<form action="eva.php" method="post" name="evaluate" onsubmit="return false;">
    <h4>我的评价</h4>
    <div class="star-btn" data-star="1">&#xe8f4;</div>
    <div class="star-btn" data-star="2">&#xe8f4;</div>
    <div class="star-btn" data-star="3">&#xe8f4;</div>
    <div class="star-btn" data-star="4">&#xe8f4;</div>
    <div class="star-btn" data-star="5">&#xe8f4;</div>
    <textarea name="content" id="" cols="30" rows="6"></textarea>
    <input type="submit" name="submit" value="确定">
</form>
<script src="js/eva.js"></script>
<?php
    require('footer.php');
?>
<?php
    require('header.php');
    if (!isset($_SESSION['USERNAME'])) {
        header("Location: ".$config_basedir);
        exit();
    }
    if (!isset($_SESSION['USERID'])) {
        $user_row = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE username = '".$_SESSION['USERNAME']."';"));
        $_SESSION['USERID'] = $user_row['id'];
    }
?>
<link rel="stylesheet" href="css/home.css">
<div id="head">
    <div id="master">&#xe606;</div>
    <p class="master-name"><?php echo $_SESSION['USERNAME']; ?></p>
</div>
<div class="manager">
    <div class="e-mana">
        <a href="cart.php">&#xe675;</a>
        <p>购物车</p>
    </div>
    <div class="e-mana">
        <a href="completed.php">&#xe8bc;</a>
        <p>已完成订单</p>
    </div>
    <div class="e-mana">
        <a href="evaluate.php">&#xe8f2;</a>
        <p>我的评价</p>
    </div>
    <div class="e-mana">
        <a href="">&#xe6f2;</a>
        <p>联系方式</p>
    </div>
    <div class="e-mana">
        <a href="">&#xeafd;</a>
        <p>意见反馈</p>
    </div>
    <div class="e-mana">
        <a href="logout.php">&#xe626;</a>
        <p>退出</p>
    </div>
</div>
<?php
    require('footer.php');
?>
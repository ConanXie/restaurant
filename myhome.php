<?php
    session_start();
    require('header.php');
    if (!isset($_SESSION['USERNAME'])) {
        header("Location: ".$config_basedir);
        exit();
    }
?>
<link rel="stylesheet" href="css/home.css">
<div id="head">
    <div id="master">&#xe606;</div>
    <p class="master-name"><?php echo $_SESSION['USERNAME']; ?></p>
</div>
<div class="manager">
    <div class="e-mana">
        <a href="">&#xe675;</a>
        <p>购物车</p>
    </div>
    <div class="e-mana">
        <a href="">&#xe8bc;</a>
        <p>已完成订单</p>
    </div>
    <div class="e-mana">
        <a href="">&#xe8bb;</a>
        <p>待评价订单</p>
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